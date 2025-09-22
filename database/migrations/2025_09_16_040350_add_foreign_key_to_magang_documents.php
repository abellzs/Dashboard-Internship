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
        Schema::table('magang_documents', function (Blueprint $table) {
            // Tambahin foreign key kalau belum ada
            if (!Schema::hasColumn('magang_documents', 'application_id')) {
                $table->unsignedBigInteger('application_id')->nullable()->after('user_id');
            }

            $table->foreign('application_id')
                  ->references('id')
                  ->on('magang_applications')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magang_documents', function (Blueprint $table) {
            $table->dropForeign(['application_id']);
        });
    }
};
