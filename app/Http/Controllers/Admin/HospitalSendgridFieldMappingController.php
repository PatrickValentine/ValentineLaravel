<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalSendgridFieldMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HospitalSendgridFieldMappingController extends Controller
{
    public function index()
    {
        $mappings = HospitalSendgridFieldMapping::all();
        return view('admin.sendgrid_mappings.hospital', compact('mappings'));
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
        return view('admin.sendgrid_mappings.hospital_form', compact('allFields'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sendgrid_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        HospitalSendgridFieldMapping::create($data);

        return redirect()->route('admin.sendgrid_mappings.hospital')
            ->with('success', 'Sendgrid mapping added successfully.');
    }

    public function edit(HospitalSendgridFieldMapping $sendgridMapping)
    {
        $hospitalFields = Schema::getColumnListing('hospitals'); // get all columns
        $matrixFields = Schema::getColumnListing('hospital_box_size_matrices');
        $customFields = ["reference", "invoiceNumber", "totalHospRequested"];
        $allFields = [
            'hospitals' => $hospitalFields,
            'hospital_box_size_matrices' => $matrixFields,
            'custom' => $customFields,
        ];
        return view('admin.sendgrid_mappings.hospital_form', compact('sendgridMapping', 'allFields'));
    }

    public function update(Request $request, HospitalSendgridFieldMapping $sendgridMapping)
    {
        $data = $request->validate([
            'sendgrid_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        $sendgridMapping->update($data);

        return redirect()->route('admin.sendgrid_mappings.hospital')
            ->with('success', 'Sendgrid mapping updated successfully.');
    }

    public function destroy(HospitalSendgridFieldMapping $sendgridMapping)
    {
        $sendgridMapping->delete();

        return redirect()->route('admin.sendgrid_mappings.hospital')
            ->with('success', 'Sendgrid mapping deleted successfully.');
    }
}
