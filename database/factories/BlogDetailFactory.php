<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogDetail>
 */
class BlogDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'blog_id' => $this->faker->randomElement(Blog::all())['id'],
            'cate_id' => $this->faker->randomElement(BlogCategory::all())['id'],
            'created_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
            'updated_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
        ];
    }
}
