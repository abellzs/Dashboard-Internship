<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('instansi_id')->nullable()->constrained()->onDelete('set null'); // <-- TAMBAHKAN INI
            $table->date('tgl_lahir');
            $table->string('no_hp');
            $table->string('domisili');
            $table->enum('jenjang_pendidikan', ['SMK', 'Diploma', 'Sarjana']);
            $table->string('instansi'); // tetap simpan instansi sebagai teks untuk input manual
            $table->string('jurusan');
            $table->year('thn_masuk');
            $table->string('semester')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
