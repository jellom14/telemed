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
        Schema::create('appointments', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('doctorId');
            $table->foreign('doctorId')->references('id')->on('users');
            $table->unsignedBigInteger('patientId');
            $table->foreign('patientId')->references('id')->on('users');
            $table->unsignedBigInteger('caderId');
            $table->foreign('caderId')->references('id')->on('caders');
            $table->string('dateOfAppointment');
            $table->string('timeOfAppointment');
            $table->text('complaint');
            $table->bigInteger('pwdNumber');
            $table->bigInteger('paymentReferenceNumber');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};