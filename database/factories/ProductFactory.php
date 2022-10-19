<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_code' => $this->faker->unique()->isbn10(),
            'product_name' => $this->faker->unique()->text(200),
            'product_slug' => $this->faker->unique()->text(200),
            'image' => $this->faker->imageUrl(640,480),
            'short_description' => $this->faker->unique()->text(500),
            'description' => $this->faker->unique()->text(1000),
            'is_continued' => $this->faker->randomElement(array("Continued","Discontinued")),
            'is_featured' => $this->faker->randomElement(array("Featured","Not featured")),
            'is_new' => $this->faker->randomElement(array("New","Not new")),
            'category_id' => $this->faker->randomElement(Category::all())['id'],
            'supplier_id' => $this->faker->randomElement(Supplier::all())['id'],
            'created_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
            'updated_at' => $this->faker->dateTime('now','Asia/Ho_Chi_Minh'),
        ];
    }
}
