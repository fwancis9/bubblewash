<?php

namespace App\Controllers;

class Login extends BaseController
{
    private $adminUsername = 'admin';
    private $adminPassword = 'admin';
    public function getIndex()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        
        return view('login');
    }
    
    public function postIndex()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        
        if (!$this->validate('loginRules')) {
            $errors = $this->validator->getErrors();
            return view('login', ['errors' => $errors]);
        }
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        if ($email === $this->adminUsername && $password === $this->adminPassword) {
            session()->set([
                'admin_username' => $this->adminUsername,
                'admin_logged_in' => true
            ]);
            
            return redirect()->to('/admin')->with('success', 'Admin login successful!');
        }
        
        $userModel = new \App\Models\UserModel();
        $user = $userModel->findByEmail($email);
        if ($user && $userModel->verifyPassword($password, $user['password'])) {
            session()->set([
                'user_id' => $user['id'],
                'user_email' => $user['email'],
                'logged_in' => true
            ]);
            
            return redirect()->to('/')->with('success', 'Login successful!');
        } else {
            return view('login', ['errors' => ['Invalid email/username or password.']]);
        }
    }
}