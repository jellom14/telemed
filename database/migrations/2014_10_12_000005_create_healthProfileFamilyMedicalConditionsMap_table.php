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
        Schema::create('famMedicalConditionsAppointmentsMap', function (Blueprint $table) {
            //for all
            $table->id();

            $table->unsignedBigInteger('medicalConditionId');
            $table->foreign('medicalConditionId')->references('id')->on('meta_medical_conditions');
            $table->unsignedBigInteger('appointmentId');
            $table->foreign('appointmentId')->references('id')->on('appointments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('famMedicalConditionsAppointmentsMap');
    }
};
