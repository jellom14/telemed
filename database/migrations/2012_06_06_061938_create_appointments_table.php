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
        Schema::create('appointments', function (Blueprint $table) {

            $table->id();
            $table->string('name');

            // $table->bigInteger("patient_id")->unsigned();
            // $table->foreign("patient_id")->references("id")->on("patients");

            // $table->bigInteger("staff_id")->unsigned();
            // $table->foreign("staff_id")->references("id")->on("staff");

            // $table->bigInteger("service_id")->unsigned();
            // $table->foreign("service_id")->references("id")->on("services");

            // $table->bigInteger("mode_id")->unsigned();
            // $table->foreign("mode_id")->references("id")->on("modes");

            $table->date('date');
            $table->string('note');

            $table->string('Q1');
            $table->string('Q2');
            $table->string('Q3');
            $table->string('Q4');
            $table->string('Q5');
            $table->string('Q6');
            $table->string('Q7');
            $table->string('Q8');
            $table->string('Q9');
            $table->string('Q10');

            $table->string('price');
            $table->string('receipt_no');


            $table->rememberToken();
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
