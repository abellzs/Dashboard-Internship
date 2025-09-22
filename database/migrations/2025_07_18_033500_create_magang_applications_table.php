<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('magang_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_mulai_usulan');
            $table->date('tanggal_selesai_usulan');
            $table->string('unit_penempatan');
            $table->string('durasi_magang');
            $table->text('alasan_pilih_telkom')->nullable();
            $table->enum('bersedia', ['ya', 'tidak'])->nullable();
            $table->enum('status', ['waiting', 'accepted', 'rejected', 'on_going'])->default('waiting');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magang_applications');
    }
};
