<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tender;
use App\Models\User;
use App\Models\City;
use App\Models\ProjectCategory;

class TenderSeeder extends Seeder
{
    public function run()
    {
        $clients = User::where('type', 'client')->get();
        $cities = City::all();
        $categories = ProjectCategory::whereNull('parent_id')->get();

        // Create design tenders
        for ($i = 1; $i <= 7; $i++) {
            Tender::create([
                'title' => 'Design Tender ' . $i,
                'description' => 'We need design services for our new project. ' . $i,
                'user_id' => $clients->random()->id,
                'city_id' => $cities->random()->id,
                'area' => 'Area ' . $i,
                'project_type' => 'building',
                'work_type' => 'new_construction',
                'tender_type' => 'design',
                'category_id' => $categories->random()->id,
                'floors' => rand(1, 5),
                'building_area' => rand(300, 1000),
                'land_area' => rand(500, 2000),
                'required_service' => null,
                'status' => 'published',
                'closing_date' => now()->addDays(rand(7, 30)),
            ]);
        }

        // Create construction tenders
        for ($i = 1; $i <= 7; $i++) {
            Tender::create([
                'title' => 'Construction Tender ' . $i,
                'description' => 'We need construction services for our new project. ' . $i,
                'user_id' => $clients->random()->id,
                'city_id' => $cities->random()->id,
                'area' => 'Area ' . $i,
                'project_type' => 'building',
                'work_type' => 'new_construction',
                'tender_type' => 'construction',
                'category_id' => $categories->random()->id,
                'floors' => rand(1, 10),
                'building_area' => rand(500, 5000),
                'land_area' => rand(1000, 10000),
                'required_service' => null,
                'status' => 'published',
                'closing_date' => now()->addDays(rand(7, 30)),
            ]);
        }

        // Create supply tenders
        for ($i = 1; $i <= 6; $i++) {
            Tender::create([
                'title' => 'Supply Tender ' . $i,
                'description' => 'We need supply services for our new project. ' . $i,
                'user_id' => $clients->random()->id,
                'city_id' => $cities->random()->id,
                'area' => 'Area ' . $i,
                'project_type' => 'building',
                'work_type' => 'new_construction',
                'tender_type' => 'supply',
                'category_id' => $categories->random()->id,
                'floors' => null,
                'building_area' => null,
                'land_area' => null,
                'required_service' => 'Supply of materials for construction',
                'status' => 'published',
                'closing_date' => now()->addDays(rand(7, 30)),
            ]);
        }
    }
}
