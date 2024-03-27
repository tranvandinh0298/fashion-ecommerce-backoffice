<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(3, true);
        $slug = Str::of($name)->slug();
        $code = strtoupper('PRODUCT_' . Str::of($name)->snake());
        return [
            'name' => $name,
            'slug' => $slug,
            'code' => $code,
            'description' => $this->faker->paragraphs(4, true),
            'active' => 1,
        ];
    }
}
