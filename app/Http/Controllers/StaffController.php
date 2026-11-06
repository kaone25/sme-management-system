<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class StaffController extends Controller
{
    /**
     * Display all staff accounts.
     */
    public function index(): View
    {
        $staff = User::where('role', 'staff')
            ->latest()
            ->get();

        return view('staff.index', compact('staff'));
    }

    /**
     * Display the form for creating a staff account.
     */
    public function create(): View
    {
        return view('staff.create');
    }

    /**
     * Create a new staff account.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
        ]);

        return redirect()
            ->route('staff.create')
            ->with('success', 'Staff account created successfully.');
    }

    /**
     * Delete a staff account.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->role !== 'staff') {
            abort(403, 'Only staff accounts can be deleted here.');
        }

        $user->delete();

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff account deleted successfully.');
    }
}
