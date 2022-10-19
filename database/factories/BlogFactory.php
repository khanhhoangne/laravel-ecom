<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(200),
            'slug' => $this->faker->unique()->text(200),
            'subtitle' => $this->faker->unique()->text(500),
            'content' => $this->faker->unique()->text(1000),
            'thumbnail' => "https://picsum.photos/id/".$this->faker->numberBetween(100,900)."/200/300",
            'status' => $this->faker->randomElement(array(1,0)),
            'author' => $this->faker->name('male'|'female'),
            'view' => $this->faker->numberBetween(1000,9000),
            'created_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
            'updated_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
        ];
    }
}
