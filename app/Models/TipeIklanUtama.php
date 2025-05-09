<?php

namespace App\Models;

use CodeIgniter\Model;

class TipeIklanUtama extends Model
{
    protected $table = 'tb_tipe_iklan_utama';
    protected $primaryKey = 'id_tipe_iklan_utama';
    protected $returnType = 'array';
    protected $allowedFields = ['id_tipe_iklan_utama', 'nama', 'harga', 'status', 'created_at'];

    public function cekTipeIklan($nama)
    {
        return $this->where('nama', $nama)->first();
    }
}
