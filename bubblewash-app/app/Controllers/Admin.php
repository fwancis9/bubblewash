<?php

namespace App\Controllers;

class Admin extends BaseController
{
    // Hardcoded admin credentials
    private $adminUsername = 'admin';
    private $adminPassword = 'admin123';

    public function getIndex()
    {
        // Check if admin is logged in
        if (session()->get('admin_logged_in')) {
            // Show admin dashboard with users table
            $userModel = new \App\Models\UserModel();
            $users = $userModel->findAll();
            
            return view('admin', [
                'isLoggedIn' => true,
                'users' => $users
            ]);
        } else {
            // Show admin login form
            return view('admin', ['isLoggedIn' => false]);
        }
    }

    public function postIndex()
    {
        // If already logged in, redirect to admin dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        // Validate admin login
        if (!$this->validate('adminLoginRules')) {
            $errors = $this->validator->getErrors();
            return view('admin', ['isLoggedIn' => false, 'errors' => $errors]);
        }

        // Get form data
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Check admin credentials
        if ($username === $this->adminUsername && $password === $this->adminPassword) {
            // Login successful - set admin session
            session()->set([
                'admin_username' => $username,
                'admin_logged_in' => true
            ]);

            return redirect()->to('/admin')->with('success', 'Admin login successful!');
        } else {
            // Wrong credentials
            return view('admin', [
                'isLoggedIn' => false, 
                'errors' => ['Invalid username or password.']
            ]);
        }
    }

    public function getLogout()
    {
        // Remove admin session
        session()->remove(['admin_username', 'admin_logged_in']);
        return redirect()->to('/admin')->with('success', 'Admin logged out successfully.');
    }

    public function getDelete($userId)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $userModel = new \App\Models\UserModel();
        
        try {
            // Delete the user
            if ($userModel->delete($userId)) {
                return redirect()->to('/admin')->with('success', 'User deleted successfully.');
            } else {
                return redirect()->to('/admin')->with('error', 'Failed to delete user.');
            }
        } catch (\Exception $e) {
            return redirect()->to('/admin')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }

    public function getEdit($userId)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/admin')->with('error', 'User not found.');
        }

        return view('admin_edit', [
            'user' => $user
        ]);
    }

    public function postEdit($userId)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/admin')->with('error', 'User not found.');
        }

        // exclude the current email from is_unique rule
        $rules = [
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']'
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return view('admin_edit', [
                'user' => $user,
                'errors' => $errors
            ]);
        }

        // Update user email
        $newEmail = $this->request->getPost('email');
        
        try {
            $userModel->update($userId, ['email' => $newEmail]);
            return redirect()->to('/admin')->with('success', 'User email updated successfully.');
        } catch (\Exception $e) {
            return view('admin_edit', [
                'user' => $user,
                'errors' => ['Failed to update email: ' . $e->getMessage()]
            ]);
        }
    }
}