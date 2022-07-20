<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserCommentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->name(),
            'comments'=> $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        ];
    }
}
