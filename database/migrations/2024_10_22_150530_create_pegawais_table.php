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
            $table->date('tgl_awal_jabatan')->nullable();
            $table->longText('tupoksi')->nullable();
            $table->date('tgl_bergabung')->nullable();
            $table->string('nip')->nullable();
            $table->string('nama')->nullable();
            $table->string('pangkat_gol')->nullable();
            $table->string('eselon')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('jurusan')->nullable();
            $table->longText('komptensi')->nullable();
            $table->longText('riwayat_jabatan')->nullable();
            $table->longText('riwayat_pelatihan')->nullable();
            $table->longText('output_kinerja')->nullable();
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
