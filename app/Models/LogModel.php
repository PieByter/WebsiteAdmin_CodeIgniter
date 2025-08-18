<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'aktivitas', 'created_at'];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    public function addLog($userId, $activity)
    {
        try {
            $db = \Config\Database::connect();
            return $db->table($this->table)->insert([
                'user_id' => (int)$userId,
                'aktivitas' => $activity,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error adding log: ' . $e->getMessage());
            return false;
        }
    }
}
