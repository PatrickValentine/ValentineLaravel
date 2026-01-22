<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('school_outgoing_fedex_field_mappings', function (Blueprint $table) {
            $table->unsignedInteger('order')->nullable()->after('description');
        });

        Schema::table('school_return_fedex_field_mappings', function (Blueprint $table) {
            $table->unsignedInteger('order')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('school_outgoing_fedex_field_mappings', function (Blueprint $table) {
            $table->dropColumn('order');
        });

        Schema::table('school_return_fedex_field_mappings', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};

