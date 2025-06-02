<?php

namespace App\Models;

use CodeIgniter\Model;

class IklanUtamaModel extends Model
{
    protected $table = 'tb_iklan_utama';
    protected $primaryKey = 'id_iklan_utama';
    protected $returnType = 'array';
    protected $allowedFields = ['id_iklan_utama', 'id_tipe_iklan_utama', 'id_marketing', 'jenis', 'rentang_bulan', 'tanggal_mulai', 'tanggal_selesai', 'id_iklan_utama', 'thumbnail_iklan', 'tanggal_pengajuan', 'status', 'alasan_penolakan', 'total_harga', 'link_iklan', 'jumlah_klik', 'dibuat_pada', 'diupdate_pada', 'diperbarui_pada'];

    public function getIklanAktifByTipe($idTipe)
    {
        $today = date('Y-m-d');
        return $this->where('id_tipe_iklan_utama', $idTipe)
            ->where('tanggal_mulai <=', $today)
            ->where('tanggal_selesai >=', $today)
            ->first();
    }

    public function getAllWithUserAndTipe()
    {
        return $this->select('
            tb_iklan_utama.*, 
            tb_users.username, 
            tb_tipe_iklan_utama.nama as nama_tipe_iklan_utama,
        ')
            ->join('tb_users', 'tb_users.id_user = tb_iklan_utama.id_marketing', 'left')
            ->join('tb_tipe_iklan_utama', 'tb_tipe_iklan_utama.id_tipe_iklan_utama = tb_iklan_utama.id_tipe_iklan_utama', 'left')
            ->findAll();
    }
}
