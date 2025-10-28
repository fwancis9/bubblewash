<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function getIndex()
    {
        // If already logged in, redirect to home
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        return view('login');
    }
    
    public function postIndex()
    {
        // If already logged in, redirect to home
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        // validate data
        if (!$this->validate('loginRules')) {
            $errors = $this->validator->getErrors();
            return view('login', ['errors' => $errors]);
        }
        
        // get form data
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        // check credentials
        $userModel = new \App\Models\UserModel();
        $user = $userModel->findByEmail($email);
        if ($user && $userModel->verifyPassword($password, $user['password'])) {
            // login successful - set session
            session()->set([
                'user_id' => $user['id'],
                'user_email' => $user['email'],
                'logged_in' => true
            ]);
            
            return redirect()->to('/')->with('success', 'Login successful!');
        } else {
            // wrong credentials
            return view('login', ['errors' => ['Invalid email or password.']]);
        }
    }
}