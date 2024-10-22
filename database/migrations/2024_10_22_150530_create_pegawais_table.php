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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('refbagians_id')->constrained()->cascadeOnDelete();
            $table->foreignId('refjabatans_id')->constrained()->cascadeOnDelete();
            $table->date('tgl_awal_jabatan');
            $table->longText('tupoksi');
            $table->date('tgl_bergabung');
            $table->string('nip');
            $table->string('nama');
            $table->string('pangkat_gol');
            $table->string('eselon');
            $table->string('pendidikan');
            $table->string('jurusan');
            $table->longText('komptensi');
            $table->longText('riwayat_jabatan');
            $table->longText('riwayat_pelatihan');
            $table->longText('output_kinerja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
