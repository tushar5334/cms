<?php

namespace Database\Factories;

use App\Models\Admin\Company;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->sentence(5),
            'company_image' => NULL,
            'status' => rand(0, 1),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ];
    }
}
