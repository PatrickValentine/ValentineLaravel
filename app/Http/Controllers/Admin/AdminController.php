<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $filePath, $pauseData;

    public function __construct()
    {
        $filePath = storage_path('app/pause_dates.json');
        
        if (!file_exists($filePath)) {
            // Create file if missing
            $this->pauseData = [
                'school_start'   => '',
                'hospital_start' => '',
                'end_date'       => ''
            ];
        } else {
            $this->pauseData = json_decode(file_get_contents($filePath), true);
        }
    }

    public function dashboard()
    {
        $pauseData = $this->pauseData;

        return view('admin.dashboard', compact('pauseData'));
    }

    public function userList()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'required|boolean',
        ]);
        $user->update($request->only('name', 'email', 'is_admin'));
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function editPassword(User $user)
    {
        return view('admin.change_password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'Password updated successfully.');
    }
}