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
        Schema::create('output_kinerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('catatan')->nullable();
            $table->string('terakhir')->nullable();
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
        Schema::dropIfExists('output_kinerjas');
    }
};
