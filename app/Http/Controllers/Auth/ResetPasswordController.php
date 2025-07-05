<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Website\SeoService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function showResetForm(Request $request, $token = null ,SeoService $seoService)
    {
        $email = $request->email;
        $login_type = $request->input('login_type', 'student'); // Default to student

        if (!in_array($login_type, ['student', 'admin'])) {
            abort(403, 'Invalid login type');
        }

        $seoData = $seoService->generateSeoData(
            pageType: 'register',
            additionalData: [],
            schemaType: 'EducationalOrganization'
        );

        return view('designs.auth::reset-password', [
            'token' => $token,
            'email' => $email,
            'login_type' => $login_type,
            'seoData'=>$seoData
        ]);
    }

    /**
     * Handle the password reset request.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'login_type' => 'required|in:student,admin',
        ]);

        // Attempt to reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Check if the reset was successful
        if ($status === Password::PASSWORD_RESET) {
            return $this->handleSuccessfulReset($request);
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }

    /**
     * Handle successful password reset and redirect based on role.
     */
    protected function handleSuccessfulReset(Request $request)
    {
        $login_type = $request->login_type;

        if ($login_type === 'admin') {
            return redirect()->route('dashboard.login')->with('status', __('Password reset successfully. Please log in.'));
        }

        return redirect()->route('login')->with('status', __('Password reset successfully. Please log in.'));
    }
}
