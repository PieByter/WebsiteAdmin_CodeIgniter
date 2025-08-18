<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'start',
        'end',
        'description',
        'created_at',
        'user_id'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
