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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->char('otp_code', 6);
            $table->timestamp('expires_at');
            $table->boolean('isUsed')->default(false);
            $table->foreignId('verification_id')->constrained('verifications', 'user_id' )->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('otps', function (Blueprint $table) {
            $table->index('otp_code');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
