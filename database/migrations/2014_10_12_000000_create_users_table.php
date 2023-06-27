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
            $table->string('dob');
            $table->string('gender');
            $table->string('phone');

            //for patients
            $table->string('bloodPressure')->nullable();
            $table->string('bloodType')->nullable();
           
            //for doctors
            $table->unsignedBigInteger('cadersId')->nullable();
            $table->foreign('cadersId')->references('id')->on('caders');
            $table->boolean('qualification')->nullable();
            $table->string('school')->nullable();
            $table->boolean('boardCertification')->nullable();
            $table->string('specialty')->nullable();
           
            $table->string('registrationNo')->nullable();
            $table->string('medlicense')->nullable();

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
