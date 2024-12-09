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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id('membership_id');
            $table->foreignId('freelancer_id')->constrained('freelancers', 'user_id')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('team_id')->constrained('teams', 'team_id')->onUpdate('cascade')->onDelete('set null');
            $table->json('services');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
