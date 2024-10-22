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
        Schema::create('pembinaankarirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pegawais_id')->constrained()->cascadeOnDelete();
            $table->longText('naik_pangkat_gol');
            $table->longText('catatan_naik');
            $table->longText('catatan_pendidikan');
            $table->longText('catatan_jabatan');
            $table->longText('kompetensi_dibutuhkan');
            $table->longText('usulan_pelatihan');
            $table->longText('realisasi_kinerja');
            $table->string('rotasi_mutasi');
            $table->longText('catatan_rotasi_mutasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembinaankarirs');
    }
};
