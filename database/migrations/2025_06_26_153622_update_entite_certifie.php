<?php

use App\Constant\EntiteEmmeteursConstant;
use App\Models\EntiteEmmeteurs;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('entite_emmeteurs', function (Blueprint $table) {
            $table->enum('status',
                [
                    EntiteEmmeteursConstant::STATUS_EN_ATTENTE,
                    EntiteEmmeteursConstant::STATUS_VALID,
                    EntiteEmmeteursConstant::STATUS_INCOMPLET,
                ]
            )->default('en-attente')->nullable();
        });

        EntiteEmmeteurs::whereStatus(EntiteEmmeteursConstant::STATUS_EN_ATTENTE)->update(['status' => EntiteEmmeteursConstant::STATUS_VALID]);
        EntiteEmmeteurs::whereNif(null)
            ->orWhere('stat', null)
            ->orWhere('adresse', null)
            ->orWhere('date_creation', null)
            ->update(['status' => EntiteEmmeteursConstant::STATUS_INCOMPLET]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entite_emmeteurs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
