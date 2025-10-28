<?php

namespace App\Controllers;

class Logout extends BaseController
{
    public function getIndex()
    {
        // Destroy the session
        session()->destroy();
        
        // Redirect to home with message
        return redirect()->to('/')->with('success', 'You have been logged out successfully.');
    }
}