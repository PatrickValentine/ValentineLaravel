<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->integer('qty_sent_last_year')->nullable()->after('introducer');
            $table->integer('qty_received_last_year')->nullable()->after('qty_sent_last_year');
            $table->unsignedBigInteger('volunteer_id')->nullable()->after('qty_received_last_year');

            // add foreign key for volunteer
            $table->foreign('volunteer_id')
                ->references('id')->on('volunteers')
                ->onDelete('set null');
            });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['volunteer_id']);
            $table->dropColumn([
                'qty_sent_last_year',
                'qty_received_last_year',
                'volunteer_id'
            ]);
        });
    }
};
