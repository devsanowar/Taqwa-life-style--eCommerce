<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = ['id'];

    // Parent Menu relation
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Child Menus relation
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
