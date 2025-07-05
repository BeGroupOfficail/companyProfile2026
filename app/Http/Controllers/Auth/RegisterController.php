<?php

namespace App\Http\Controllers\Auth;

use App\Actions\LogRegUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Website\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showUserRegistration(SeoService $seoService)
    {
        if (Auth::check()) {
            return $this->handleRedirection();
        }

        if (!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }

        $seoData = $seoService->generateSeoData(
            pageType: 'register',
            additionalData: [],
            schemaType: 'EducationalOrganization'
        );
        return view('designs.auth::register', ['register_type' => 'student','seoData'=>$seoData]);
    }

    public function showAdminRegistration()
    {
        if (Auth::check()) {
            return $this->handleRedirection();
        }

        if (!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }
        return view('auth.dashboard.register', ['register_type' => 'admin']);
    }

    public function register(Request $request,LogRegUpdateAction $logRegUpdateAction)
    {
        $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'ssn' => 'required|numeric',
            'nationality_id' => 'required|exists:nationalities,id',
            'phone' => ['required', 'regex:/^05[0-9]{8}$/', 'unique:users,phone'],
            'gender' => 'required|in:male,female',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'register_type' => 'required|in:student,admin', // Validate registration type
        ],[
            'phone.regex' => __('home.The phone number must be a valid Saudi number (e.g., 0501234567).'),
        ]);

        // Determine role based on registration type
        $job_role = $request->register_type === 'admin' ? 'admin' : 'student';

        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nationality_id' => $request->nationality_id,
            'ssn' => $request->ssn,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'job_role' => $job_role,
            'is_admin'=> ($job_role == 'admin') ? 1 : 0,
            'status'=> 'inactive',
        ]);
        $session_id = session()->get('session_id');
        $logRegUpdateAction($user,$session_id);
        Auth::login($user);

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
}
