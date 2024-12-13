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
        Schema::create('riwayat_jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('jenis_jabatan')->nullable();
            $table->string('jenjang_jabatan')->nullable();
            $table->string('eselon')->nullable();
            $table->string('nama_jabatan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('satuan_kerja')->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->string('no_sk')->nullable();
            $table->date('tgl_sk')->nullable();
            $table->string('pjb_menetapkan')->nullable();
            $table->string('status')->default('Menunggu');
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatans');
    }
};
