<?php

namespace App\Models;

use CodeIgniter\Model;

class KomisiUserModel extends Model
{
    protected $table = 'tb_komisi_user';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id_popup', 'user_id', 'jumlah', 'keterangan'];
}
