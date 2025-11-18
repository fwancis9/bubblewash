<?php

namespace App\Controllers;

class ForgotPassword extends BaseController
{
    public function getIndex()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/customer');
        }

        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $userModel = new \App\Models\UserModel();
        $userModel->createTableIfNotExists();

        return view('forgot_password');
    }

    public function postIndex()
    {
        if (!$this->validate('forgotPasswordRules')) {
            $errors = $this->validator->getErrors();
            return redirect()->back()->with('error', implode(' ', $errors));
        }

        $email = $this->request->getPost('email');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('success', 'If an account exists with this email, a password reset link has been sent.');
        }

        $emailController = new \App\Controllers\Email();
        $token = $emailController->generatePasswordResetToken($user['id']);

        $result = $emailController->sendPasswordResetEmail($email, $token);

        if ($result === true) {
            return redirect()->back()->with('success', 'If an account exists with this email, a password reset link has been sent.');
        } else {
            return redirect()->back()->with('error', 'Failed to send reset email. Please try again later.');
        }
    }
}

