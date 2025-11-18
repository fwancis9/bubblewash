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
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!$token || !$password || !$confirmPassword) {
            return redirect()->back()->with('error', 'All fields are required.');
        }

        $token = trim($token);

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password must be at least 6 characters long.');
        }

        $emailController = new \App\Controllers\Email();
        $user = $emailController->verifyPasswordResetToken($token);

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'This reset link is invalid or has expired. Please request a new one.');
        }

        $userModel = new \App\Models\UserModel();
        $userModel->update($user['id'], [
            'password' => $password,
            'reset_token' => null,
            'reset_token_expires_at' => null
        ]);

        return redirect()->to('/login')->with('success', 'Password reset successfully! You can now log in with your new password.');
    }
}

