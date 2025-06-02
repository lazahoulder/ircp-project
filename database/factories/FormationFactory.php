<?php

namespace Database\Factories;

use App\Models\EntiteEmmeteurs;
use App\Models\Formation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Formation>
 */
class FormationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->jobTitle(),
            'description' => $this->faker->text(),
            'expiration_year' => $this->faker->numberBetween(1,3),
            'entite_emmeteur_id' => \App\Models\EntiteEmmeteurs::factory(),
            'modele_certificat' => 'certificats/default-certificate.docx',
        ];
    }
}
