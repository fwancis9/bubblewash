<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function getIndex()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }
        
        return view('register');
    }
    
    public function postIndex()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        
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
            $userId = $userModel->getInsertID();
            
            $emailController = new \App\Controllers\Email();
            $token = $emailController->generateVerificationToken($userId);
            $emailController->sendVerificationEmail($data['email'], $token);
            
            session()->set('pending_verification_email', $data['email']);
            
            return redirect()->to('/register')
                ->with('success', 'Registration successful! A verification email has been sent to your email address. Please check your inbox and click the verification link.');
        } catch (\Exception $e) {
            return view('register', ['error' => 'Registration failed. Please try again.']);
        }
    }
    
    public function postResend()
    {
        $email = session()->get('pending_verification_email');
        
        if (!$email) {
            return redirect()->to('/register')->with('error', 'No pending verification found.');
        }
        
        $userModel = new \App\Models\UserModel();
        $user = $userModel->findByEmail($email);
        
        if (!$user) {
            session()->remove('pending_verification_email');
            return redirect()->to('/register')->with('error', 'User not found.');
        }
        
        $emailController = new \App\Controllers\Email();
        if ($emailController->isEmailVerified($user['id'])) {
            session()->remove('pending_verification_email');
            return redirect()->to('/login')->with('success', 'Email is already verified. You can login now.');
        }
        
        try {
            $token = $emailController->generateVerificationToken($user['id']);
            $emailController->sendVerificationEmail($email, $token);
            
            return redirect()->to('/register')
                ->with('success', 'Verification email sent! Please check your inbox and click the verification link.');
        } catch (\Exception $e) {
            return redirect()->to('/register')->with('error', 'Failed to send verification email. Please try again.');
        }
    }
}