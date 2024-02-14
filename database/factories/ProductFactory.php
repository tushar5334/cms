<?php

namespace Database\Factories;

use App\Models\Admin\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->sentence(5),
            'principal' => $this->faker->word(2),
            'country' => $this->faker->country,
            'status' => rand(0, 1),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ];
    }
}
