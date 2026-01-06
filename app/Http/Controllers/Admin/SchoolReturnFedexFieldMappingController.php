<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolReturnFedexFieldMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SchoolReturnFedexFieldMappingController extends Controller
{
    public function index()
    {
        $mappings = SchoolReturnFedexFieldMapping::all();
        return view('admin.fedex_mappings.school_return', compact('mappings'));
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
        return view('admin.fedex_mappings.school_return_form', compact('allFields'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fedex_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        SchoolReturnFedexFieldMapping::create($data);

        return redirect()->route('admin.fedex_mappings.school_return')
            ->with('success', 'FedEx mapping added successfully.');
    }

    public function edit(SchoolReturnFedexFieldMapping $fedexMapping)
    {
        $schoolFields = Schema::getColumnListing('schools'); // get all columns
        $matrixFields = Schema::getColumnListing('school_box_size_matrices');
        $customFields = ["reference", "invoiceNumber"];
        $allFields = [
            'schools' => $schoolFields,
            'school_box_size_matrices' => $matrixFields,
            'custom' => $customFields,
        ];
        return view('admin.fedex_mappings.school_return_form', compact('fedexMapping', 'allFields'));
    }

    public function update(Request $request, SchoolReturnFedexFieldMapping $fedexMapping)
    {
        $data = $request->validate([
            'fedex_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        $fedexMapping->update($data);

        return redirect()->route('admin.fedex_mappings.school_return')
            ->with('success', 'FedEx mapping updated successfully.');
    }

    public function destroy(SchoolReturnFedexFieldMapping $fedexMapping)
    {
        $fedexMapping->delete();

        return redirect()->route('admin.fedex_mappings.school_return')
            ->with('success', 'FedEx mapping deleted successfully.');
    }
}
