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
            $table->unsignedBigInteger('userTypeId');
            $table->foreign('userTypeId')->references('id')->on('userTypes');
            $table->unsignedBigInteger('cadersId')->nullable();
            $table->foreign('cadersId')->references('id')->on('caders');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('address');
            $table->string('dob');
            $table->string('bloodPressure');
            $table->string('bloodType');
            $table->string('gender');
            $table->string('phone');
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
