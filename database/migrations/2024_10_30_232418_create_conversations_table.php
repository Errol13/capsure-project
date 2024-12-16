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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id('conversation_id');
            $table->foreignId('sender_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('recipient_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('last_time_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
