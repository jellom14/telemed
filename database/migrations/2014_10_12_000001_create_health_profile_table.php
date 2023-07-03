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
        Schema::create('healthProfile', function (Blueprint $table) {

            $table->id();
            $table->string('lengthOfFeeling');
            $table->unsignedBigInteger('patientId');
            $table->foreign('patientId')->references('id')->on('users');
            $table->unsignedBigInteger('caderId');
            $table->foreign('caderId')->references('id')->on('caders');
            // $table->string('dateOfAppointment');
            // $table->string('timeOfAppointment');
            $table->text('medications');
            $table->text('allergicToDrugsComplaint');
            $table->text('medicalConditionComplaint');
            $table->text('surgeryComplaint');
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
        Schema::dropIfExists('healthProfile');
    }
};