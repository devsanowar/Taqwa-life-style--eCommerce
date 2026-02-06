<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $electronics = ProductCategory::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'parent_id' => null,
            'status' => true,
        ]);

        $mobiles = ProductCategory::create([
            'name' => 'Mobiles',
            'slug' => 'mobiles',
            'parent_id' => $electronics->id,
            'status' => true,
        ]);

        ProductCategory::create([
            'name' => 'Smartphones',
            'slug' => 'smartphones',
            'parent_id' => $mobiles->id,
            'status' => true,
        ]);
    }

}

