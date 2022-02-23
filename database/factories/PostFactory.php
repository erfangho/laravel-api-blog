<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            "title" => $this->faker->word() . ' blog',
            "body" => $this->faker->sentence(),
            "image" => $this->faker->imageUrl(),
            "thumbnail" => $this->faker->imageUrl(),
            "publish_time" => $this->faker->dateTime(),
            "created_at" => $this->faker->dateTime(),
            "updated_at" => $this->faker->dateTime(),
        ];
    }
}
