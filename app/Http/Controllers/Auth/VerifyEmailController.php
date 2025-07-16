<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Redirect based on user role
            if ($request->user()->is_admin) {
                return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1');
            }
            return redirect()->intended(route('menu', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redirect based on user role
        if ($request->user()->is_admin) {
            return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1');
        }
        return redirect()->intended(route('menu', absolute: false).'?verified=1');
    }
}
