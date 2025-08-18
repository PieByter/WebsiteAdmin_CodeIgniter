<?php

namespace App\Controllers;

class Settings extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Ambil semua pengaturan dari database
        $settings = $this->db->table('settings')
            ->get()
            ->getResultArray();

        // Format sebagai key-value
        $settingsArray = [];
        foreach ($settings as $setting) {
            $settingsArray[$setting['setting_key']] = $setting['setting_value'];
        }

        $data = [
            'title' => 'Pengaturan Sistem',
            'settings' => $settingsArray
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        // Validasi input
        $rules = [
            'app_name' => 'required',
            'app_description' => 'required',
            'admin_email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            // return redirect()->to('/admin/settings')
            //     ->withInput()
            //     ->with('validation', $this->validator);
            return redirect()->back()->withInput();
        }

        // Update settings
        $settings = [
            'app_name' => $this->request->getVar('app_name'),
            'app_description' => $this->request->getVar('app_description'),
            'admin_email' => $this->request->getVar('admin_email'),
            'maintenance_mode' => $this->request->getVar('maintenance_mode') ?? '0',
            'items_per_page' => $this->request->getVar('items_per_page') ?? '10'
        ];

        foreach ($settings as $key => $value) {
            // Cek apakah setting sudah ada
            $existing = $this->db->table('settings')
                ->where('setting_key', $key)
                ->get()
                ->getRowArray();

            if ($existing) {
                // Update
                $this->db->table('settings')
                    ->where('setting_key', $key)
                    ->update(['setting_value' => $value]);
            } else {
                // Insert
                $this->db->table('settings')
                    ->insert([
                        'setting_key' => $key,
                        'setting_value' => $value
                    ]);
            }
        }

        // Log aktivitas
        try {
            $this->db->table('logs')->insert([
                'user_id' => session('user_id'),
                'aktivitas' => 'Mengubah pengaturan sistem',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error logging settings update: ' . $e->getMessage());
        }

        session()->setFlashdata('pesan', 'Pengaturan berhasil disimpan');
        return redirect()->to('/admin/settings');
    }

    public function backup()
    {
        try {
            // Koneksi database
            $db = \Config\Database::connect();

            // Informasi database
            $dbhost = $db->hostname;
            $dbuser = $db->username;
            $dbpass = $db->password;
            $dbname = $db->database;

            // Nama file
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';

            // Buat header untuk file SQL
            $output = "-- Database Backup for $dbname\n";
            $output .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
            $output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            // Dapatkan semua tabel
            $tables = $db->listTables();

            // Untuk setiap tabel
            foreach ($tables as $table) {
                // Tambahkan DROP TABLE
                $output .= "DROP TABLE IF EXISTS `$table`;\n\n";

                // Dapatkan CREATE TABLE
                $query = $db->query("SHOW CREATE TABLE `$table`");
                $row = $query->getRowArray();
                $output .= $row['Create Table'] . ";\n\n";

                // Dapatkan data tabel
                $query = $db->query("SELECT * FROM `$table`");
                $rows = $query->getResultArray();

                if (count($rows) > 0) {
                    $output .= "INSERT INTO `$table` VALUES\n";
                    $firstRow = true;

                    foreach ($rows as $row) {
                        if (!$firstRow) {
                            $output .= ",\n";
                        } else {
                            $firstRow = false;
                        }

                        $output .= "(";
                        $firstCol = true;

                        foreach ($row as $col) {
                            if (!$firstCol) {
                                $output .= ",";
                            } else {
                                $firstCol = false;
                            }

                            if ($col === null) {
                                $output .= "NULL";
                            } else {
                                $output .= "'" . $db->escapeString($col) . "'";
                            }
                        }

                        $output .= ")";
                    }

                    $output .= ";\n\n";
                }
            }

            $output .= "SET FOREIGN_KEY_CHECKS=1;\n";

            // Log aktivitas
            try {
                $db->table('logs')->insert([
                    'user_id' => (int)session('user_id'),
                    'aktivitas' => 'Melakukan backup database',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            } catch (\Exception $e) {
                log_message('error', 'Error logging database backup: ' . $e->getMessage());
            }

            // Force download SQL file
            return $this->response
                ->setHeader('Content-Type', 'application/octet-stream')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->setHeader('Content-Length', strlen($output))
                ->setBody($output);
        } catch (\Exception $e) {
            log_message('error', 'Backup error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal melakukan backup: ' . $e->getMessage());
            return redirect()->to('/admin/settings');
        }
    }
}
