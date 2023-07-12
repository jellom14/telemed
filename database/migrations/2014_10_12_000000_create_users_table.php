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
            //for all
            $table->id();

            $table->unsignedBigInteger('userTypeId');
            $table->foreign('userTypeId')->references('id')->on('userTypes');
            
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->string('firstName');
            $table->string('lastName');
            $table->string('address')->nullable();
            $table->date('dob');
            $table->string('gender');
            $table->string('phone');
            $table->string('videoConsultationFee')->nullable();

            //for patients
            $table->string('bloodPressure')->nullable();
            $table->string('bloodType')->nullable();
           
            //for doctors
            $table->unsignedBigInteger('cadersId')->nullable();
            $table->foreign('qualificationId')->references('id')->on('doctor_qualifications');
            $table->unsignedBigInteger('qualificationId')->nullable();
            $table->foreign('specialityId')->references('id')->on('doctor_specialities');
            $table->unsignedBigInteger('specialityId')->nullable();            
            $table->string('medicalSchoolOfGraduation')->nullable();
            $table->boolean('boardCertified')->nullable();
            $table->string('pdeaRegistrationNumber')->nullable();           
            $table->string('currentMedicalLicenseNumber')->nullable();
            $table->string('currentMedicalLicenseNumberDateIssued')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
