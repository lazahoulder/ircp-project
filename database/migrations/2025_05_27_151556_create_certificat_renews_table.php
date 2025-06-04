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
        Schema::create('certificat_renews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('certificat_id');
            $table->foreign('certificat_id')->references('id')->on('certificates')->onDelete('cascade');
            $table->date('date_renew');
            $table->date('expire_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificat_renews');
    }
};
