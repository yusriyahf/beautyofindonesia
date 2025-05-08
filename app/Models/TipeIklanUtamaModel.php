<?php

namespace App\Models;

use CodeIgniter\Model;

class TipeIklanUtamaModel extends Model
{
    protected $table = 'tb_tipe_iklan_utama'; 
    protected $primaryKey = 'id_tipe_iklan_utama'; 

    protected $allowedFields = ['nama', 'harga', 'status', 'created_at'];

    protected $useTimestamps = false; 
    protected $returnType='array';
}