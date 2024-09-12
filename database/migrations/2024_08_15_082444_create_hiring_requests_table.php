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
        Schema::create('hiring_requests', function (Blueprint $table) {
            $table->id('hiring_request_id'); // Primary key
            $table->foreignId('freelancer_id')->constrained('freelancers','user_id')->onUpdate('cascade')->onDelete('cascade'); // Foreign key to freelancers table
            $table->foreignId('job_id')->constrained('event_jobs', 'job_id')->onUpdate('cascade')->onDelete('cascade'); // Foreign key to event_jobs table
            $table->foreignId('client_id')->constrained('clients','user_id')->onUpdate('cascade')->onDelete('cascade'); // Foreign key to clients table
            $table->decimal('client_pricing', 10, 2); // Client's pricing for freelancer's service
            $table->decimal('freelancer_pricing', 10, 2); // Freelancer's pricing for their service
            $table->string('dealer_user_type', 50); //who made or sent the offer
            $table->string('status', 50); // Request status (pending, accepted, rejected)
            $table->timestamps(); // Created at and updated at timestamps
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiring_requests');
    }
};
