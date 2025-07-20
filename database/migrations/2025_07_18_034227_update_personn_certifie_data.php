<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('personne_certifies', function (Blueprint $table) {
            $table->string('nationality')->nullable()->after('sexe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personne_certifies', function (Blueprint $table) {
            $table->dropColumn('nationality');
        });
    }
};
