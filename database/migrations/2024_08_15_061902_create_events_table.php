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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->foreignId('client_id')->constrained('clients', 'user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title', 255); 
            $table->text('description'); 
            $table->timestamp('start_date'); 
            $table->timestamp('end_date'); 
            $table->string('street', 255); 
            $table->string('barangay', 255); 
            $table->string('city', 255); 
            $table->string('payment_method', 50);
            $table->decimal('budget_min', 11, 2); 
            $table->decimal('budget_max', 11, 2);
            $table->string('status', 50)->default('open'); 
            $table->timestamps();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
