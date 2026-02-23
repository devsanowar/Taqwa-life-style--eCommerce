<?php

namespace App\Models;

use App\Models\ProductBrand;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', 1);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // NEW: Get all color images through variants
    public function variantColorImages()
    {
        return $this->hasManyThrough(
            VariantColorImage::class,
            ProductVariant::class,
            'id',
            'variant_id',
            'id',
            'id'
        )->with('attributeValue.attribute');
    }


    protected $appends = ['final_price'];

    public function getFinalPriceAttribute()
    {
        if ($this->flash_sale_enabled) {
            if ($this->discount_type === 'percent') {
                return round($this->base_price - ($this->base_price * $this->discount_value / 100), 2);
            }

            if ($this->discount_type === 'fixed') {
                return round($this->base_price - $this->discount_value, 2);
            }
        }

        return $this->base_price;
    }
}
