<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\This;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        for ($i = 1; $i <= 12; $i++) {
            Post::create([
                'title'            => "Sample Post Title $i",
                'slug'             => Str::slug("Sample Post Title $i"),
                'category_id'      => 1,
                'excerpt'          => "This is a short excerpt for post $i.",
                'description'      => "This is the full description content of post $i. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                'thumbnail'        => 'uploads/post_images/default.png',
                'status'           => 1,
                'user_id'     => $user->id,
            ]);
        }
    }
}
