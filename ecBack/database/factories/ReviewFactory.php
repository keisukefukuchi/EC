<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'item_id' => $this->faker->numberBetween(1, 3),
            'purchaser_id' => $this->faker->numberBetween(1, 3),
            'star' => $this->faker->numberBetween(1, 5),
            'content' => $this->faker->text(50),
        ];
    }
}