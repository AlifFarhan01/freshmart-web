<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        $data['title'] = 'Home';
        $data['active'] = 'home';

        return view('dashboard');
    }
}
