<?php

namespace App\Controllers;

class Logout extends BaseController
{
    public function getIndex()
    {
        session()->destroy();
        
        return redirect()->to('/')->with('success', 'You have been logged out successfully.');
    }

    public function getForChangePassword()
    {
        session()->destroy();
        
        return redirect()->to('/forgot-password')->with('success', 'You have been logged out. Please enter your email to reset your password.');
    }
}