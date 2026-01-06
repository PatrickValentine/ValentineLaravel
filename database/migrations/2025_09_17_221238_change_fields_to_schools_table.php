<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->renameColumn('participation', 'contact_title');
        });

        // 2. Reset values to blank
        DB::table('schools')->update(['contact_title' => '']);
    }

    public function down(): void
    {        
        // Rollback: rename back
        Schema::table('schools', function (Blueprint $table) {
            $table->renameColumn('contact_title', 'participation');
        });
    }
};
