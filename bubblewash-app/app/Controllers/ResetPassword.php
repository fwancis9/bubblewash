<?php

namespace App\Controllers;

class ResetPassword extends BaseController
{
    public function getIndex()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/customer');
        }

        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $token = $this->request->getGet('token');

        if (!$token) {
            return redirect()->to('/login')->with('error', 'Invalid reset link.');
        }

        $token = trim($token);

        $emailController = new \App\Controllers\Email();
        $user = $emailController->verifyPasswordResetToken($token);

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'This reset link is invalid or has expired. Please request a new one.');
        }

        return view('reset_password', ['token' => $token]);
    }

    public function postIndex()
    {
        if (!$this->validate('resetPasswordRules')) {
            $errors = $this->validator->getErrors();
            return redirect()->back()->with('error', implode(' ', $errors));
        }

        $token = trim($this->request->getPost('token'));

        $emailController = new \App\Controllers\Email();
        $user = $emailController->verifyPasswordResetToken($token);

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'This reset link is invalid or has expired. Please request a new one.');
        }

        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $userModel->update($user['id'], [
            'password' => $password,
            'reset_token' => null,
            'reset_token_expires_at' => null
        ]);

        return redirect()->to('/login')->with('success', 'Password reset successfully! You can now log in with your new password.');
    }
}

