<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelIklanModel extends Model
{
    protected $table = 'tb_artikel_iklan';
    protected $primaryKey = 'id_iklan';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_iklan',
        'id_content',
        'tipe_content',
        'id_marketing',
        'id_harga_iklan',
        'status_iklan',
        'total_harga',
        'rentang_bulan',
        'tanggal_pengajuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan_admin',
        'dibuat_pada',
        'diperbarui_pada'
    ];

    // Auto timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'dibuat_pada';
    protected $updatedField  = 'diperbarui_pada';

    public function getArtikelIklanByDateFilter($startDate = null, $endDate = null)
    {
        $builder = $this->db->table($this->table);

        $builder->select('
            tb_artikel_iklan.*,
            tb_artikel.judul_artikel,
            tb_tempatwisata.nama_wisata_ind,
            tb_oleholeh.nama_oleholeh,
            tb_harga_iklan.nama AS nama_iklan,
            tb_users.username,
            tb_users.kontak
        ')
        ->join('tb_artikel', 'tb_artikel.id_artikel = tb_artikel_iklan.id_content', 'left')
        ->join('tb_tempatwisata', 'tb_tempatwisata.id_wisata = tb_artikel_iklan.id_content', 'left')
        ->join('tb_oleholeh', 'tb_oleholeh.id_oleholeh = tb_artikel_iklan.id_content', 'left')
        ->join('tb_harga_iklan', 'tb_harga_iklan.id_harga_iklan = tb_artikel_iklan.id_harga_iklan')
        ->join('tb_users', 'tb_users.id_user = tb_artikel_iklan.id_marketing');

        if ($startDate) {
            $builder->where('tanggal_mulai >=', $startDate);
        }

        if ($endDate) {
            $builder->where('tanggal_selesai <=', $endDate);
        }

        return $builder->get()->getResultArray();
    }

    public function getArtikelIklan()
    {
        $builder = $this->db->table($this->table);

        return $builder->select('
            tb_artikel_iklan.*,
            tb_artikel.judul_artikel,
            tb_tempatwisata.nama_wisata_ind,
            tb_oleholeh.nama_oleholeh,
            tb_harga_iklan.nama AS nama_iklan,
            tb_users.username,
            tb_users.kontak
        ')
        ->join('tb_artikel', 'tb_artikel.id_artikel = tb_artikel_iklan.id_content', 'left')
        ->join('tb_tempatwisata', 'tb_tempatwisata.id_wisata = tb_artikel_iklan.id_content', 'left')
        ->join('tb_oleholeh', 'tb_oleholeh.id_oleholeh = tb_artikel_iklan.id_content', 'left')
        ->join('tb_harga_iklan', 'tb_harga_iklan.id_harga_iklan = tb_artikel_iklan.id_harga_iklan')
        ->join('tb_users', 'tb_users.id_user = tb_artikel_iklan.id_marketing')
        ->get()->getResultArray();
    }
}
