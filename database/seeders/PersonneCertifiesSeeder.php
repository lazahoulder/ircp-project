<?php

namespace Database\Seeders;

use App\Models\PersonneCertifies;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonneCertifiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PersonneCertifies::factory(10)->create();
    }
}
