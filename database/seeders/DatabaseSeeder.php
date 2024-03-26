<?php

namespace Database\Seeders;

use App\Models\Image;
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
        foreach($files as $file) {
            $images[] = [
                'caption' => $file,
                'address' => public_path($file),
                'active' => 1,
            ];
        }
        Image::truncate();
        DB::table('images')->insert($images);
    }
}
