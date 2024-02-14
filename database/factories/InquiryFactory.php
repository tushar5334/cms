<?php

namespace Database\Factories;

use App\Models\Admin\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Inquiry>
 */
class InquiryFactory extends Factory
{
    protected $model = Inquiry::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'
            =>
            $this->faker->name,
            'phone'
            =>
            $this->faker->phoneNumber,
            'email'
            =>
            $this->faker->email,
            'product_looking_for'
            => $this->faker->realText(rand(80, 255)),
            'end_use_application'
            => $this->faker->realText(rand(80, 255)),
            'company_name'
            => $this->faker->company,
            'company_address'
            => $this->faker->address,
            'additional_remark'
            => $this->faker->realText(rand(80, 255)),
            'created_at'
            => now(),
        ];
    }
}
