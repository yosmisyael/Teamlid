<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Intern', 'Junior', 'Mid-Level', 'Senior', 'Lead']),
            'status' => $this->faker->randomElement(['available', 'unavailable']),
            'required_talents' => $this->faker->optional(0.7)->numberBetween(1, 5),
            'department_id' => Department::factory(),
            'job_id' => Job::factory(),
        ];
    }

    public function available(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }
}
