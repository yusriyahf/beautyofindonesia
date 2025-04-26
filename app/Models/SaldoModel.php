<?php

namespace App\Models;

use CodeIgniter\Model;

class SaldoModel extends Model
{
    protected $table = 'view_saldo_user';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_id', 'nama', 'total_masuk', 'total_keluar', 'saldo'];
    protected $returnType = 'array';
}
