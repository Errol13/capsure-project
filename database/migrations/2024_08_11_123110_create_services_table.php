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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('freelancer_id')->constrained('freelancers', 'user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('job_category',255);
            $table->string('job_title',255);
            $table->string('fee_type',255);
            $table->boolean('isAvailable')->default(true);
            $table->decimal('job_fee',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
