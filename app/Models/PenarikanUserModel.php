<?php

namespace App\Models;

use CodeIgniter\Model;

class PenarikanUserModel extends Model
{
    protected $table = 'tb_penarikan_user';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id_popup', 'user_id', 'jumlah', 'status', 'tanggal_pengajuan', 'tanggal_persetujuan', 'catatan'];
}
