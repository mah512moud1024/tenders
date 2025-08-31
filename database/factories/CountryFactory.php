<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    public function definition()
    {
        $countries = [
            ['name' => 'Saudi Arabia', 'code' => 'SA', 'currency' => 'SAR'],
            ['name' => 'United Arab Emirates', 'code' => 'AE', 'currency' => 'AED'],
            ['name' => 'Kuwait', 'code' => 'KW', 'currency' => 'KWD'],
            ['name' => 'Qatar', 'code' => 'QA', 'currency' => 'QAR'],
            ['name' => 'Oman', 'code' => 'OM', 'currency' => 'OMR'],
            ['name' => 'Bahrain', 'code' => 'BH', 'currency' => 'BHD'],
        ];

        $country = $this->faker->randomElement($countries);

        return [
            'name' => $country['name'],
            'code' => $country['code'],
            'currency' => $country['currency'],
            'active' => true,
        ];
    }
}
