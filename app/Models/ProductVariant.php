<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $guarded = ['id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function values(){
        return $this->belongsToMany(AttributeValue::class, 'variant_values', 'variant_id', 'attribute_value_id')
            ->withPivot('attribute_id');
    }
}