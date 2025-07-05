<?php

namespace App\Http\Controllers\Auth;

use App\Actions\LogRegUpdateAction;
use App\Http\Controllers\Controller;
use App\Services\Website\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showUserLogin(SeoService $seoService)
    {
        if (Auth::check()) {
            return $this->handleRedirection();
        }

        if (!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }

        $seoData = $seoService->generateSeoData(
            pageType: 'login',
            additionalData: [],
            schemaType: 'EducationalOrganization'
        );

        return view('designs.auth::login', ['login_type' => 'user','seoData'=>$seoData]);
    }

    public function showAdminLogin()
    {
        if (Auth::check()) {
            return $this->handleRedirection();
        }

        if (!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }

        return view('auth.dashboard.login', ['login_type' => 'admin']);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'login_type' => 'required|in:student,admin', // Add this validation
        ]);
        $session_id = session()->get('session_id');


        if (!Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();
        // Check login type against user role
        if ($request->login_type === 'admin' && !$user->isAdmin() && !$user->isSuperAdmin()) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => __('auth.not_authorized'),
            ]);
        }

        if ($request->login_type === 'student' && ($user->isAdmin() || $user->isSuperAdmin())) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => __('Admins must login through the admin login page'),
            ]);
        }

        return $this->handleRedirection();
    }

    protected function handleRedirection()
    {
        $intended = session()->pull('url.intended', null);

        $user = auth()->user();

        if ($intended) {
            return redirect()->to($intended);
        }

        if ($user->isSuperAdmin()) {
            return redirect()->intended('/dashboard');
        }

        if ($user->isAdmin()) {
            return redirect()->intended('/dashboard');
        }

        if ($user->isStudent()) {
            return redirect()->intended('/');
        }

        // For instructors and other roles
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
