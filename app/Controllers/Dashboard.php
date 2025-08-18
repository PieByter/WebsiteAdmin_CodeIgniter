<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Pastikan session sudah diset saat login di Auth controller
        return view('dashboard/index', [
            'username' => session('username'),
            'role'     => session('role'),
            'user_id'  => session('user_id'),
        ]);
    }
}
