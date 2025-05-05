<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisIklanUtama extends Model
{
    protected $table = 'tb_jenis_iklan_utama';
    protected $primaryKey = 'id_jenis_iklan_utama';
    protected $returnType = 'array';
    protected $allowedFields = ['id_jenis_iklan_utama', 'nama', 'harga', 'status', 'created_at'];
}
