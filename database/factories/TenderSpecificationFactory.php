<?php

namespace Database\Factories;

use App\Models\Tender;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenderSpecificationFactory extends Factory
{
    public function definition()
    {
        $fileTypes = ['pdf', 'doc', 'docx', 'dwg', 'dxf'];
        $specifiableTypes = ['App\Models\GeneralSpecification', 'App\Models\Drawing'];

        return [
            'tender_id' => Tender::inRandomOrder()->first()->id ?? TenderFactory::new()->create()->id,
            'specifiable_type' => $this->faker->randomElement($specifiableTypes),
            'specifiable_id' => $this->faker->numberBetween(1, 100),
            'file_path' => 'specifications/' . Str::random(10) . '.' . $this->faker->randomElement($fileTypes),
            'original_name' => $this->faker->word . '.' . $this->faker->randomElement($fileTypes),
            'file_type' => $this->faker->randomElement($fileTypes),
            'file_size' => $this->faker->numberBetween(1000, 10000000),
        ];
    }
}
