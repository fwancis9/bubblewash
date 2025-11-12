<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function getIndex(): string
    {
        $isLoggedIn = session()->get('logged_in') ?? false;
        $userEmail = session()->get('user_email') ?? null;
        
        return view('home', [
            'isLoggedIn' => $isLoggedIn,
            'userEmail' => $userEmail
        ]);
    }
}