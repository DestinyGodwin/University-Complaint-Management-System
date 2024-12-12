<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function create()
    {
        return view('auth.login');
    }
    public function login(LoginRequest $request)
    {
        // Attempt authentication
        if (Auth::attempt($request->only('school_id', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $roleRedirects = [
                'admin' => 'admin.index',
                'staff' => 'staff.index',
                'student' => 'student.dashboard',
            ];

            $role = $user->getRoleNames()->first();
            $defaultRedirect = 'dashboard'; // Fallback if no role match

            return redirect()->intended(route($roleRedirects[$role] ?? $defaultRedirect));
        }

        return back()->withErrors([
            'school_id' => 'Invalid credentials provided.',
        ])->onlyInput('school_id');
    }

    /**
     * Handle logout request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
}
