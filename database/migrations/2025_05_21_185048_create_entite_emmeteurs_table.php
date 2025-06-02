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
        Schema::create('entite_emmeteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nomination');
            $table->string('adresse')->nullable();
            $table->date('date_creation')->nullable()->default(null);
            $table->string('nif')->nullable();
            $table->string('stat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entite_emmeteurs');
    }
};
