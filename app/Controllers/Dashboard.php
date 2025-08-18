<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('dashboard/index', [
            'username' => session('username'),
            'role'     => session('role'),
        ]);
    }
}
