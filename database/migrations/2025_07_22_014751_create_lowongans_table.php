<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_unit');
            $table->text('deskripsi');
            $table->string('pembimbing');
            $table->text('major');
            $table->ENUM('ketersediaan', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->integer('durasi')->nullable(); // Durasi dalam bulan
            $table->string('lokasi');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('lowongans');
    }
};
