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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id'); // Primary key
            $table->string('reviewee_role', 50); // Role of the reviewee (client or freelancer)
            $table->foreignId('client_id')->nullable()->constrained('clients', 'user_id')->onUpdate('cascade')->onDelete('set null'); // Foreign key to clients table
            $table->foreignId('freelancer_id')->nullable()->constrained('freelancers', 'user_id')->onUpdate('cascade')->onDelete('set null'); // Foreign key to freelancers table
            $table->foreignId('transaction_id')->nullable()->constrained('transactions', 'transaction_id')->onUpdate('cascade')->onDelete('set null');
            $table->decimal('rating', 2, 1); // Rating from 1 to 5 stars
            $table->text('content'); // Content of the review
            $table->date('review_date'); // Date of the review
            $table->timestamps(); // Created at and updated at columns

            // Adding a unique composite index to prevent duplicate reviews
            $table->unique(['reviewee_role', 'client_id', 'freelancer_id', 'transaction_id'], 'unique_review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
