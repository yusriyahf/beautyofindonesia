<?php

namespace App\Models;

use CodeIgniter\Model;

class PenarikanUserModel extends Model
{
    protected $table = 'tb_penarikan_komisi';
    protected $primaryKey = 'id_penarikan_komisi';
    protected $returnType = 'array';
    protected $allowedFields = ['id_penarikan_komisi ', 'user_id', 'jumlah', 'status', 'tanggal_pengajuan', 'tanggal_persetujuan'];
}
