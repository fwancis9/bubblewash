<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function getIndex()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        
        if (session()->get('logged_in')) {
            return redirect()->to('/customer');
        }
        
        return view('home');
    }
}