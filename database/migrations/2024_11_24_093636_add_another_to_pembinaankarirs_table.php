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
        Schema::table('pembinaankarirs', function (Blueprint $table) {
            $table->string('nip')->after('pegawais_id')->nullable();
            $table->string('status')->after('catatan_rotasi_mutasi')->default('Baru');
            $table->string('alasan_kabid')->after('status')->nullable();
            $table->tinyInteger('aksi_kabid')->after('alasan_kabid')->nullable();
            $table->string('alasan_subag')->after('aksi_kabid')->nullable();
            $table->tinyInteger('aksi_subag')->after('alasan_subag')->nullable();
            $table->string('alasan_kadis')->after('aksi_subag')->nullable();
            $table->tinyInteger('aksi_kadis')->after('alasan_kadis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembinaankarirs', function (Blueprint $table) {
            $table->dropColumn([
                'nip',
                'status',
                'alasan_kabid',
                'aksi_kabid',
                'alasan_subag',
                'aksi_subag',
                'alasan_kadis',
                'aksi_kadis',
            ]);
        });
    }
};
