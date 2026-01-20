<?php

namespace Database\Seeders;

use App\Models\HospitalOutgoingFedexFieldMapping;
use App\Models\SchoolOutgoingFedexFieldMapping;
use App\Models\SchoolReturnFedexFieldMapping;
use Illuminate\Database\Seeder;

class FedexServiceTypeMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolOutgoingFedexFieldMapping::where('fedex_field', 'service_type')
            ->update(['our_field' => 'service_type']);

        SchoolReturnFedexFieldMapping::where('fedex_field', 'service_type')
            ->update(['our_field' => 'service_type']);

        HospitalOutgoingFedexFieldMapping::where('fedex_field', 'serviceType')
            ->update(['our_field' => 'service_type']);
    }
}
