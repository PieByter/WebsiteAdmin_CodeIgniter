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
        'user_id',
        'color'
    ];
    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // // protected $updatedField = 'updated_at';
}
