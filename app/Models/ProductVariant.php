<?php

namespace App\Models;

use App\Models\VariantValue;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_values', 'variant_id', 'attribute_value_id')
            ->withPivot('attribute_id');
    }

    public function valuePrices()
    {
        return $this->hasMany(VariantPriceValue::class, 'variant_id');
    }

    public function colorImages()
    {
        return $this->hasMany(VariantColorImage::class, 'variant_id');
    }

    public function variantValues()
    {
        return $this->hasMany(VariantValue::class, 'variant_id');
    }

    public function balance()
    {
        return $this->hasOne(InventoryBalance::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
