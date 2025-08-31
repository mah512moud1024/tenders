<?php

namespace Database\Factories;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteDocumentFactory extends Factory
{
    public function definition()
    {
        $fileTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];

        return [
            'quote_id' => Quote::inRandomOrder()->first()->id ?? QuoteFactory::new()->create()->id,
            'file_path' => 'quotes/' . Str::random(10) . '.' . $this->faker->randomElement($fileTypes),
            'original_name' => $this->faker->word . '.' . $this->faker->randomElement($fileTypes),
            'file_type' => $this->faker->randomElement($fileTypes),
            'file_size' => $this->faker->numberBetween(1000, 10000000),
        ];
    }
}
