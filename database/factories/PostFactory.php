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
            "title" => $this->faker->word(),
            "author_id" => User::all()->random()->id,
            "body" => $this->faker->sentence(),
            "image" => $this->faker->sentence(),
            "thumbnail" => $this->faker->sentence(),
            "publish_time" => $this->faker->dateTime(),
            "created_at" => $this->faker->dateTime(),
            "updated_at" => $this->faker->dateTime(),
        ];
    }
}
