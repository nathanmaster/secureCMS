<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Redirect based on user role
            if ($request->user()->is_admin) {
                return redirect()->intended(route('admin.dashboard', absolute: false));
            }
            return redirect()->intended(route('menu', absolute: false));
        }
        
        return view('auth.verify-email');
    }
}
