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
            ['name' => 'United Arab Emirates', 'code' => 'AE', 'currency' => 'AED', 'active' => true],

        ];

        foreach ($countries as $countryData) {
            Country::create($countryData);
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
