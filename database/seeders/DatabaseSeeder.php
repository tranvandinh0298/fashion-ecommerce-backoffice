<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // user
        User::truncate();
        User::factory()->count(50)->create();

        // image
        $files = Storage::disk('images')->files();
        $images = [];
        foreach ($files as $file) {
            $images[] = [
                'caption' => $file,
                'address' => public_path($file),
                'status' => 1,
            ];
        }
        Image::truncate();
        DB::table('images')->insert($images);

        Category::truncate();
        DB::table("categories")->insert([
            [
                'name' => 'Men',
                'slug' => 'men',
                'description' => 'Men clothing',
                'status' => 1,
                'image_id' => Image::all()->random()->id,
            ],
            [
                'name' => 'Bag',
                'slug' => 'bag',
                'description' => 'Bag',
                'status' => 1,
                'image_id' => Image::all()->random()->id,
            ],
            [
                'name' => 'Shoes',
                'slug' => 'shoes',
                'description' => 'Shoes',
                'status' => 1,
                'image_id' => Image::all()->random()->id,
            ],
            [
                'name' => 'Watches',
                'slug' => 'watches',
                'description' => 'Watches',
                'status' => 1,
                'image_id' => Image::all()->random()->id,
            ]
        ]);

        // Truncate the pivot table
        // DB::table('category_product')->truncate();
        // Product::truncate();
        // Product::factory()->count(50)->create()->each(function ($product) {
        //     // Attach random categories to each product
        //     $categories = Category::all()->pluck('id')->random(); // Randomly select 1 to 3 category IDs
        //     $product->categories()->attach($categories);
        // });

        // 
    }
}
