<?php

namespace App\Services;

use App\Models\Product;
use App\Models\DefaultWeightOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductFilterService
{
    /**
     * Apply all filters to the product query
     */
    public function applyFilters(Builder $query, array $filters): Builder
    {
        // Search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'LIKE', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'LIKE', '%' . $filters['search'] . '%');
            });
        }

        // Category filter
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // Subcategory filter
        if (!empty($filters['subcategory'])) {
            $query->where('subcategory_id', $filters['subcategory']);
        }

        // Price range filter (based on selected weight)
        if (!empty($filters['min_price']) || !empty($filters['max_price'])) {
            $this->applyPriceFilter($query, $filters);
        }

        // Weight filter
        if (!empty($filters['weights'])) {
            $this->applyWeightFilter($query, $filters['weights']);
        }

        // Percentage filter
        if (!empty($filters['min_percentage']) || !empty($filters['max_percentage'])) {
            $minPercentage = $filters['min_percentage'] ?? 0;
            $maxPercentage = $filters['max_percentage'] ?? 100;
            $query->whereBetween('percentage', [$minPercentage, $maxPercentage]);
        }

        // Availability filter
        if (!empty($filters['availability'])) {
            $this->applyAvailabilityFilter($query, $filters['availability']);
        }

        return $query;
    }

    /**
     * Apply price filter considering selected weight
     */
    private function applyPriceFilter($query, array $filters): void
    {
        $minPrice = $filters['min_price'] ?? null;
        $maxPrice = $filters['max_price'] ?? null;
        $selectedWeight = $filters['selected_weight'] ?? null;

        if ($selectedWeight) {
            // Filter by specific weight price
            $query->whereHas('weightVariants', function ($q) use ($minPrice, $maxPrice, $selectedWeight) {
                $q->where('custom_weight', $selectedWeight);
                if ($minPrice !== null) {
                    $q->where('price', '>=', $minPrice);
                }
                if ($maxPrice !== null) {
                    $q->where('price', '<=', $maxPrice);
                }
            });
        } else {
            // Filter by base price or lowest weight price
            $query->where(function ($q) use ($minPrice, $maxPrice) {
                if ($minPrice !== null) {
                    $q->where('price', '>=', $minPrice);
                }
                if ($maxPrice !== null) {
                    $q->where('price', '<=', $maxPrice);
                }
            });
        }
    }

    /**
     * Apply weight filter
     */
    private function applyWeightFilter($query, array $weights): void
    {
        $query->where(function ($q) use ($weights) {
            // Normalize the filter weights for comparison
            $normalizedFilterWeights = [];
            foreach ($weights as $weight) {
                $normalized = $this->normalizeWeight($weight);
                if ($normalized !== null) {
                    $normalizedFilterWeights[] = $normalized;
                }
                // Also include the original weight value for exact matches
                $normalizedFilterWeights[] = $weight;
            }
            
            $normalizedFilterWeights = array_unique($normalizedFilterWeights);
            
            // Filter by base weight (compare both original and normalized)
            $q->where(function ($baseQ) use ($weights, $normalizedFilterWeights) {
                foreach ($weights as $weight) {
                    $baseQ->orWhere('weight', $weight);
                    // Also check if the normalized weight matches
                    $normalized = $this->normalizeWeight($weight);
                    if ($normalized !== null) {
                        $baseQ->orWhereRaw('? IN (weight)', [$normalized]);
                    }
                }
            })
            // Or filter by weight variants
            ->orWhereHas('weightVariants', function ($subQ) use ($weights, $normalizedFilterWeights) {
                $subQ->where(function ($variantQ) use ($weights, $normalizedFilterWeights) {
                    // Check custom weight (both original and normalized)
                    foreach ($weights as $weight) {
                        $variantQ->orWhere('custom_weight', $weight);
                        $normalized = $this->normalizeWeight($weight);
                        if ($normalized !== null) {
                            $variantQ->orWhereRaw('? = custom_weight', [$normalized]);
                        }
                    }
                    
                    // Check default weight option value
                    $variantQ->orWhereHas('defaultWeightOption', function ($defaultQ) use ($weights) {
                        $defaultQ->whereIn('value', $weights);
                    });
                });
            });
        });
    }

    /**
     * Apply availability filter
     */
    private function applyAvailabilityFilter($query, array $availability): void
    {
        if (count($availability) === 1) {
            if (in_array('available', $availability)) {
                $query->where('is_available', true);
            } elseif (in_array('unavailable', $availability)) {
                $query->where('is_available', false);
            }
        }
        // If both selected, don't filter (show all)
    }

    /**
     * Apply sorting with weight consideration
     */
    public function applySorting(Builder $query, string $sortBy, string $direction, ?string $selectedWeight = null): Builder
    {
        switch ($sortBy) {
            case 'price':
                if ($selectedWeight) {
                    // Sort by specific weight price - need to handle both exact matches and normalized matches
                    $normalizedWeight = $this->normalizeWeight($selectedWeight);
                    
                    $query->leftJoin('product_weight_variants as pwv_sort', function ($join) use ($selectedWeight, $normalizedWeight) {
                        $join->on('products.id', '=', 'pwv_sort.product_id')
                             ->where(function ($query) use ($selectedWeight, $normalizedWeight) {
                                 // Check for exact match first
                                 $query->where('pwv_sort.custom_weight', '=', $selectedWeight);
                                 
                                 // Also check normalized weight if different
                                 if ($normalizedWeight !== null && $normalizedWeight != $selectedWeight) {
                                     $query->orWhere('pwv_sort.custom_weight', '=', $normalizedWeight);
                                 }
                                 
                                 // Check default weight option value
                                 $query->orWhereExists(function ($subQuery) use ($selectedWeight) {
                                     $subQuery->select(\DB::raw(1))
                                             ->from('default_weight_options as dwo')
                                             ->whereColumn('dwo.id', 'pwv_sort.default_weight_option_id')
                                             ->where('dwo.value', $selectedWeight);
                                 });
                             });
                    })
                    ->orderByRaw("COALESCE(pwv_sort.price, products.price) {$direction}")
                    ->select('products.*');
                } else {
                    // Sort by base price
                    $query->orderBy('price', $direction);
                }
                break;

            case 'weight':
                if ($selectedWeight) {
                    // When specific weight selected, sort by that weight (handle both exact and normalized)
                    $normalizedWeight = $this->normalizeWeight($selectedWeight);
                    
                    if ($normalizedWeight !== null && $normalizedWeight != $selectedWeight) {
                        // Sort by both exact and normalized weight matches
                        $query->orderByRaw("CASE WHEN weight = ? OR weight = ? THEN 0 ELSE 1 END", [$selectedWeight, $normalizedWeight])
                              ->orderBy('weight', $direction);
                    } else {
                        // Sort by exact weight match
                        $query->orderByRaw("CASE WHEN weight = ? THEN 0 ELSE 1 END", [$selectedWeight])
                              ->orderBy('weight', $direction);
                    }
                } else {
                    $query->orderBy('weight', $direction);
                }
                break;

            case 'name':
                $query->orderBy('name', $direction);
                break;

            case 'percentage':
                $query->orderBy('percentage', $direction);
                break;

            case 'rating':
                $query->withAvg('ratings', 'rating')
                      ->orderBy('ratings_avg_rating', $direction);
                break;

            default:
                $query->orderBy('name', 'asc');
        }

        return $query;
    }

    /**
     * Get available weight options for filters
     */
    public function getAvailableWeightOptions(): Collection
    {
        // Get default weight options
        $defaultOptions = DefaultWeightOption::orderBy('sort_order')->get()
            ->map(function ($option) {
                return (object) [
                    'value' => $option->value,
                    'label' => $option->label,
                    'is_set_value' => $option->is_set_value
                ];
            });
        
        // Get unique weights from products and weight variants
        $productWeights = Product::whereNotNull('weight')
            ->distinct()
            ->pluck('weight')
            ->filter(function ($weight) {
                return $this->normalizeWeight($weight) !== null;
            })
            ->map(function ($weight) {
                return (object) [
                    'value' => $weight,
                    'label' => $this->formatWeight($weight),
                    'is_set_value' => true
                ];
            });

        // Get custom weights from variants (where custom_weight is not null)
        $variantCustomWeights = \DB::table('product_weight_variants')
            ->distinct()
            ->whereNotNull('custom_weight')
            ->pluck('custom_weight')
            ->filter(function ($weight) {
                return $this->normalizeWeight($weight) !== null;
            })
            ->map(function ($weight) {
                return (object) [
                    'value' => $weight,
                    'label' => $this->formatWeight($weight),
                    'is_set_value' => true
                ];
            });

        // Get weights from variants that use default weight options
        $variantDefaultWeights = \DB::table('product_weight_variants as pwv')
            ->join('default_weight_options as dwo', 'pwv.default_weight_option_id', '=', 'dwo.id')
            ->whereNotNull('pwv.default_weight_option_id')
            ->distinct()
            ->pluck('dwo.value')
            ->filter(function ($weight) {
                return $this->normalizeWeight($weight) !== null;
            })
            ->map(function ($weight) {
                return (object) [
                    'value' => $weight,
                    'label' => $this->formatWeight($weight),
                    'is_set_value' => true
                ];
            });

        // Combine and deduplicate
        $allWeights = $defaultOptions->merge($productWeights)->merge($variantCustomWeights)->merge($variantDefaultWeights)
            ->unique('value')
            ->sortBy(function ($option) {
                return $this->normalizeWeight($option->value) ?? 999999; // Put unparseable weights at the end
            })
            ->values();

        return $allWeights;
    }

    /**
     * Get weight options for a specific product
     */
    public function getProductWeightOptions(Product $product): Collection
    {
        $options = collect();

        // Add base weight if exists
        if ($product->weight) {
            $options->push((object) [
                'value' => $product->weight,
                'label' => $this->formatWeight($product->weight),
                'price' => $product->price,
                'is_default' => true
            ]);
        }

        // Add weight variants
        $variants = $product->weightVariants()->with('defaultWeightOption')->get();
        foreach ($variants as $variant) {
            // Get the effective weight (custom or from default option)
            $effectiveWeight = $variant->custom_weight ?? $variant->defaultWeightOption?->value;
            $effectiveLabel = $variant->custom_label ?? $variant->defaultWeightOption?->label ?? $this->formatWeight($effectiveWeight);
            
            if ($effectiveWeight) {
                $options->push((object) [
                    'value' => $effectiveWeight,
                    'label' => $effectiveLabel,
                    'price' => $variant->price,
                    'is_default' => false
                ]);
            }
        }

        // Sort by normalized weight value and ensure lowest is first (default)
        return $options->sortBy(function ($option) {
            return $this->normalizeWeight($option->value) ?? 999999; // Put unparseable weights at the end
        })->values();
    }

    /**
     * Get price for specific weight
     */
    public function getPriceForWeight(Product $product, $weight): ?float
    {
        $normalizedWeight = $this->normalizeWeight($weight);
        
        // Check if it's the base weight (exact match or normalized match)
        if ($product->weight == $weight || 
            ($normalizedWeight !== null && $this->normalizeWeight($product->weight) == $normalizedWeight)) {
            return $product->price;
        }

        // Check weight variants with custom weights (exact match)
        $variant = $product->weightVariants()->where('custom_weight', $weight)->first();
        if ($variant) {
            return $variant->price;
        }
        
        // Check weight variants with custom weights (normalized match)
        if ($normalizedWeight !== null) {
            $variant = $product->weightVariants()->where('custom_weight', $normalizedWeight)->first();
            if ($variant) {
                return $variant->price;
            }
        }

        // Check weight variants with default weight options
        $variant = $product->weightVariants()
            ->whereHas('defaultWeightOption', function ($query) use ($weight) {
                $query->where('value', $weight);
            })
            ->first();
        
        return $variant ? $variant->price : null;
    }

    /**
     * Normalize weight value to grams for comparison
     */
    private function normalizeWeight($weight): ?float
    {
        if ($weight === null || $weight === '') {
            return null;
        }
        
        // If it's already numeric, assume it's in grams
        if (is_numeric($weight)) {
            return floatval($weight);
        }
        
        // Handle string weights with units
        if (is_string($weight)) {
            $weight = trim($weight);
            
            // Handle oz (ounce) - convert to grams (1 oz = 28.3495 grams)
            if (preg_match('/^(\d*\.?\d+)\s*oz$/i', $weight, $matches)) {
                return floatval($matches[1]) * 28.3495;
            }
            
            // Handle g (grams)
            if (preg_match('/^(\d*\.?\d+)\s*g$/i', $weight, $matches)) {
                return floatval($matches[1]);
            }
            
            // Handle kg (kilograms) - convert to grams
            if (preg_match('/^(\d*\.?\d+)\s*kg$/i', $weight, $matches)) {
                return floatval($matches[1]) * 1000;
            }
            
            // Handle mg (milligrams) - convert to grams
            if (preg_match('/^(\d*\.?\d+)\s*mg$/i', $weight, $matches)) {
                return floatval($matches[1]) / 1000;
            }
            
            // If no unit but numeric, assume grams
            if (preg_match('/^(\d*\.?\d+)$/', $weight, $matches)) {
                return floatval($matches[1]);
            }
        }
        
        return null;
    }

    /**
     * Format weight for display
     */
    private function formatWeight($weight): string
    {
        // Handle null or empty values
        if ($weight === null || $weight === '') {
            return 'N/A';
        }
        
        // If it's already a formatted string with units, return as-is
        if (is_string($weight) && preg_match('/^\d*\.?\d+\s*(mg|g|kg|oz)$/i', $weight)) {
            return $weight;
        }
        
        // Normalize to grams for consistent formatting
        $normalizedWeight = $this->normalizeWeight($weight);
        
        if ($normalizedWeight === null) {
            return strval($weight); // Return original if we can't parse it
        }
        
        // Format based on normalized weight (in grams)
        if ($normalizedWeight < 1) {
            return number_format($normalizedWeight * 1000, 0) . 'mg';
        } elseif ($normalizedWeight < 1000) {
            return number_format($normalizedWeight, $normalizedWeight == floor($normalizedWeight) ? 0 : 1) . 'g';
        } else {
            return number_format($normalizedWeight / 1000, 2) . 'kg';
        }
    }

    /**
     * Get default weight for product (lowest available)
     */
    public function getDefaultWeight(Product $product): ?float
    {
        $options = $this->getProductWeightOptions($product);
        $firstOption = $options->first();
        
        if (!$firstOption) {
            return null;
        }
        
        // Normalize the weight value to ensure we return a float
        return $this->normalizeWeight($firstOption->value);
    }

    /**
     * Calculate price range for slider
     */
    public function getPriceRange(?string $selectedWeight = null): object
    {
        if ($selectedWeight) {
            // Get price range for specific weight
            $prices = collect();
            
            // From base products
            $basePrices = Product::where('weight', $selectedWeight)->pluck('price');
            $prices = $prices->merge($basePrices);
            
            // From weight variants with custom weights
            $variantCustomPrices = \DB::table('product_weight_variants')
                ->where('custom_weight', $selectedWeight)
                ->pluck('price');
            $prices = $prices->merge($variantCustomPrices);
            
            // From weight variants with default weight options
            $variantDefaultPrices = \DB::table('product_weight_variants as pwv')
                ->join('default_weight_options as dwo', 'pwv.default_weight_option_id', '=', 'dwo.id')
                ->where('dwo.value', $selectedWeight)
                ->pluck('pwv.price');
            $prices = $prices->merge($variantDefaultPrices);
            
            return (object)[
                'min_price' => $prices->min() ?? 0,
                'max_price' => $prices->max() ?? 1000
            ];
        }

        // Default price range (all products)
        return (object)[
            'min_price' => Product::min('price') ?? 0,
            'max_price' => Product::max('price') ?? 1000
        ];
    }
}
