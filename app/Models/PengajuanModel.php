<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanModel extends Model
{
    protected $table = 'tb_pengajuan';
    protected $primaryKey = 'id_user'; 
    protected $allowedFields = [
        'username', 'email', 'password', 'full_name', 
        'role', 'kontak', 'bank_account_number', 
        'artikel', 'is_active', 'created_at', 'updated_at','status'
    ];
}