<?php

namespace App\Controllers;

class Logout extends BaseController
{
    public function getIndex()
    {
        session()->destroy();
        
        return redirect()->to('/')->with('success', 'You have been logged out successfully.');
    }
}