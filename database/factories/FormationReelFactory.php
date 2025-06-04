<?php

namespace Database\Factories;

use App\Models\Formation;
use App\Models\FormationReel;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FormationReel>
 */
class FormationReelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateDebut = $this->faker->dateTimeThisYear();
        $dateFin = clone $dateDebut;
        $dateFin = $dateFin->add(new DateInterval('P5D')); // Add 5 days

        return [
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'formation_id' => \App\Models\Formation::factory(),
            'participants_file' => 'realizations/default-participants.xlsx',
        ];
    }
}
