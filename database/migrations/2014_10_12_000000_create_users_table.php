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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->jsonb('name');
            $table->string('gender');
            $table->jsonb('location');
            $table->integer('age');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dailyRecords', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->timestamp('date', precision: 0);
            $table->integer('male_count');
            $table->integer('female_count');
            $table->integer('male_avg_age');
            $table->integer('female_avg_age');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('dailyRecords');

    }
};
