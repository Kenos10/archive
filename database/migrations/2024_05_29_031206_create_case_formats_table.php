<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseFormatsTable extends Migration
{
    public function up()
    {
        Schema::create('case_formats', function (Blueprint $table) {
            $table->id();
            $table->string('prefix')->nullable();
            $table->string('prefix_value')->nullable();
            $table->date('prefix_date')->nullable();
            $table->enum('prefix_year_format', ['full', 'short'])->nullable();
            $table->boolean('prefix_year_only')->default(false);
            $table->boolean('prefix_month_only')->default(false);
            $table->boolean('prefix_day_only')->default(false);
            $table->string('suffix')->nullable();
            $table->string('suffix_value')->nullable();
            $table->date('suffix_date')->nullable();
            $table->enum('suffix_year_format', ['full', 'short'])->nullable();
            $table->boolean('suffix_year_only')->default(false);
            $table->boolean('suffix_month_only')->default(false);
            $table->boolean('suffix_day_only')->default(false);
            $table->boolean('auto_number')->default(false);
            $table->integer('starter_number')->default(1);
            $table->string('auto_number_format')->default('000');
            $table->boolean('include_hyphens')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('case_formats');
    }
}
