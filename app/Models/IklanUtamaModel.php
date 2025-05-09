<?php

namespace App\Models;

use CodeIgniter\Model;

class IklanUtamaModel extends Model
{
    protected $table = 'tb_iklan_utama';
    protected $primaryKey = 'id_iklan_utama';
    protected $returnType = 'array';
    protected $allowedFields = ['id_iklan_utama', 'id_tipe_iklan_utama', 'id_marketing', 'jenis', 'rentang_bulan', 'tanggal_mulai', 'tanggal_selesai', 'id_iklan_utama', 'thumbnail_iklan', 'tanggal_pengajuan', 'status', 'harga', 'link_iklan', 'jumlah_klik'];

    public function getIklanAktifByTipe($idTipe)
    {
        $today = date('Y-m-d');
        return $this->where('id_tipe_iklan_utama', $idTipe)
            ->where('tanggal_mulai <=', $today)
            ->where('tanggal_selesai >=', $today)
            ->first();
    }
}
