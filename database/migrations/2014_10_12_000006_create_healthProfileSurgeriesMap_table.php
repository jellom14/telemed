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
        Schema::create('surgeriesAppointmentsMap', function (Blueprint $table) {
            //for all
            $table->id();

            $table->unsignedBigInteger('surgeryId');
            $table->foreign('surgeryId')->references('id')->on('meta_surgeries');
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
        Schema::dropIfExists('surgeriesAppointmentsMap');
    }
};
