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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversationId');
            $table->foreign('conversationId')->references('id')->on('conversations');
            $table->unsignedBigInteger('fromUserId');
            $table->foreign('fromUserId')->references('id')->on('users');
            $table->unsignedBigInteger('toUserId');
            $table->foreign('toUserId')->references('id')->on('users');
            $table->text('filePathOnServer');
            $table->date('sentDate');
            $table->date('readDate')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
