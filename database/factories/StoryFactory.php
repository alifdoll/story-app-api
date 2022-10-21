<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(1),
            'description' => $this->faker->sentence(10),
            'image' => "https://doodleipsum.com/700x394/flat?i=36abfe5a9ef31c336bcf57f0dd0bd052"
        ];
    }
}
