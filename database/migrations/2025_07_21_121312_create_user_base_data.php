<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user = new \App\Models\User();
        $user->name = 'Admin';
        $user->email = 'admin@ircp.org';
        $user->password = Hash::make('X7pL9qW3zT2rY8mK');
        $user->isAdmin = true;
        $user->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
