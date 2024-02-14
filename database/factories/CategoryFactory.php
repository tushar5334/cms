<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category_name = $this->faker->sentence(5);
        return [
            'category_name' => $category_name,
            'category_slug' => str_replace('--', '-', strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', trim($category_name)))),
            'parent_id' => 0,
            'category_image' => NULL,
            'status' => rand(0, 1),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ];
    }
}
