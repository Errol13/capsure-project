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
        Schema::create('eventjobs', function (Blueprint $table) {
            $table->id('job_id'); // Primary key
            $table->string('service_needed', 255); // Service needed by the client
            $table->string('job_category', 255); // Job category of the freelancer's service
            $table->integer('number_of_people'); // Number of people required for the job
            $table->string('status', 50); // Freelancer's application status (accepted, rejected, or pending)
            $table->foreignId('event_id')->constrained('events' ,'event_id')->onUpdate('cascade')->onDelete('cascade'); // Foreign key to events table
            $table->timestamps(); // Created at and updated at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventjobs');
    }
};
