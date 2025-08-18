<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\UserModel;

class Log extends BaseController
{
    protected $logModel;
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->logModel = new LogModel();
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // // Reset filter jika fresh atau setelah reset
        // if ($this->request->getGet('fresh') == 1 || session()->getFlashdata('reset_filter')) {
        //     session()->remove('log_filters');
        // }

        $perPage = 10;
        $filters = session()->get('log_filters') ?? [
            'user_id' => '',
            'date_start' => '',
            'date_end' => '',
            'keyword' => ''
        ];

        // Ambil filter dari GET jika ada (untuk pagination/filter langsung)
        $userId = $this->request->getVar('user_id') ?? $filters['user_id'];
        $dateStart = $this->request->getVar('date_start') ?? $filters['date_start'];
        $dateEnd = $this->request->getVar('date_end') ?? $filters['date_end'];
        $keyword = $this->request->getVar('keyword') ?? $filters['keyword'];

        // Simpan filter ke session agar tetap aktif saat pindah halaman
        session()->set('log_filters', [
            'user_id' => $userId,
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'keyword' => $keyword
        ]);

        // Query builder dari model
        $logModel = $this->logModel
            ->select('logs.*, users.username')
            ->join('users', 'users.id = logs.user_id', 'left')
            ->orderBy('logs.created_at', 'DESC');

        // Terapkan filter
        if (!empty($userId)) {
            $logModel = $logModel->where('logs.user_id', $userId);
        }
        if (!empty($dateStart)) {
            $logModel = $logModel->where('logs.created_at >=', $dateStart . ' 00:00:00');
        }
        if (!empty($dateEnd)) {
            $logModel = $logModel->where('logs.created_at <=', $dateEnd . ' 23:59:59');
        }
        if (!empty($keyword)) {
            $logModel = $logModel->like('logs.aktivitas', $keyword);
        }

        // Pagination
        $logs = $logModel->paginate($perPage, 'default');
        $pager = $logModel->pager;

        $data = [
            'title' => 'Log Aktivitas Sistem',
            'logs' => $logs,
            'users' => $this->userModel->findAll(),
            'filters' => [
                'user_id' => $userId,
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'keyword' => $keyword
            ],
            'pager' => $pager,
            'perPage' => $perPage
        ];

        return view('log/index', $data);
    }

    public function filter()
    {
        try {
            $perPage = 10;
            $userId = $this->request->getPost('user_id');
            $dateStart = $this->request->getPost('date_start');
            $dateEnd = $this->request->getPost('date_end');
            $keyword = $this->request->getPost('keyword');

            // Simpan filter ke session untuk mempertahankan nilai
            session()->set('log_filters', [
                'user_id' => $userId,
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'keyword' => $keyword
            ]);

            // Query builder dari model
            $logModel = $this->logModel
                ->select('logs.*, users.username')
                ->join('users', 'users.id = logs.user_id', 'left')
                ->orderBy('logs.created_at', 'DESC');

            // Terapkan filter
            if (!empty($userId)) {
                $logModel = $logModel->where('logs.user_id', $userId);
            }
            if (!empty($dateStart)) {
                $logModel = $logModel->where('logs.created_at >=', $dateStart . ' 00:00:00');
            }
            if (!empty($dateEnd)) {
                $logModel = $logModel->where('logs.created_at <=', $dateEnd . ' 23:59:59');
            }
            if (!empty($keyword)) {
                $logModel = $logModel->like('logs.aktivitas', $keyword);
            }

            // Pagination
            $logs = $logModel->paginate($perPage, 'default');
            $pager = $logModel->pager;

            $data = [
                'title' => 'Log Aktivitas Sistem (Filtered)',
                'logs' => $logs,
                'users' => $this->userModel->findAll(),
                'filters' => [
                    'user_id' => $userId,
                    'date_start' => $dateStart,
                    'date_end' => $dateEnd,
                    'keyword' => $keyword
                ],
                'pager' => $pager,
                'perPage' => $perPage
            ];

            return view('log/index', $data);
        } catch (\Exception $e) {
            log_message('error', 'Log filter error: ' . $e->getMessage());
            return redirect()->to('admin/logs')->with('error', 'Terjadi kesalahan saat memfilter data: ' . $e->getMessage());
        }
    }

    public function resetFilter()
    {
        // Hapus filter dari session dengan lebih eksplisit
        session()->remove('log_filters');

        // Set flash data untuk memastikan view tahu ini adalah hasil reset
        session()->setFlashdata('reset_filter', true);

        // Redirect ke halaman logs dengan parameter fresh=1 untuk memastikan tidak ada cache
        return redirect()->to('admin/logs?fresh=1');
    }

    public function export()
    {
        try {
            // Gunakan filter dari session
            $filters = session()->get('log_filters') ?? [
                'user_id' => '',
                'date_start' => '',
                'date_end' => '',
                'keyword' => ''
            ];

            $userId = $filters['user_id'];
            $dateStart = $filters['date_start'];
            $dateEnd = $filters['date_end'];
            $keyword = $filters['keyword'];

            $builder = $this->db->table('logs');
            $builder->select('logs.id, logs.created_at, logs.aktivitas, users.username');
            $builder->join('users', 'users.id = logs.user_id', 'left');

            // Terapkan filter yang sama
            if (!empty($userId)) {
                $builder->where('logs.user_id', $userId);
            }

            if (!empty($dateStart)) {
                $builder->where('logs.created_at >=', $dateStart . ' 00:00:00');
            }

            if (!empty($dateEnd)) {
                $builder->where('logs.created_at <=', $dateEnd . ' 23:59:59');
            }

            if (!empty($keyword)) {
                $builder->like('logs.aktivitas', $keyword);
            }

            $builder->orderBy('logs.created_at', 'DESC');
            $logs = $builder->get()->getResultArray();

            // Buat nama file dengan timestamp
            $filename = 'log_aktivitas_' . date('Y-m-d_H-i-s') . '.csv';

            // Create file pointer 
            $f = fopen('php://memory', 'w');

            // Set column headers
            $fields = array('ID', 'Tanggal & Waktu', 'User', 'Aktivitas');
            fputcsv($f, $fields, ',');

            // Output each row of the data
            foreach ($logs as $log) {
                $lineData = array(
                    $log['id'],
                    $log['created_at'],
                    $log['username'] ?? 'Unknown',
                    $log['aktivitas']
                );
                fputcsv($f, $lineData, ',');
            }

            // Reset the file pointer to the beginning
            fseek($f, 0);

            // Set headers to download file
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            // Output all remaining data on the file pointer
            fpassthru($f);
            exit;
        } catch (\Exception $e) {
            log_message('error', 'Log export error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengekspor data: ' . $e->getMessage());
            return redirect()->to('admin/logs');
        }
    }
}
