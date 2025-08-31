<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;

class CountryCitySeeder extends Seeder
{
    public function run()
    {
        // Create countries
        $countries = [
            ['name' => 'Saudi Arabia', 'code' => 'SA', 'currency' => 'SAR', 'active' => true],
            ['name' => 'United Arab Emirates', 'code' => 'AE', 'currency' => 'AED', 'active' => true],
            ['name' => 'Kuwait', 'code' => 'KW', 'currency' => 'KWD', 'active' => true],
            ['name' => 'Qatar', 'code' => 'QA', 'currency' => 'QAR', 'active' => true],
            ['name' => 'Oman', 'code' => 'OM', 'currency' => 'OMR', 'active' => true],
            ['name' => 'Bahrain', 'code' => 'BH', 'currency' => 'BHD', 'active' => true],
        ];

        foreach ($countries as $countryData) {
            Country::create($countryData);
        }

        // Create cities for Saudi Arabia
        $saudiCities = [
            'Riyadh', 'Jeddah', 'Mecca', 'Medina', 'Dammam',
            'Khobar', 'Dhahran', 'Taif', 'Tabuk', 'Abha'
        ];

        $saudiArabia = Country::where('code', 'SA')->first();

        foreach ($saudiCities as $cityName) {
            City::create([
                'name' => $cityName,
                'country_id' => $saudiArabia->id,
                'active' => true
            ]);
        }

        // Create cities for UAE
        $uaeCities = ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Fujairah'];
        $uae = Country::where('code', 'AE')->first();

        foreach ($uaeCities as $cityName) {
            City::create([
                'name' => $cityName,
                'country_id' => $uae->id,
                'active' => true
            ]);
        }
    }
}
