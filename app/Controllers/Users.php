<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
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
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/users/create', $data);
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,user]'
        ])) {
            // return redirect()->to('/admin/users/create')
            //     ->withInput()
            //     ->with('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        // Simpan data
        $this->userModel->save([
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getVar('role'),
            'is_active' => 1
        ]);

        // Log aktivitas
        try {
            $this->db->table('logs')->insert([
                'user_id' => session('user_id'),
                'aktivitas' => 'Menambahkan user baru: ' . $this->request->getVar('username'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error logging user creation: ' . $e->getMessage());
        }

        session()->setFlashdata('pesan', 'User berhasil ditambahkan');
        return redirect()->to('/admin/users');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit User',
            'validation' => \Config\Services::validation(),
            'user' => $this->userModel->find($id)
        ];

        if (empty($data['user'])) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        // Validasi input
        $rules = [
            'username' => "required|min_length[4]|is_unique[users.username,id,$id]",
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
            'role' => 'required|in_list[admin,user]',
            'is_active' => 'required|in_list[0,1]'
        ];

        // Jika password diisi, validasi
        if ($this->request->getVar('password') != '') {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            // return redirect()->to("/admin/users/edit/$id")
            //     ->withInput()
            //     ->with('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        // Update data
        $data = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role'),
            'is_active' => $this->request->getVar('is_active')
        ];

        // Jika password diisi, update password
        if ($this->request->getVar('password') != '') {
            $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        // Log aktivitas
        try {
            $this->db->table('logs')->insert([
                'user_id' => session('user_id'),
                'aktivitas' => 'Mengubah data user: ' . $this->request->getVar('username'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error logging user update: ' . $e->getMessage());
        }

        session()->setFlashdata('pesan', 'Data user berhasil diperbarui');
        return redirect()->to('/admin/users');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (empty($user)) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        // Jangan hapus diri sendiri
        if ($id == session('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak dapat menghapus akun yang sedang digunakan');
        }

        $this->userModel->delete($id);

        // Log aktivitas
        try {
            $this->db->table('logs')->insert([
                'user_id' => session('user_id'),
                'aktivitas' => 'Menghapus user: ' . $user['username'],
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error logging user deletion: ' . $e->getMessage());
        }

        session()->setFlashdata('pesan', 'User berhasil dihapus');
        return redirect()->to('/admin/users');
    }
}
