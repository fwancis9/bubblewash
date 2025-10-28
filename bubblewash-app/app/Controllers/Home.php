<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function getIndex(): string
    {
        // Check if user is logged in
        $isLoggedIn = session()->get('logged_in') ?? false;
        $userEmail = session()->get('user_email') ?? null;
        
        return view('home', [
            'isLoggedIn' => $isLoggedIn,
            'userEmail' => $userEmail
        ]);
    }
}