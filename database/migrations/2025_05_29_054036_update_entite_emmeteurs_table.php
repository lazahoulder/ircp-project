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
        Schema::table('entite_emmeteurs', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entite_emmeteurs', function (Blueprint $table) {
            $table->dropColumn('image_id');
        });
    }
};
