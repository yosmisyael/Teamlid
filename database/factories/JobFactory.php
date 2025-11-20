<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $minSalary = $this->faker->numberBetween(5_000_000, 20_000_000);

        return [
            'name' => $this->faker->unique()->jobTitle(),
            'min_salary' => $minSalary,
            'max_salary' => $minSalary + $this->faker->numberBetween(10000, 50000),
            'department_id' => Department::factory(),
        ];
    }
}
