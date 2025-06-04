<?php

namespace Database\Factories;

use App\Models\EntiteEmmeteurs;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EntiteEmmeteurs>
 */
class EntiteEmmeteursFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $image = Image::factory()->create();
        return [
            'nomination' => $this->faker->company(),
            'adresse' => $this->faker->address(),
            'date_creation' => $this->faker->date(),
            'nif' => $this->faker->unique()->numerify('######'),
            'stat' => $this->faker->unique()->numerify('######'),
            'image_id' => $image->id,
        ];
    }
}
