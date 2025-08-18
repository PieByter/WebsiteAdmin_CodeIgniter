<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\LogModel;

class Barang extends BaseController
{
    protected $barangModel;
    protected $logModel;

    protected $db;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->logModel = new LogModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        try {
            // Set jumlah data per halaman
            $perPage = 10;

            // Ambil parameter pencarian jika ada
            $search = $this->request->getVar('search');

            // Query dengan kondisi pencarian
            if ($search) {
                $barangs = $this->barangModel
                    ->like('nama_barang', $search)
                    ->orLike('dekripsi', $search)
                    ->paginate($perPage, 'default');
            } else {
                $barangs = $this->barangModel->paginate($perPage, 'default');
            }

            $data = [
                'title' => 'Daftar Barang',
                'barangs' => $barangs,
                'pager' => $this->barangModel->pager,
                'search' => $search
            ];

            return view('barang/index', $data);
        } catch (\Exception $e) {
            log_message('error', 'Barang index error: ' . $e->getMessage());
            return view('barang/index', [
                'title' => 'Daftar Barang',
                'barangs' => [],
                'pager' => null,
                'search' => '',
                'error' => 'Gagal memuat data: ' . $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Barang Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('barang/create', $data);
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'nama_barang' => 'required',
            'dekripsi' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'foto' => [
                'rules' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]', //uploaded[foto]|
                'label' => 'Foto Barang',
                'errors' => [
                    'uploaded' => '{field} harus diupload.',
                    'is_image' => '{field} harus berupa gambar.',
                    'mime_in' => '{field} harus bertipe jpg, jpeg, atau png.',
                    'max_size' => '{field} ukuran maksimal 2MB.'
                ]
            ]
        ])) {
            // return redirect()->to('/admin/barang/create')
            //     ->withInput()
            //     ->with('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        try {

            // Proses upload file
            $fotoFile = $this->request->getFile('foto');
            $fotoName = 'default.jpg'; // nama default

            if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
                $fotoName = $fotoFile->getRandomName();
                $fotoFile->move('uploads/barang', $fotoName);
            }

            // Simpan data barang dulu
            $data = [
                'nama_barang' => $this->request->getVar('nama_barang'),
                'dekripsi' => $this->request->getVar('dekripsi'),
                'kategori' => $this->request->getVar('kategori'),
                'stok' => $this->request->getVar('stok'),
                'harga' => $this->request->getVar('harga'),
                'foto' => $fotoName
            ];

            $this->barangModel->save($data);
            $barangId = $this->barangModel->getInsertID();

            // Coba logging, tapi jangan batalkan jika gagal
            try {
                // Gunakan tabel logs sesuai model yang sudah diubah
                $this->db->table('logs')->insert([
                    'user_id' => (int)session('user_id'),
                    'aktivitas' => 'Menambahkan barang baru: ' . $this->request->getVar('nama_barang'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            } catch (\Exception $logError) {
                // Hanya log error, jangan batalkan operasi utama
                log_message('error', 'Error logging: ' . $logError->getMessage());
            }

            // Set flash message
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

            // Redirect ke halaman barang - PASTIKAN URL INI BENAR
            return redirect()->to('/admin/barang');
        } catch (\Exception $e) {
            log_message('error', 'Barang save error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());
            return redirect()->to('/admin/barang/create')->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $data = [
                'title' => 'Edit Barang',
                'validation' => \Config\Services::validation(),
                'barang' => $this->barangModel->find($id)
            ];

            if (empty($data['barang'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang dengan ID ' . $id . ' tidak ditemukan');
            }

            return view('barang/edit', $data);
        } catch (\Exception $e) {
            log_message('error', 'Barang edit error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal memuat data: ' . $e->getMessage());
            return redirect()->to('/admin/barang');
        }
    }

    public function update($id)
    {
        try {
            // Validasi
            if (!$this->validate([
                'nama_barang' => 'required',
                'dekripsi' => 'required',
                'kategori' => 'required',
                'stok' => 'required|numeric',
                'harga' => 'required|numeric',
                'foto' => [
                    'rules' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                    'label' => 'Foto Barang',
                    'errors' => [
                        'max_size' => '{field} maksimal 2MB.',
                        'is_image' => '{field} harus berupa gambar.',
                        'mime_in' => '{field} harus jpg/jpeg/png.'
                    ]
                ]
            ])) {
                // return redirect()->to('/admin/barang/edit/' . $id)
                //     ->withInput()
                //     ->with('validation', $this->validator);
                return redirect()->back()->withInput();
            }

            $barangLama = $this->barangModel->find($id);
            if (empty($barangLama)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang dengan ID ' . $id . ' tidak ditemukan');
            }

            $fotoFile = $this->request->getFile('foto');
            $fotoName = $barangLama['foto'] ?? 'default.jpg';

            // Jika ada file baru diupload
            if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
                $fotoNameBaru = $fotoFile->getRandomName();
                $fotoFile->move('uploads/barang', $fotoNameBaru);

                // Hapus foto lama jika bukan default
                if (!empty($fotoName) && $fotoName !== 'default.jpg') {
                    $fotoPathLama = FCPATH . 'uploads/barang/' . $fotoName;
                    if (is_file($fotoPathLama)) {
                        @unlink($fotoPathLama);
                    }
                }
                $fotoName = $fotoNameBaru;
            }

            $stokLama = $barangLama['stok'];
            $stokBaru = $this->request->getVar('stok');

            // Update data
            $data = [
                'id' => $id,
                'nama_barang' => $this->request->getVar('nama_barang'),
                'dekripsi' => $this->request->getVar('dekripsi'),
                'kategori' => $this->request->getVar('kategori'),
                'stok' => $stokBaru,
                'harga' => $this->request->getVar('harga'),
                'foto' => $fotoName
            ];

            $this->barangModel->save($data);

            // Log perubahan
            $logMessage = 'Mengubah data barang: ' . $this->request->getVar('nama_barang');
            if ($stokLama != $stokBaru) {
                $logMessage .= ' (perubahan stok dari ' . $stokLama . ' ke ' . $stokBaru . ')';
            }
            try {
                $this->db->table('logs')->insert([
                    'user_id' => (int)session('user_id'),
                    'aktivitas' => $logMessage,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            } catch (\Exception $logError) {
                log_message('error', 'Error logging update: ' . $logError->getMessage());
            }

            session()->setFlashdata('pesan', 'Data berhasil diubah');
            return redirect()->to('/admin/barang');
        } catch (\Exception $e) {
            log_message('error', 'Barang update error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal memperbarui data: ' . $e->getMessage());
            return redirect()->to('/admin/barang/edit/' . $id)->withInput();
        }
    }

    public function delete($id)
    {
        try {
            // Ambil data barang untuk log
            $barang = $this->barangModel->find($id);

            if (!$barang) {
                throw new \Exception('Barang tidak ditemukan');
            }

            // Hapus file foto jika bukan default
            if (!empty($barang['foto']) && $barang['foto'] !== 'default.jpg') {
                $fotoPath = FCPATH . 'uploads/barang/' . $barang['foto'];
                if (is_file($fotoPath)) {
                    @unlink($fotoPath);
                }
            }

            // Hapus barang dulu
            $this->barangModel->delete($id);

            // Catat log - dalam try-catch terpisah
            try {
                $this->db->table('logs')->insert([
                    'user_id' => (int)session('user_id'),
                    'aktivitas' => 'Menghapus barang: ' . $barang['nama_barang'],
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            } catch (\Exception $logError) {
                // Hanya log error
                log_message('error', 'Error logging delete: ' . $logError->getMessage());
            }

            session()->setFlashdata('pesan', 'Data berhasil dihapus');
            return redirect()->to('/admin/barang');
        } catch (\Exception $e) {
            log_message('error', 'Barang delete error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal menghapus data: ' . $e->getMessage());
            return redirect()->to('/admin/barang');
        }
    }
}
