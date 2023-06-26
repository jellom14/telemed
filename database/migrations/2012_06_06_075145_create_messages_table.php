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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // $table->bigInteger("staff_id")->unsigned()->nullable();
            // $table->foreign("staff_id")->references("id")->on("staff");
            
            // $table->bigInteger("patient_id")->unsigned()->nullable();
            // $table->foreign("patient_id")->references("id")->on("patients");

            $table->string('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
