<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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


        DB::table('coupons')->truncate();
        $data = array(
            array(
                'code' => 'abc123',
                'type' => 'fixed',
                'value' => '300',
                'status' => 'active'
            ),
            array(
                'code' => '111111',
                'type' => 'percent',
                'value' => '10',
                'status' => 'active'
            ),
        );
        DB::table('coupons')->insert($data);

        DB::table('settings')->truncate();
        $data = array(
            'description' => "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. sed ut perspiciatis unde sunt in culpa qui officia deserunt mollit anim id est laborum. sed ut perspiciatis unde omnis iste natus error sit voluptatem Excepteu

                            sunt in culpa qui officia deserunt mollit anim id est laborum. sed ut perspiciatis Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. sed ut perspi deserunt mollit anim id est laborum. sed ut perspi.",
            'short_des' => "Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.",
            'photo' => "image.jpg",
            'logo' => 'logo.jpg',
            'address' => "115 Test Street, Test Country",
            'email' => "codeastro.com",
            'phone' => "1234567777",
        );
        DB::table('settings')->insert($data);

        // user
        DB::table('settings')->truncate();
        User::factory()->count(50)->create();
        $data = array(
            array(
                'name' => 'CodeAstro',
                'email' => 'admin@mail.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'status' => 'active'
            ),
            array(
                'name' => 'Customer A',
                'email' => 'customer@mail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'active'
            ),
        );

        DB::table('users')->insert($data);
    }
}
