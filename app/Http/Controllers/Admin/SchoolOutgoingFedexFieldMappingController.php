<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolOutgoingFedexFieldMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SchoolOutgoingFedexFieldMappingController extends Controller
{
    public function index()
    {
        $mappings = SchoolOutgoingFedexFieldMapping::all();
        return view('admin.fedex_mappings.school_outgoing', compact('mappings'));
    }

    public function create()
    {
        $schoolFields = Schema::getColumnListing('schools'); // get all columns
        $matrixFields = Schema::getColumnListing('school_box_size_matrices');
        $customFields = ["reference", "invoiceNumber"];
        $allFields = [
            'schools' => $schoolFields,
            'school_box_size_matrices' => $matrixFields,
            'custom' => $customFields,
        ];
        return view('admin.fedex_mappings.school_outgoing_form', compact('allFields'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fedex_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        SchoolOutgoingFedexFieldMapping::create($data);

        return redirect()->route('admin.fedex_mappings.school_outgoing')
            ->with('success', 'FedEx mapping added successfully.');
    }

    public function edit(SchoolOutgoingFedexFieldMapping $fedexMapping)
    {
        $schoolFields = Schema::getColumnListing('schools'); // get all columns
        $matrixFields = Schema::getColumnListing('school_box_size_matrices');
        $customFields = ["reference", "invoiceNumber"];
        $allFields = [
            'schools' => $schoolFields,
            'school_box_size_matrices' => $matrixFields,
            'custom' => $customFields,
        ];
        return view('admin.fedex_mappings.school_outgoing_form', compact('fedexMapping', 'allFields'));
    }

    public function update(Request $request, SchoolOutgoingFedexFieldMapping $fedexMapping)
    {
        $data = $request->validate([
            'fedex_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        $fedexMapping->update($data);

        return redirect()->route('admin.fedex_mappings.school_outgoing')
            ->with('success', 'FedEx mapping updated successfully.');
    }

    public function destroy(SchoolOutgoingFedexFieldMapping $fedexMapping)
    {
        $fedexMapping->delete();

        return redirect()->route('admin.fedex_mappings.school_outgoing')
            ->with('success', 'FedEx mapping deleted successfully.');
    }
}
