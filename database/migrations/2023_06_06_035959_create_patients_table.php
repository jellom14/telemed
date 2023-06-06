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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger("role_id")->unsigned();
            $table->foreign("role_id")->references("id")->on("roles");

            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->date('birthdate');
            $table->string('gender');
            $table->string('phone');
            $table->string('insurance');
            $table->string('blood_type');

            $table->string('email')->unique();
            $table->string('username');
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
