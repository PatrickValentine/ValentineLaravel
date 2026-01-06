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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('role')->nullable(); // e.g. "Team Lead", "Helper"
            $table->text('notes')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('resume_url')->nullable();
            $table->string('classification')->nullable(); // e.g. Student, Parent, Retiree
            $table->boolean('needs_school_credit')->default(false);

            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
