<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;



class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'user'  => random_int(2, 5),
            'team' => random_int(2, 5),
            'summary_am' => $this->faker->title,
            'client_am' => 1,
            'contents_am' => $this->faker->title,
            'summary_pm' => $this->faker->title,
            'client_pm' => 1,
            'contents_pm' => $this->faker->title,
            'status' => 1,
        ];
    }
}
