<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisIklanUtamaModel extends Model
{
    protected $table = 'tb_jenis_iklan_utama'; 
    protected $primaryKey = 'id_jenis_iklan_utama'; 

    protected $allowedFields = ['nama', 'harga', 'status', 'created_at'];

    protected $useTimestamps = false; 
    protected $returnType='array';
}