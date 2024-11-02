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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('conversations', 'conversation_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sender')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('recipient')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('message');
            $table->boolean('isRead')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
