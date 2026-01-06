<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalOutgoingFedexFieldMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HospitalOutgoingFedexFieldMappingController extends Controller
{
    public function index()
    {
        $mappings = HospitalOutgoingFedexFieldMapping::all();
        return view('admin.fedex_mappings.hospital_outgoing', compact('mappings'));
    }

    public function create()
    {
        $hospitalFields = Schema::getColumnListing('hospitals'); // get all columns
        $matrixFields = Schema::getColumnListing('hospital_box_size_matrices');
        $customFields = ["reference", "invoiceNumber", "totalHospRequested"];
        $allFields = [
            'hospitals' => $hospitalFields,
            'hospital_box_size_matrices' => $matrixFields,
            'custom' => $customFields,
        ];
        return view('admin.fedex_mappings.hospital_outgoing_form', compact('allFields'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fedex_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        HospitalOutgoingFedexFieldMapping::create($data);

        return redirect()->route('admin.fedex_mappings.hospital_outgoing')
            ->with('success', 'FedEx mapping added successfully.');
    }

    public function edit(HospitalOutgoingFedexFieldMapping $fedexMapping)
    {
        $hospitalFields = Schema::getColumnListing('hospitals'); // get all columns
        $matrixFields = Schema::getColumnListing('hospital_box_size_matrices');
        $customFields = ["reference", "invoiceNumber", "totalHospRequested"];
        $allFields = [
            'hospitals' => $hospitalFields,
            'hospital_box_size_matrices' => $matrixFields,
            'custom' => $customFields,
        ];
        return view('admin.fedex_mappings.hospital_outgoing_form', compact('fedexMapping', 'allFields'));
    }

    public function update(Request $request, HospitalOutgoingFedexFieldMapping $fedexMapping)
    {
        $data = $request->validate([
            'fedex_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        $fedexMapping->update($data);

        return redirect()->route('admin.fedex_mappings.hospital_outgoing')
            ->with('success', 'FedEx mapping updated successfully.');
    }

    public function destroy(HospitalOutgoingFedexFieldMapping $fedexMapping)
    {
        $fedexMapping->delete();

        return redirect()->route('admin.fedex_mappings.hospital_outgoing')
            ->with('success', 'FedEx mapping deleted successfully.');
    }
}
