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
        Schema::create('riwayat_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('nama_pelatihan')->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->string('penyelenggara')->nullable();
            $table->string('tempat')->nullable();
            $table->integer('jml_jam')->nullable();
            $table->string('no_sttp')->nullable();
            $table->date('tgl_sttp')->nullable();
            $table->string('nama_pejabat')->nullable();
            $table->string('jenis')->nullable();
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
        Schema::dropIfExists('riwayat_pelatihans');
    }
};
