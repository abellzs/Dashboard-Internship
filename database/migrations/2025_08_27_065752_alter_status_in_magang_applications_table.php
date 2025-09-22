<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('magang_applications', function (Blueprint $table) {
            $table->enum('status', ['waiting', 'accepted', 'rejected', 'on_going', 'done'])
                  ->default('waiting')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('magang_applications', function (Blueprint $table) {
            $table->enum('status', ['waiting', 'accepted', 'rejected', 'on_going'])
                  ->default('waiting')
                  ->change();
        });
    }
};

