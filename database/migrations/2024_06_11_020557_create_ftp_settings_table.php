<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ftp_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ftp_host');
            $table->string('ftp_username');
            $table->string('ftp_password');
            $table->integer('ftp_port');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ftp_settings');
    }
};
