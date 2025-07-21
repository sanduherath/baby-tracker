<?php

namespace App\Http\Controllers;

use App\Models\Midwife;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PhmController extends Controller
{
    public function index()
    {
        return view('MOH.patients');
    }

    public function showCreateForm()
    {
        return view('MOH.addmidwife');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nic' => 'required|string|max:20|unique:midwives',
            'contact_number' => 'required|string|max:15',
            'email' => 'nullable|email|max:255|unique:users,email',
            'phm_area' => 'required|string|max:255',
            'registration_number' => 'required|string|max:50|unique:midwives',
            'start_date' => 'required|date',
            'training_level' => 'required|string|in:basic,intermediate,advanced',
            'address' => 'required|string',
            'notes' => 'nullable|string',
            'active_status' => 'boolean',
        ]);

        // Add default password to validated data for midwives table
        $validated['password'] = Hash::make('mid123');

        // Create midwife record
        $midwife = Midwife::create($validated);

        // Create corresponding user record if email is provided
        if ($validated['email']) {
            User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make('mid123'), // Hash the default password
                'role' => 'midwife', // Set the role
            ]);
        }

        return redirect()->route('phm.index')->with('success', 'Midwife registered successfully!');
    }
}
