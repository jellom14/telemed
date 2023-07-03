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
        Schema::create('DrugAllergiesHealthProfileMap', function (Blueprint $table) {
            //for all
            $table->id();

            $table->unsignedBigInteger('allergyId');
            $table->foreign('allergyId')->references('id')->on('meta_drug_allergies');
            $table->unsignedBigInteger('healthProfileId');
            $table->foreign('healthProfileId')->references('id')->on('healthProfile');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DrugAllergiesHealthProfileMap');
    }
};
