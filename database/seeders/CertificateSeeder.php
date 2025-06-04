<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\FormationReel;
use App\Models\PersonneCertifies;
use App\Services\CertificateService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the certificate service
        $certificateService = app(CertificateService::class);

        // Get existing formation reels
        $formationReels = FormationReel::with('formation.entiteEmmeteurs')->get();

        if ($formationReels->isEmpty()) {
            $this->command->info('No formation reels found. Running EntiteEmmeteursSeeder...');
            $this->call(EntiteEmmeteursSeeder::class);
            $formationReels = FormationReel::with('formation.entiteEmmeteurs')->get();
        }

        // Get existing personne certifies
        $personneCertifies = PersonneCertifies::all();

        if ($personneCertifies->isEmpty()) {
            $this->command->info('No personne certifies found. Running PersonneCertifiesSeeder...');
            $this->call(PersonneCertifiesSeeder::class);
            $personneCertifies = PersonneCertifies::all();
        }

        // Create certificates using existing data
        $this->command->info('Creating certificates...');
        $count = 0;

        foreach ($formationReels as $formationReel) {
            // Get a random number of certificates to create for this formation reel (1-3)
            $numCertificates = rand(1, 3);

            for ($i = 0; $i < $numCertificates; $i++) {
                // Get a random personne certifies
                $personneCertifie = $personneCertifies->random();

                // Create a certificate
                $certificateData = [
                    'formation_reel_id' => $formationReel->id,
                    'personne_certifies_id' => $personneCertifie->id,
                    'date_certification' => Carbon::parse($formationReel->date_fin)->addDays(rand(1, 30))->format('Y-m-d'),
                ];

                $certificateService->createCertificate($certificateData);
                $count++;
            }
        }

        $this->command->info("Created $count certificates.");
    }
}
