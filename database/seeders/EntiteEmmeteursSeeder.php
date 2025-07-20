<?php

namespace Database\Seeders;

use App\Models\EntiteEmmeteurs;
use App\Models\Formation;
use App\Models\FormationReel;
use App\Models\User;
use Illuminate\Database\Seeder;

class EntiteEmmeteursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EntiteEmmeteurs::factory(3)->create()->each(function ($entiteEmmeteurs) {
            Formation::factory(2)->for($entiteEmmeteurs)->create()->each(function ($formation) {
                FormationReel::factory(1)->for($formation)->create();
            });
        });
    }
}
