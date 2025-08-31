<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceAreaFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::where('type', '!=', 'client')->inRandomOrder()->first()->id ??
                User::factory()->consultant()->create()->id,
            'city_id' => City::inRandomOrder()->first()->id ?? CityFactory::new()->create()->id,
        ];
    }
}
