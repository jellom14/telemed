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
        Schema::create('FamMedicalConditionsHealthProfileMap', function (Blueprint $table) {
            //for all
            $table->id();

            $table->unsignedBigInteger('medicalConditionId');
            $table->foreign('medicalConditionId')->references('id')->on('meta_medical_conditions');
            $table->unsignedBigInteger('healthProfileId');
            $table->foreign('healthProfileId')->references('id')->on('healthProfile');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FamMedicalConditionsHealthProfileMap');
    }
};
