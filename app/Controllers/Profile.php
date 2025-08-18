<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $userId = session('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Data pengguna tidak ditemukan');
        }

        $data = [
            'title' => 'Profil Saya',
            'user' => $user
        ];

        return view('profile/index', $data);
    }

    public function edit()
    {
        $userId = session('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Data pengguna tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Profil',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('profile/edit', $data);
    }

    public function update()
    {
        $userId = session('user_id');

        // Validasi input
        $rules = [
            'username' => 'required|min_length[4]',
            'email' => 'required|valid_email',
        ];

        // Jika password diisi, validasi
        if ($this->request->getPost('password') != '') {
            $rules['password'] = 'required|min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            // return redirect()->to('/profile/edit')
            //     ->withInput()
            //     ->with('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        // Update data
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
        ];

        // Jika password diisi, update password
        if ($this->request->getPost('password') != '') {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $data);

        // Log aktivitas
        try {
            $this->db->table('logs')->insert([
                'user_id' => (int)$userId,
                'aktivitas' => 'Mengubah profil',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error logging profile update: ' . $e->getMessage());
        }

        // Update session data
        $sessionData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email')
        ];
        session()->set($sessionData);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui');
    }
}
