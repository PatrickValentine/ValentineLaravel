<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->string('county')->nullable()->after('city'); // nullable for now
        });

        $hospitals = \App\Models\Hospital::all();

        foreach ($hospitals as $hospital) {
            $hospital->timestamps = false;
            $hospital->update_status = 1;
            $hospital->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            //
        });
    }
};
