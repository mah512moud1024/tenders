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
        $country = Country::create(['name' => 'United Arab Emirates']);



        // Create cities for UAE
        $uaeCities = [ 'Abu Dhabi', 'Dubai', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain',];
        $uae = Country::where('code', 'AE')->first();

        foreach ($uaeCities as $cityName) {
            City::create([
                'name' => $cityName,
                'country_id' => $country->id,
                'active' => true
            ]);
        }
    }
}
