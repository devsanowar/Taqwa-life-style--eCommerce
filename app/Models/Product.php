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

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand() {
        return $this->belongsTo(ProductBrand::class, 'brand_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage() {
        return $this->hasOne(ProductImage::class)->where('is_primary', 1);
    }
}
