<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Auth extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function login()
    {
        helper(['form']);

        if ($this->request->getMethod() == 'POST') {
            try {
                // Ambil data dari form login
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                // Validasi email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return redirect()->back()
                        ->with('error', 'Format email tidak valid')
                        ->withInput();
                }

                // Cari user berdasarkan email saja
                $model = new UserModel();
                $user = $model->where('email', $email)->first();

                // Validate credentials
                if ($user && password_verify($password, $user['password'])) {
                    // Set session data
                    $sessionData = [
                        'user_id'   => $user['id'],
                        'username'  => $user['username'],
                        'email'     => $user['email'],
                        'role'      => $user['role'],
                        'logged_in' => true
                    ];

                    session()->set($sessionData);

                    // Log login activity
                    try {
                        $this->db->table('logs')->insert([
                            'user_id'   => (int)$user['id'],
                            'aktivitas' => 'Login ke sistem',
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                    } catch (\Exception $logError) {
                        log_message('error', 'Error logging login: ' . $logError->getMessage());
                    }

                    return redirect()->to('/dashboard?login=success');
                } else {
                    return redirect()->back()
                        ->with('error', 'Email atau Password salah')
                        ->withInput();
                }
            } catch (\Exception $e) {
                log_message('error', 'Login error: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
            }
        }

        return view('auth/login');
    }

    public function logout()
    {
        // Log logout activity before destroying session
        if (session('user_id')) {
            try {
                $this->db->table('logs')->insert([
                    'user_id'   => (int)session('user_id'),
                    'aktivitas' => 'Logout dari sistem',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            } catch (\Exception $e) {
                log_message('error', 'Error logging logout: ' . $e->getMessage());
            }
        }

        session()->destroy();
        return redirect()->to('/auth/login?logout=success');
    }

    public function register()
    {
        helper(['form']);

        if ($this->request->getMethod() == 'POST') {
            // Validasi input
            // $rules = [
            //     'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            //     'email' => 'required|valid_email|is_unique[users.email]',
            //     'password' => 'required|min_length[6]',
            //     'confirm_password' => 'required|matches[password]'
            // ];

            $rules = [
                'username' => [
                    'rules' => 'required|min_length[4]|max_length[32]|is_unique[users.username]',
                    'errors' => [
                        'required' => 'Username wajib diisi.',
                        'min_length' => 'Username minimal 4 karakter.',
                        'max_length' => 'Username maksimal 32 karakter.',
                        'is_unique' => 'Username sudah digunakan.'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => 'Email wajib diisi.',
                        'valid_email' => 'Format email tidak valid.',
                        'is_unique' => 'Email sudah digunakan.'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|regex_match[/(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])/]',
                    'errors' => [
                        'required' => 'Password wajib diisi.',
                        'min_length' => 'Password minimal 8 karakter.',
                        'regex_match' => 'Password harus mengandung huruf besar, kecil, dan simbol.'
                    ]
                ],
                'confirm_password' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Konfirmasi password wajib diisi.',
                        'matches' => 'Konfirmasi password harus sama dengan password.'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return view('auth/register', [
                    'validation' => $this->validator
                ]);
            }

            try {
                // Simpan user baru
                $userModel = new UserModel();

                $userData = [
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'role' => 'user',
                    'is_active' => 1
                ];

                $userModel->save($userData);
                $userId = $userModel->getInsertID();

                // Log aktivitas pendaftaran
                try {
                    $this->db->table('logs')->insert([
                        'user_id' => (int)$userId,
                        'aktivitas' => 'Mendaftar sebagai user baru',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                } catch (\Exception $logError) {
                    log_message('error', 'Error logging registration: ' . $logError->getMessage());
                }

                session()->setFlashdata('success', 'Pendaftaran berhasil! Silakan login dengan email Anda.');
                return redirect()->to('/auth/login');
            } catch (\Exception $e) {
                log_message('error', 'Registration error: ' . $e->getMessage());
                return view('auth/register', [
                    'error' => 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage()
                ]);
            }
        }

        return view('auth/register');
    }
}