<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barangs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_barang', 'dekripsi', 'kategori', 'stok', 'harga', 'foto', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';
}