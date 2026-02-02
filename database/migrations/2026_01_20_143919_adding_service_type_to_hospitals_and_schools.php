<?php

use App\Enums\ServiceTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->enum('service_type', array_column(ServiceTypeEnum::cases(), 'value'))
                ->default(ServiceTypeEnum::FEDEX_GROUND->value)
                ->after('zip');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->enum('service_type', array_column(ServiceTypeEnum::cases(), 'value'))
                ->default(ServiceTypeEnum::FEDEX_GROUND->value)
                ->after('zip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropColumn('service_type');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('service_type');
        });
    }
};
