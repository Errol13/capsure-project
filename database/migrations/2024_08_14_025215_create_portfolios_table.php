<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id('portfolio_id');
            $table->foreignId('freelancer_id')->constrained('freelancers', 'user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('album_name', 255);
            $table->json('path')->nullable(); // Store file paths in JSON format
            $table->timestamps();
            $table->unique(['freelancer_id', 'album_name']); // Ensure uniqueness of combination
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
