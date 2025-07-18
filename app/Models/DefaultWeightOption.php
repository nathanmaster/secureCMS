<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultWeightOption extends Model
{
    protected $fillable = [
        'value',
        'label',
        'min_weight',
        'max_weight',
        'is_active',
        'sort_order',
        'is_set_value',
        'set_weight'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_set_value' => 'boolean',
        'min_weight' => 'decimal:2',
        'max_weight' => 'decimal:2',
        'set_weight' => 'decimal:2',
    ];

    /**
     * Scope to get only active weight options
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if this is a set value option (e.g., 3.5g = "1/8")
     */
    public function isSetValue()
    {
        return $this->is_set_value;
    }

    /**
     * Get the weight value for this option
     */
    public function getWeightValue()
    {
        return $this->is_set_value ? $this->set_weight : null;
    }

    /**
     * Check if a weight matches this option
     */
    public function matchesWeight($weight)
    {
        if ($this->is_set_value) {
            return abs($weight - $this->set_weight) < 0.01; // Allow small tolerance
        }

        if ($this->value === '1000+') {
            return $weight > 1000;
        }

        return $weight >= $this->min_weight && $weight <= $this->max_weight;
    }
}
