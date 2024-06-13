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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('hospitalRecordId')->index()->unique();
            $table->string('caseNo')->unique();
            $table->string('fileNo')->unique();
            $table->string('password');
            $table->string('firstName');
            $table->string('middleName');
            $table->string('lastName');
            $table->date('dateOfBirth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
