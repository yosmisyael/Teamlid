<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class employeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);

        return [
            'name' => $this->faker->name($gender),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->unique()->numerify('##########'),
            'birth_date' => $this->faker->dateTimeBetween('-50 years', '-20 years')->format('Y-m-d'),
            'address' => $this->faker->address(),
            'status' => 'active',
            'department_id' => null,
            'position_id' => null,
            'job_id' => null,
            'password' => bcrypt('test1234'),
        ];
    }

    public function active(): Factory {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }
}
