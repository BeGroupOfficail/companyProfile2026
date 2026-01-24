<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function showAdminLogin()
    {
        if (Auth::check()) {
            return $this->handleRedirection();
        }

        if (!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }

        return view('auth.dashboard.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        // Attempt authentication
        if (!Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->filled('remember')
        )) {
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        return $this->handleRedirection();
    }

    protected function handleRedirection()
    {
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        // Store user type before logging out
        $isStudent = auth()->user()?->isStudent() ?? false;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to home only for students, otherwise to login
        return $isStudent ? redirect('/') : redirect('dashboard/login');
    }
}
