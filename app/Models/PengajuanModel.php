<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanModel extends Model
{
    protected $table = 'tb_pengajuan_user';
    protected $primaryKey = 'id_user'; 
    protected $allowedFields = [
        'username', 'email', 'password', 'full_name', 
        'role', 'kontak', 'bank_account_number', 
        'artikel', 'is_active', 'created_at', 'updated_at','status'
    ];

    public function getPendingAktivitas()
    {
        return $this->select('created_at AS tanggal')
                    ->where('status', 'pending')
                    ->findAll();
    }

}