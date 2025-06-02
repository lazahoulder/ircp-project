<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\PersonneCertifies;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PersonneCertifies>
 */
class PersonneCertifiesFactory extends Factory
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
            'nom' => $this->faker->name(),
            'prenom' => $this->faker->lastName(),
            'image_id' => $image->id,
        ];
    }
}
