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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('freelancer_id')->constrained('freelancers', 'user_id')->onUpdate('cascade')->onDelete('cascade'); // Foreign key to freelancers table
            $table->unsignedBigInteger('service_id');
            $table->foreignId('job_id')->constrained('event_jobs', 'job_id')->onUpdate('cascade')->onDelete('cascade'); // Foreign key to jobs table
            $table->string('status', 50); // Freelancer's application status (accepted, rejected, pending)
            $table->timestamps(); // Created at and updated at timestamps
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
