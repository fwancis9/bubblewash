<?php

namespace App\Controllers;

class VerifyFromEmail extends BaseController
{
    public function getIndex()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/')->with('success', 'You are already logged in.');
        }

        $token = $this->request->getGet('token');

        if (!$token) {
            return view('invalidExpiredVerification');
        }

        $emailController = new \App\Controllers\Email();
        $user = $emailController->verifyEmail($token);

        if ($user) {
            if (!isset($user['id']) || empty($user['id'])) {
                return view('invalidExpiredVerification');
            }

            session()->remove('pending_verification_email');
            
            return redirect()->to('/login')
                ->with('success', 'Email verified successfully! You can now login.');
        } else {
            return view('invalidExpiredVerification');
        }
    }
}

