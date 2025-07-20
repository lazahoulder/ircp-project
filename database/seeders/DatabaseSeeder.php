<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'isAdmin' => true,
        ]);

        // Run the EntiteEmmeteursSeeder to create entities, formations, and formation reels
        /*$this->call(EntiteEmmeteursSeeder::class);

        // Run the PersonneCertifiesSeeder to create personne certifies
        $this->call(PersonneCertifiesSeeder::class);

        // Run the CertificateSeeder to create certificates
        $this->call(CertificateSeeder::class);*/
    }
}
