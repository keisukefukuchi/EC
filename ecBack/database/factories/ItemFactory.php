<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 6000),
            'explanation' => $this->faker->text(50),
            'stock' => $this->faker->numberBetween(0, 20),
            'public' => 1,
            'recommendation' => $this->faker->numberBetween(0, 1),
            'slogan' => $this->faker->text(40),
            'recommendation_image' => '/storage/sample.jpg',
            'category_id' => $this->faker->numberBetween(1, 8),
        ];
    }
}