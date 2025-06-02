<?php

namespace Database\Seeders;

use App\Models\EntiteEmmeteurs;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(5)->create()->each(function ($user) {
            $user->entiteEmmeteur()->associate(EntiteEmmeteurs::all()->random());
            $user->save();
        });
    }
}
