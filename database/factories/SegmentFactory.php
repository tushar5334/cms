<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin\Segment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SegmentFactory extends Factory
{
    protected $model = Segment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'segment_name' => $this->faker->sentence(5),
            'segment_image' => NULL,
            'status' => rand(0, 1),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
        ];
    }
}
