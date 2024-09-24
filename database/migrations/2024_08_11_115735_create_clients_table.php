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
    public function up():void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('users')->onDelete('cascade');
            $table->integer('total_job_posted')->default(0);
            $table->integer('total_successful_hiring')->default(0);
            $table->decimal('hiring_rate', 5, 2)->default(0);
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->json('favorites')->nullable(); //store the freelancer's ids
            $table->timestamps();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('avg_rating');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down():void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('favorites');
        });

        Schema::dropIfExists('clients');
    }
};
