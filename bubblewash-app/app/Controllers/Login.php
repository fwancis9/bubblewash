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
            // Check if email is verified
            $emailController = new \App\Controllers\Email();
            if (!$emailController->isEmailVerified($user['id'])) {
                // Store email in session for resend functionality
                session()->set('pending_verification_email', $user['email']);
                
                return redirect()->to('/login')
                    ->with('error', 'A verification email has been sent to your email address. Please check your inbox and click the verification link.');
            }
            
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
    
    /**
     * Resend verification email
     */
    public function postResend()
    {
        $email = session()->get('pending_verification_email');
        
        if (!$email) {
            return redirect()->to('/login')->with('error', 'No pending verification found.');
        }
        
        $userModel = new \App\Models\UserModel();
        $user = $userModel->findByEmail($email);
        
        if (!$user) {
            session()->remove('pending_verification_email');
            return redirect()->to('/login')->with('error', 'User not found.');
        }
        
        // Check if already verified
        $emailController = new \App\Controllers\Email();
        if ($emailController->isEmailVerified($user['id'])) {
            session()->remove('pending_verification_email');
            return redirect()->to('/login')->with('success', 'Email is already verified. You can login now.');
        }
        
        // Generate new token and send email
        try {
            $token = $emailController->generateVerificationToken($user['id']);
            $emailController->sendVerificationEmail($email, $token);
            
            return redirect()->to('/login')
                ->with('error', 'Verification email sent! Please check your inbox and click the verification link.');
        } catch (\Exception $e) {
            return redirect()->to('/login')->with('error', 'Failed to send verification email. Please try again.');
        }
    }
}