<?php

namespace App\Models;

use CodeIgniter\Model;

class PenarikanUserModel extends Model
{
    protected $table = 'tb_penarikan_komisi';
    protected $primaryKey = 'id_penarikan_komisi';
    protected $returnType = 'array';
    protected $allowedFields = ['id_penarikan_komisi ', 'user_id', 'jumlah', 'status', 'bukti_transfer', 'catatan' ,'tanggal_pengajuan', 'tanggal_persetujuan'];

    public function getPenarikan()
    {
        return $this->select('tb_penarikan_komisi.*, tb_users.username, tb_users.bank_account_number, tb_users.kontak, tb_users.role')
            ->join('tb_users', 'tb_users.id_user = tb_penarikan_komisi.user_id')
            ->findAll();
    }
}
