<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use App\Notifications\EmailVerifiedNotification;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Check if email is already verified
        if ($user->hasVerifiedEmail()) {
            return $this->redirectWithMessage(
                'info', 
                'Your email is already verified.',
                RouteServiceProvider::HOME
            );
        }

        // Mark email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            
            // Log the verification
            Log::info("User {$user->id} verified their email: {$user->email}");
            
            // Send welcome notification
            $user->notify(new EmailVerifiedNotification());
            
            return $this->redirectWithMessage(
                'success', 
                'Thank you for verifying your email address!',
                RouteServiceProvider::HOME
            );
        }

        // Fallback in case verification fails
        return $this->redirectWithMessage(
            'error',
            'Email verification failed. Please try again.',
            RouteServiceProvider::HOME
        );
    }

    /**
     * Helper method to redirect with flash message
     *
     * @param string $type
     * @param string $message
     * @param string $route
     * @return RedirectResponse
     */
    protected function redirectWithMessage(string $type, string $message, string $route): RedirectResponse
    {
        return redirect()
            ->intended("$route?verified=1")
            ->with($type, $message);
    }
}