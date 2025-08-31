<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    public function definition()
    {
        $saudiCities = [
            'Riyadh', 'Jeddah', 'Mecca', 'Medina', 'Dammam',
            'Khobar', 'Dhahran', 'Taif', 'Tabuk', 'Abha'
        ];

        return [
            'name' => $this->faker->randomElement($saudiCities),
            'country_id' => Country::inRandomOrder()->first()->id ?? CountryFactory::new()->create()->id,
            'active' => true,
        ];
    }
}
