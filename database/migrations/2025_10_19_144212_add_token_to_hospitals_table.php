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
            $table->string('token')->unique()->nullable()->after('id'); // nullable for now
        });

        // Generate tokens for existing records
        $hospitals = \App\Models\Hospital::all();

        foreach ($hospitals as $hospital) {
            do {
                $token = Str::random(8);
            } while (\App\Models\Hospital::where('token', $token)->exists());

            $hospital->token = $token;
            $hospital->prefilled_link = url('/hospital/' . $token . '/edit');
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
