<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelIklanModel extends Model
{
    protected $table = 'tb_artikel_iklan';
    protected $primaryKey = 'id_iklan';
    protected $returnType = 'array';
    protected $allowedFields = ['id', 'id_artikel', 'id_iklan', 'id_penulis', 'tanggal_mulai', 'tanggal_selesai', 'status'];

    public function getArtikelIklan()
    {
        return $this->select('
            tb_artikel_iklan.*, 
            tb_artikel.judul_artikel, 
            tb_harga_iklan.nama AS nama_iklan, 
            tb_users.username, 
            tb_users.kontak
        ')
            ->join('tb_artikel', 'tb_artikel.id_artikel = tb_artikel_iklan.id_artikel')
            ->join('tb_harga_iklan', 'tb_harga_iklan.id = tb_artikel_iklan.id_iklan')
            ->join('tb_users', 'tb_users.id_user = tb_artikel_iklan.id_penulis')
            ->findAll();
    }
}
