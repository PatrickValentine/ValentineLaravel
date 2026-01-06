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
        Schema::table('schools', function (Blueprint $table) {
            $table->string('token')->unique()->nullable()->after('id'); // nullable for now
        });

        $schools = \App\Models\School::all();

        foreach ($schools as $school) {
            do {
                $token = Str::random(8);
            } while (\App\Models\School::where('token', $token)->exists());

            $school->token = $token;
            $school->prefilled_link = url('/school/' . $token . '/edit');
            $school->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            //
        });
    }
};
