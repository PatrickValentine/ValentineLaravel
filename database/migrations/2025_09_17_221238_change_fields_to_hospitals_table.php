<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->renameColumn('valentine_opt_in', 'contact_title');
        });

        // 2. Reset values to blank
        DB::table('hospitals')->update(['contact_title' => '']);
    }

    public function down(): void
    {
        // Rollback: rename back
        Schema::table('hospitals', function (Blueprint $table) {
            $table->renameColumn('contact_title', 'valentine_opt_in');
        });
    }
};
