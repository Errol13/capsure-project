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
        Schema::create('teams', function (Blueprint $table) {
            $table->id('team_id');
            $table->char('team_code', 6)->unique();
            $table->string('team_name', 100);
            $table->string('package_service', 255);
            $table->decimal('package_price', 10, 2);
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->timestamps();
        });

         Schema::table('teams', function (Blueprint $table) {
            $table->index('team_id');
            $table->index('team_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
