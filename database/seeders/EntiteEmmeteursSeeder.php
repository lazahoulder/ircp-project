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
        EntiteEmmeteurs::factory(5)->create()->each(function ($entiteEmmeteurs) {
            Formation::factory(4)->for($entiteEmmeteurs)->create()->each(function ($formation) {
                FormationReel::factory(2)->for($formation)->create();
            });
        });
    }
}
