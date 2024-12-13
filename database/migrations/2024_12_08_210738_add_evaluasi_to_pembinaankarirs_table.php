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
            $table->string('nip_kabid')->after('status')->nullable();
            $table->date('tgl_aksi_kabid')->after('aksi_kabid')->nullable();
            $table->string('nip_subag')->after('tgl_aksi_kabid')->nullable();
            $table->date('tgl_aksi_subag')->after('aksi_subag')->nullable();
            $table->string('nip_sekdis')->after('tgl_aksi_subag')->nullable();
            $table->string('alasan_sekdis')->after('nip_sekdis')->nullable();
            $table->tinyInteger('aksi_sekdis')->after('alasan_sekdis')->nullable();
            $table->date('tgl_aksi_sekdis')->after('aksi_sekdis')->nullable();
            $table->string('nip_kadis')->after('tgl_aksi_sekdis')->nullable();
            $table->date('tgl_aksi_kadis')->after('aksi_kadis')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembinaankarirs', function (Blueprint $table) {
            $table->dropColumn([
                'nip_kabid',
                'tgl_aksi_kabid',
                'nip_subag',
                'tgl_aksi_subag',
                'nip_sekdis',
                'alasan_sekdis',
                'aksi_sekdis',
                'tgl_aksi_sekdis',
                'nip_kadis',
                'tgl_aksi_kadis',
            ]);
        });
    }
};
