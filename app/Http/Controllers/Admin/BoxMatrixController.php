<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolBoxSizeMatrix;
use App\Models\HospitalBoxSizeMatrix;
use Google\Client;
use Illuminate\Support\Facades\Http;

class BoxMatrixController extends Controller
{
    // School Box Size Matrix methods
    public function schoolBoxMatrixList()
    {
        $boxMatrices = SchoolBoxSizeMatrix::orderBy('greater_than')->get();
        return view('admin.school_box_matrices.index', compact('boxMatrices'));
    }

    public function createSchoolBoxMatrix()
    {
        return view('admin.school_box_matrices.create');
    }

    public function storeSchoolBoxMatrix(Request $request)
    {
        $request->validate([
            'greater_than' => 'required|integer|min:0',
            'qty_of_env' => 'required|integer|min:0',
            'box_style' => 'required|string|max:10',
            // 'length' => 'required|integer|min:1',
            // 'width' => 'required|integer|min:1',
            // 'height' => 'required|integer|min:1',
            'empty_weight' => 'required|integer|min:0',
            'full_weight' => 'required|integer|min:0',
        ]);

        SchoolBoxSizeMatrix::create($request->all());
        return redirect()->route('admin.school-box-matrices')->with('success', 'Box size matrix created successfully.');
    }

    public function editSchoolBoxMatrix(SchoolBoxSizeMatrix $boxMatrix)
    {
        return view('admin.school_box_matrices.edit', compact('boxMatrix'));
    }

    public function updateSchoolBoxMatrix(Request $request, SchoolBoxSizeMatrix $boxMatrix)
    {
        $request->validate([
            'greater_than' => 'required|integer|min:0',
            'qty_of_env' => 'required|integer|min:0',
            'box_style' => 'required|string|max:10',
            // 'length' => 'required|integer|min:1',
            // 'width' => 'required|integer|min:1',
            // 'height' => 'required|integer|min:1',
            'empty_weight' => 'required|integer|min:0',
            'full_weight' => 'required|integer|min:0',
        ]);

        $boxMatrix->update($request->all());
        return redirect()->route('admin.school-box-matrices')->with('success', 'Box size matrix updated successfully.');
    }

    public function deleteSchoolBoxMatrix(SchoolBoxSizeMatrix $boxMatrix)
    {
        $boxMatrix->delete();
        return redirect()->route('admin.school-box-matrices')->with('success', 'Box size matrix deleted successfully.');
    }

    // Hospital Box Size Matrix methods
    public function hospitalBoxMatrixList()
    {
        $boxMatrices = HospitalBoxSizeMatrix::orderBy('greater_than')->get();
        return view('admin.hospital_box_matrices.index', compact('boxMatrices'));
    }

    public function createHospitalBoxMatrix()
    {
        return view('admin.hospital_box_matrices.create');
    }

    public function storeHospitalBoxMatrix(Request $request)
    {
        $request->validate([
            'greater_than' => 'required|integer|min:0',
            'qty_of_env' => 'required|integer|min:0',
            'box_style' => 'required|string|max:10',
            // 'length' => 'required|integer|min:1',
            // 'width' => 'required|integer|min:1',
            // 'height' => 'required|integer|min:1',
            'empty_weight' => 'required|integer|min:0',
            'full_weight' => 'required|integer|min:0',
        ]);

        HospitalBoxSizeMatrix::create($request->all());
        return redirect()->route('admin.hospital-box-matrices')->with('success', 'Box size matrix created successfully.');
    }

    public function editHospitalBoxMatrix(HospitalBoxSizeMatrix $boxMatrix)
    {
        return view('admin.hospital_box_matrices.edit', compact('boxMatrix'));
    }

    public function updateHospitalBoxMatrix(Request $request, HospitalBoxSizeMatrix $boxMatrix)
    {
        $request->validate([
            'greater_than' => 'required|integer|min:0',
            'qty_of_env' => 'required|integer|min:0',
            'box_style' => 'required|string|max:10',
            // 'length' => 'required|integer|min:1',
            // 'width' => 'required|integer|min:1',
            // 'height' => 'required|integer|min:1',
            'empty_weight' => 'required|integer|min:0',
            'full_weight' => 'required|integer|min:0',
        ]);

        $boxMatrix->update($request->all());
        return redirect()->route('admin.hospital-box-matrices')->with('success', 'Box size matrix updated successfully.');
    }

    public function deleteHospitalBoxMatrix(HospitalBoxSizeMatrix $boxMatrix)
    {
        $boxMatrix->delete();
        return redirect()->route('admin.hospital-box-matrices')->with('success', 'Box size matrix deleted successfully.');
    }
}