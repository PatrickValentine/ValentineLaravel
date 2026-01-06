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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('participation')->nullable();
            $table->string('organization_name');
            $table->string('contact_person_name');
            $table->string('email');
            $table->string('how_to_address')->nullable();
            $table->integer('envelope_quantity');
            $table->integer('instructions_cards')->nullable();
            $table->string('street');
            $table->string('city');
            $table->string('state', 20);
            $table->string('zip', 20);
            $table->string('phone');
            $table->boolean('standing_order')->default(false);
            $table->text('question')->nullable();
            $table->text('introducer')->nullable();
            $table->text('prefilled_link')->nullable();
            $table->boolean('update_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
