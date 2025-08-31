<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;

class ProjectCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // Main Categories
            [
                'name' => 'Residential',
                'slug' => 'residential',
                'description' => 'Residential building projects',
                'parent_id' => null,
                'order' => 1,
                'active' => true
            ],
            [
                'name' => 'Commercial',
                'slug' => 'commercial',
                'description' => 'Commercial building projects',
                'parent_id' => null,
                'order' => 2,
                'active' => true
            ],
            [
                'name' => 'Industrial',
                'slug' => 'industrial',
                'description' => 'Industrial building projects',
                'parent_id' => null,
                'order' => 3,
                'active' => true
            ],
            [
                'name' => 'Infrastructure',
                'slug' => 'infrastructure',
                'description' => 'Infrastructure projects',
                'parent_id' => null,
                'order' => 4,
                'active' => true
            ],
            [
                'name' => 'Institutional',
                'slug' => 'institutional',
                'description' => 'Institutional building projects',
                'parent_id' => null,
                'order' => 5,
                'active' => true
            ],

            // Subcategories for Residential
            [
                'name' => 'Villa',
                'slug' => 'villa',
                'description' => 'Villa construction projects',
                'parent_id' => 1,
                'order' => 1,
                'active' => true
            ],
            [
                'name' => 'Apartment',
                'slug' => 'apartment',
                'description' => 'Apartment building projects',
                'parent_id' => 1,
                'order' => 2,
                'active' => true
            ],
            [
                'name' => 'Compound',
                'slug' => 'compound',
                'description' => 'Residential compound projects',
                'parent_id' => 1,
                'order' => 3,
                'active' => true
            ],

            // Subcategories for Commercial
            [
                'name' => 'Shopping Mall',
                'slug' => 'shopping-mall',
                'description' => 'Shopping mall construction projects',
                'parent_id' => 2,
                'order' => 1,
                'active' => true
            ],
            [
                'name' => 'Office Building',
                'slug' => 'office-building',
                'description' => 'Office building construction projects',
                'parent_id' => 2,
                'order' => 2,
                'active' => true
            ],
            [
                'name' => 'Hotel',
                'slug' => 'hotel',
                'description' => 'Hotel construction projects',
                'parent_id' => 2,
                'order' => 3,
                'active' => true
            ],
        ];

        foreach ($categories as $category) {
            ProjectCategory::create($category);
        }
    }
}
