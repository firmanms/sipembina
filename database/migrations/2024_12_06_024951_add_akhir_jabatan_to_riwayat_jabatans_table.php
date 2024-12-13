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
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            $table->date('akhir_jabatan')->after('pjb_menetapkan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_jabatans', function (Blueprint $table) {
            $table->dropColumn([
                'akhir_jabatan',
            ]);
        });
    }
};
