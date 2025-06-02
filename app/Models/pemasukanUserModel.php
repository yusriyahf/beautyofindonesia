<?php

namespace App\Models;

use CodeIgniter\Model;

class PemasukanUserModel extends Model
{
    protected $table = 'tb_pemasukan_komisi';
    protected $primaryKey = 'id_pemasukan_komisi';
    protected $returnType = 'array';
    protected $allowedFields = ['id_pemasukan_komisi ', 'user_id', 'jumlah', 'status', 'tanggal_pemasukan', 'keterangan', 'id_iklan', 'tipe_iklan'];

    public function getTotalKomisiPenulis($user_id)
    {
        return $this->select('jumlah') // Memilih kolom 'jumlah'
                    ->where('user_id', $user_id) // Menyesuaikan dengan user_id
                    ->findAll(); // Mengambil semua baris yang cocok
    }
}
