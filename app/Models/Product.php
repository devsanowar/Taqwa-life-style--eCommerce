<?php
namespace App\Models;

use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function calculateDiscount($price)
    {
        if (! $this->flash_sale_enabled || ! $this->discount_type || ! $this->discount_value) {
            return $price;
        }

        if ($this->discount_type === 'percent') {
            $price = $price - ($price * $this->discount_value / 100);
        }

        if ($this->discount_type === 'fixed') {
            $price = $price - $this->discount_value;
        }

        return max($price, 0);
    }

    public function getSortedImagesAttribute()
    {
        return $this->images->sortByDesc('is_primary');
    }


    public function getFinalPriceAttribute()
    {
        return $this->calculateDiscount($this->base_price);
    }



}
