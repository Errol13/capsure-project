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
    public function up(): void
    {
        Schema::create('freelancers', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('users')->onDelete('cascade');
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->integer('number_of_projects')->default(0);
            $table->text('terms_and_conditions')->default("The freelancer agrees to perform the services as outlined in the project brief or as otherwise agreed upon with the client. 
            The freelancer will deliver the services with reasonable skill, care, and diligence.");
            $table->boolean('isin_A_Team')->default(false);
            $table->timestamps();
        });

        // Adding the skills array column directly in the same migration
        DB::statement('ALTER TABLE freelancers ADD COLUMN skills TEXT[]');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('freelancers', function (Blueprint $table) {
            $table->dropColumn('skills');
        });

        Schema::dropIfExists('freelancers');
    }
};
