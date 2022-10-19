<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'password' => '$2y$10$fgMVWvj7FrsJ7dfn.p7xp.9U7cT4jLSczPGpSKv4U.iKM73Y2inVa',
            'fullname' => $this->faker->name(),
            'gender' => $this->faker->randomElement(array ('Male','Female','Other')),
            'email' => $this->faker->unique()->safeEmail(),
            'birthday' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
            'avatar' => $this->faker->imageUrl(640,480),
            'phone' => $this->faker->unique()->e164PhoneNumber(),
            'status' => $this->faker->randomElement(array ('Active','Inactive')),
            'created_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
            'updated_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
        ];
    }
}
