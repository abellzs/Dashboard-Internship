<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('magang_documents', function (Blueprint $table) {
            // $table->unsignedBigInteger('application_id')->nullable()->after('user_id');
        });
    }
};
