<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectCategoryFactory extends Factory
{
    public function definition()
    {
        $mainCategories = [
            'Residential', 'Commercial', 'Industrial', 'Infrastructure', 'Institutional'
        ];

        $subCategories = [
            'Residential' => ['Villa', 'Apartment', 'Compound', 'Townhouse'],
            'Commercial' => ['Shopping Mall', 'Office Building', 'Hotel', 'Restaurant'],
            'Industrial' => ['Factory', 'Warehouse', 'Power Plant', 'Refinery'],
            'Infrastructure' => ['Roads', 'Bridges', 'Tunnels', 'Airports'],
            'Institutional' => ['Hospital', 'School', 'University', 'Mosque'],
        ];

        $mainCategory = $this->faker->randomElement($mainCategories);
        $subCategory = $this->faker->randomElement($subCategories[$mainCategory]);

        return [
            'name' => $subCategory,
            'slug' => \Illuminate\Support\Str::slug($subCategory),
            'description' => $this->faker->sentence,
            'parent_id' => null, // You might want to create a separate factory for subcategories
            'order' => $this->faker->numberBetween(1, 100),
            'active' => true,
        ];
    }
}
