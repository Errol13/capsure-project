<?php

use App\Models\Profile\OTP;
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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reported_user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->json('reason');
            $table->text('details');
            $table->json('proof_image')->nullable();
            $table->boolean('isArchived')->default(false);
            $table->foreignId('reporter_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->index('reported_user_id');
            $table->index('reporter_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
