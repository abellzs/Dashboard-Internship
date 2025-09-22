<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('magang_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('cv_path'); // wajib
            $table->string('surat_permohonan_path'); // wajib
            $table->string('proposal_path')->nullable(); // opsional
            $table->string('foto_diri_path'); // wajib
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magang_documents');
    }
};
