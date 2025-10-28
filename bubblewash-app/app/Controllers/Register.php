<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function getIndex()
    {
        // If already logged in, redirect to home
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        return view('register');
    }
    
    public function postIndex()
    {
        // If already logged in, redirect to home
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        $userModel = new \App\Models\UserModel();
        try {
            $userModel->createTableIfNotExists();
        } catch (\Exception $e) {
            return view('register', ['error' => 'Database setup failed: ' . $e->getMessage()]);
        }
        
        // validate data
        if (!$this->validate('registerRules')) {
            $errors = $this->validator->getErrors();
            return view('register', ['errors' => $errors]);
        }
        
        // successfully validated data
        $data = $this->request->getPost();
        
        // save data to database
        try {
            $userModel->save($data);
            return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
        } catch (\Exception $e) {
            return view('register', ['error' => 'Registration failed. Please try again.']);
        }
    }
}