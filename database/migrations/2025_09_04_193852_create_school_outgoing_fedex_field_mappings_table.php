<?php

// database/migrations/xxxx_xx_xx_create_fedex_field_mappings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('school_outgoing_fedex_field_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('fedex_field');      // FedEx column name
            $table->string('our_field')->nullable(); // Our DB field (nullable if fixed/common value)
            $table->string('common_value')->nullable(); // Same value for all rows (e.g. "US")
            $table->string('description')->nullable(); // Optional description for clarity
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('school_outgoing_fedex_field_mappings');
    }
};
