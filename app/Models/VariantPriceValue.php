<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantPriceValue extends Model
{
    protected $guarded = ['id'];

    public function variant(){
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function attributeValue(){
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}