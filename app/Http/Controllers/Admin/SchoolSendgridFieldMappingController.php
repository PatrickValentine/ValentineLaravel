<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSendgridFieldMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SchoolSendgridFieldMappingController extends Controller
{
    public function index()
    {
        $mappings = SchoolSendgridFieldMapping::all();
        return view('admin.sendgrid_mappings.school', compact('mappings'));
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
        return view('admin.sendgrid_mappings.school_form', compact('allFields'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sendgrid_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        SchoolSendgridFieldMapping::create($data);

        return redirect()->route('admin.sendgrid_mappings.school')
            ->with('success', 'Sendgrid mapping added successfully.');
    }

    public function edit(SchoolSendgridFieldMapping $sendgridMapping)
    {
        $schoolFields = Schema::getColumnListing('schools'); // get all columns
        $matrixFields = Schema::getColumnListing('school_box_size_matrices');
        $customFields = ["reference", "invoiceNumber"];
        $allFields = [
            'schools' => $schoolFields,
            'school_box_size_matrices' => $matrixFields,
            'custom' => $customFields,
        ];
        return view('admin.sendgrid_mappings.school_form', compact('sendgridMapping', 'allFields'));
    }

    public function update(Request $request, SchoolSendgridFieldMapping $sendgridMapping)
    {
        $data = $request->validate([
            'sendgrid_field'   => 'required|string|max:255',
            'our_field'     => 'nullable|string|max:255',
            'common_value'  => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:255',
        ]);

        $sendgridMapping->update($data);

        return redirect()->route('admin.sendgrid_mappings.school')
            ->with('success', 'Sendgrid mapping updated successfully.');
    }

    public function destroy(SchoolSendgridFieldMapping $sendgridMapping)
    {
        $sendgridMapping->delete();

        return redirect()->route('admin.sendgrid_mappings.school')
            ->with('success', 'Sendgrid mapping deleted successfully.');
    }
}
