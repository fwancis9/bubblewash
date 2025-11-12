<?php

namespace App\Controllers;

class Admin extends BaseController
{

    public function getIndex()
    {
        if (session()->get('admin_logged_in')) {
            $userModel = new \App\Models\UserModel();
            
            $perPage = 5;
            $users = $userModel->paginate($perPage);
            $pager = $userModel->pager;
            
            return view('admin', [
                'isLoggedIn' => true,
                'users' => $users,
                'pager' => $pager
            ]);
        } else {
            return redirect()->to('/login')->with('error', 'Please log in with admin credentials to access the admin panel.');
        }
    }

    public function postIndex()
    {
        return redirect()->to('/login')->with('error', 'Please use the main login page to access admin panel.');
    }

    public function getLogout()
    {
        session()->remove(['admin_username', 'admin_logged_in']);
        return redirect()->to('/admin')->with('success', 'Admin logged out successfully.');
    }

    public function getDelete($userId)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $userModel = new \App\Models\UserModel();
        
        try {
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
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/admin')->with('error', 'User not found.');
        }

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