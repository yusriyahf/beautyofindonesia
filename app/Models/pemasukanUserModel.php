<?php

namespace App\Models;

use CodeIgniter\Model;

class PemasukanUserModel extends Model
{
    protected $table = 'tb_pemasukan_komisi';
    protected $primaryKey = 'id_pemasukan_komisi';
    protected $returnType = 'array';
    protected $allowedFields = ['id_pemasukan_komisi', 'user_id', 'jumlah', 'tanggal_pemasukan'];
}
