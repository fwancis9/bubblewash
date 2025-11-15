<?php

namespace App\Controllers;

class VerifyFromEmail extends BaseController
{
    /**
     * Handle email verification via token (from email link)
     * Endpoint: /verify-from-email?token=...
     */
    public function getIndex()
    {
        // Check if user is already logged in
        if (session()->get('logged_in')) {
            return redirect()->to('/')->with('success', 'You are already logged in.');
        }

        // Validate token parameter
        $token = $this->request->getGet('token');

        if (!$token) {
            return view('invalidExpiredVerification');
        }

        $emailController = new \App\Controllers\Email();
        $user = $emailController->verifyEmail($token);

        if ($user) {
            // Verify user data is valid
            if (!isset($user['id']) || empty($user['id'])) {
                return view('invalidExpiredVerification');
            }

            // Clear pending verification email from session
            session()->remove('pending_verification_email');
            
            // Email verified successfully - redirect to login
            return redirect()->to('/login')
                ->with('success', 'Email verified successfully! You can now login.');
        } else {
            // Token is invalid or expired - show error view
            return view('invalidExpiredVerification');
        }
    }
}

