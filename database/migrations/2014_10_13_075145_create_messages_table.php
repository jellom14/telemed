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
            $table->unsignedBigInteger('conversationId');
            $table->unsignedBigInteger('fromUserId');
            $table->foreign('fromUserId')->references('id')->on('users');
            $table->unsignedBigInteger('toUserId');
            $table->foreign('toUserId')->references('id')->on('users');
            $table->text('message');
            $table->date('sentDate');
            $table->date('readDate')->nullable();
            $table->jsonb('attachments')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
