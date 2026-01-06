<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function volunteerList()
    {
        $volunteers = Volunteer::latest()->paginate(10);
        return view('admin.volunteers.index', compact('volunteers'));
    }

    public function create()
    {
        return view('admin.volunteers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:volunteers,email',
        ]);

        Volunteer::create($request->all());

        return redirect()->route('admin.volunteers')
            ->with('success', 'Volunteer added successfully.');
    }

    public function edit(Volunteer $volunteer)
    {
        return view('admin.volunteers.edit', compact('volunteer'));
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:volunteers,email,' . $volunteer->id,
        ]);

        $volunteer->update($request->all());

        return redirect()->route('admin.volunteers')
            ->with('success', 'Volunteer updated successfully.');
    }

    public function delete(Volunteer $volunteer)
    {
        $volunteer->delete();
        return redirect()->route('admin.volunteers')
            ->with('success', 'Volunteer deleted successfully.');
    }
}
