<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function showLinkRequestForm(Request $request)
    {
        $login_type = $request->input('login_type', 'student');

        if (!in_array($login_type, ['student', 'admin'])) {
            abort(403, 'Invalid login type');
        }

        return view('designs.auth::passwords.email', ['login_type' => $login_type]);
    }

    /**
     * Handle sending the password reset link.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'login_type' => 'required|in:student,admin',
        ]);

        // Find the user
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Validate login_type against user role
            if ($request->login_type === 'admin' && !$user->isAdmin() && !$user->isSuperAdmin()) {
                throw ValidationException::withMessages([
                    'email' => __('Only admins can request a reset through this page.'),
                ]);
            }
            if ($request->login_type === 'student' && ($user->isAdmin() || $user->isSuperAdmin())) {
                throw ValidationException::withMessages([
                    'email' => __('Admins must request a reset through the admin page.'),
                ]);
            }
        }

        // Send the reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : throw ValidationException::withMessages([
                'email' => __($status),
            ]);
    }
}
