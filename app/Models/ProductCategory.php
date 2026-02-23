<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Parent category
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Direct children only (status = 1)
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->where('status', 1);
    }

    /**
     * Recursive children with their products
     * (used only if you want to fetch all descendants in one query)
     */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive', 'products');
    }

    /**
     * Products in this category
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
