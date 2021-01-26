<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;


class ClientFactory extends Factory
{
    protected $model = ClientCreateController::class;
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
