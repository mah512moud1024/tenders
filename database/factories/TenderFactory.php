<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\ProjectCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenderFactory extends Factory
{
    public function definition()
    {
        $tenderTypes = ['design', 'construction', 'supply'];
        $projectTypes = ['building', 'roads'];
        $workTypes = ['maintenance', 'new_construction', 'completion'];
        $statuses = ['draft', 'pending', 'published', 'assigned', 'completed'];

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'user_id' => User::where('type', 'client')->inRandomOrder()->first()->id ??
                User::factory()->client()->create()->id,
            'city_id' => City::inRandomOrder()->first()->id ?? CityFactory::new()->create()->id,
            'area' => $this->faker->citySuffix,
            'project_type' => $this->faker->randomElement($projectTypes),
            'work_type' => $this->faker->randomElement($workTypes),
            'tender_type' => $this->faker->randomElement($tenderTypes),
            'category_id' => ProjectCategory::inRandomOrder()->first()->id ??
                ProjectCategoryFactory::new()->create()->id,
            'floors' => $this->faker->numberBetween(1, 10),
            'building_area' => $this->faker->randomFloat(2, 100, 10000),
            'land_area' => $this->faker->randomFloat(2, 200, 20000),
            'required_service' => $this->faker->randomElement(['Painting', 'Plumbing', 'Electrical', 'AC']),
            'status' => $this->faker->randomElement($statuses),
            'closing_date' => $this->faker->dateTimeBetween('now', '+30 days'),
        ];
    }

    public function design()
    {
        return $this->state(function (array $attributes) {
            return [
                'tender_type' => 'design',
            ];
        });
    }

    public function construction()
    {
        return $this->state(function (array $attributes) {
            return [
                'tender_type' => 'construction',
            ];
        });
    }

    public function supply()
    {
        return $this->state(function (array $attributes) {
            return [
                'tender_type' => 'supply',
            ];
        });
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'published',
            ];
        });
    }
}
