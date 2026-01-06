<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->renameColumn('question', 'public_notes');
            $table->renameColumn('introducer', 'internal_notes');
        });
    }

    public function down(): void
    {        
    }
};
