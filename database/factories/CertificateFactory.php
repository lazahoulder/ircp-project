<?php

namespace Database\Factories;

use App\Models\Certificate;
use App\Models\FormationReel;
use App\Models\PersonneCertifies;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificate>
 */
class CertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_certificat' => $this->faker->unique()->numerify('###-####-##-###'),
            'date_certification' => $this->faker->dateTimeThisYear(),
            'personne_certifies_id' => \App\Models\PersonneCertifies::factory(),
            'formation_reel_id' => \App\Models\FormationReel::factory(),
        ];
    }
}
