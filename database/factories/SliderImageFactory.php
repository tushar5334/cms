<?php

namespace Database\Factories;

use App\Models\Admin\SliderImage;
use App\Models\Admin\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SliderImageFactory extends Factory
{
    protected $model = SliderImage::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::limit(1)->get();
        return [
            'title'
            =>
            $this->faker->sentence(5),
            'description'
            => $this->faker->realText(rand(80, 255)),
            'status'
            => rand(0, 1),
            'slider_image'
            => NULL,
            'created_by'
            =>
            //User::factory(),
            $user[0]->user_id,
            'updated_by'
            =>
            //User::factory(),
            $user[0]->user_id,
            'created_at'
            => now(),
        ];
    }
}
