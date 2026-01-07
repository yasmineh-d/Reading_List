<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
        'username' => $this->faker->userName(),
        'email' => $this->faker->unique()->safeEmail(),
    ];
    }
}
