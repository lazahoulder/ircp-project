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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formation_reel_id');
            $table->foreign('formation_reel_id')->references('id')->on('formation_reels');
            $table->unsignedBigInteger('personne_certifies_id');
            $table->foreign('personne_certifies_id')->references('id')->on('personne_certifies');
            $table->string('numero_certificat')->nullable(false);
            $table->date('date_certification')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
