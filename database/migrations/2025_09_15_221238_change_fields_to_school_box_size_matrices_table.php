<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('school_box_size_matrices', function (Blueprint $table) {
            $table->renameColumn('empty_box', 'empty_weight');
            $table->renameColumn('weight', 'full_weight');
        });
    }

    public function down(): void
    {        
    }
};
