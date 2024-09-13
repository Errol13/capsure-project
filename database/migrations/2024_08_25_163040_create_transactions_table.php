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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id'); // Creates an auto-incrementing ID column
    
            // Foreign key columns
            $table->foreignId('client_id')->constrained('clients', 'user_id')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('freelancers', 'user_id')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('event_jobs', 'job_id')->onDelete('cascade');
            $table->foreignId('hiring_request_id')->constrained('hiring_requests', 'hiring_request_id')->onDelete('cascade');
            
            // Payment amount column
            $table->decimal('payment_amount', 10, 2); // Adjust precision and scale as needed
            
            // Status columns
            $table->string('payment_status', 50);
            $table->string('transaction_status', 50);
            
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index('freelancer_id');
            $table->index('job_id');
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
