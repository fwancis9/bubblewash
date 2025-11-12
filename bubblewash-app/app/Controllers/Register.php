<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function getIndex()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        return view('register');
    }
    
    public function postIndex()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        $userModel = new \App\Models\UserModel();
        try {
            $userModel->createTableIfNotExists();
        } catch (\Exception $e) {
            return view('register', ['error' => 'Database setup failed: ' . $e->getMessage()]);
        }
        
        if (!$this->validate('registerRules')) {
            $errors = $this->validator->getErrors();
            return view('register', ['errors' => $errors]);
        }
        
        $data = $this->request->getPost();
        
        try {
            $userModel->save($data);
            return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
        } catch (\Exception $e) {
            return view('register', ['error' => 'Registration failed. Please try again.']);
        }
    }
}