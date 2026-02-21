<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $categoryIds = DB::table('product_categories')->pluck('id')->toArray();
        $brandIds = DB::table('product_brands')->pluck('id')->toArray();

        for ($i = 1; $i <= 20; $i++) {

            $name = $faker->words(3, true); // product name
            $slug = Str::slug($name . '-' . $i);

            $product = Product::create([
                'category_id'       => $faker->randomElement($categoryIds),
                'brand_id'          => $faker->optional()->randomElement($brandIds),
                'name'              => $name,
                'slug'              => $slug,
                'short_description' => $faker->sentence(8),
                'long_description'  => $faker->paragraph(4),
                'base_price'        => $faker->randomFloat(2, 50, 500),
                'discount_type'     => $faker->optional()->randomElement(['percent','fixed']),
                'discount_value'    => $faker->optional()->randomFloat(2, 5, 50),
                'featured'          => $faker->boolean(20), // 20% chance
                'status'            => 1,
                'flash_sale_enabled'=> $faker->boolean(10), // 10% chance
            ]);

            // Product Images
            $numImages = rand(1, 3); // each product 1-3 images
            for ($j = 1; $j <= $numImages; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => 'uploads/products/demo-img-'.$j.'.jpg', // replace with real images if needed
                    'is_primary' => $j === 1 ? 1 : 0,
                    'sort_order' => $j,
                ]);
            }
        }
    }
}
