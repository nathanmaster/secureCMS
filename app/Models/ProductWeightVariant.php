<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductWeightVariant extends Model
{
    protected $fillable = [
        'product_id',
        'default_weight_option_id',
        'custom_weight',
        'custom_label',
        'price',
        'is_available'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'custom_weight' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Get the product that owns this variant.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the default weight option.
     */
    public function defaultWeightOption(): BelongsTo
    {
        return $this->belongsTo(DefaultWeightOption::class);
    }

    /**
     * Get the effective weight (custom or from default option).
     */
    public function getEffectiveWeightAttribute()
    {
        if ($this->custom_weight) {
            return $this->custom_weight;
        }

        if ($this->defaultWeightOption) {
            // For ranges like '0-100', use middle value for display
            if ($this->defaultWeightOption->min_weight && $this->defaultWeightOption->max_weight) {
                return ($this->defaultWeightOption->min_weight + $this->defaultWeightOption->max_weight) / 2;
            }
            
            // For '1000+', use 1000
            if ($this->defaultWeightOption->value === '1000+') {
                return 1000;
            }
        }

        return null;
    }

    /**
     * Get the effective label (custom or from default option).
     */
    public function getEffectiveLabelAttribute()
    {
        if ($this->custom_label) {
            return $this->custom_label;
        }

        return $this->defaultWeightOption?->label ?? 'Custom Weight';
    }

    /**
     * Get formatted weight display.
     */
    public function getFormattedWeightAttribute(): string
    {
        if ($this->custom_weight) {
            if ($this->custom_weight >= 1000) {
                return number_format($this->custom_weight / 1000, 2) . ' kg';
            }
            return number_format($this->custom_weight, 0) . ' g';
        }

        return $this->defaultWeightOption?->label ?? 'Custom Weight';
    }
}
