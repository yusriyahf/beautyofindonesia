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
        'tanggal_pengajuan',
        'total_harga',
        'rentang_bulan',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan_admin',
        'dibuat_pada',
        'diperbarui_pada'
    ];

    public function getArtikelIklanAnjay()
    {
        return $this->select('
                    tb_artikel_iklan.*,
                    tb_harga_iklan.nama as nama_iklan,
                    tb_users.full_name as nama_marketing
                ')
            ->join('tb_harga_iklan', 'tb_harga_iklan.id_harga_iklan = tb_artikel_iklan.id_harga_iklan', 'left')
            ->join('tb_users', 'tb_users.id_user = tb_artikel_iklan.id_marketing', 'left')
            ->findAll();
    }

    // Mendapatkan artikel iklan dengan informasi terkait
    public function getArtikelIklanByDateFilter($startDate = null, $endDate = null)
    {
        $builder = $this->builder();

        // Join tabel terkait untuk mendapatkan data yang dibutuhkan
        $builder->select('
            tb_artikel_iklan.*, 
            tb_artikel.judul_artikel, 
            tb_harga_iklan.nama AS nama_iklan,
            tb_users.username, 
            tb_users.kontak
        ')
            ->join('tb_artikel', 'tb_artikel.id_artikel = tb_artikel_iklan.id_content')
            ->join('tb_harga_iklan', 'tb_harga_iklan.id_harga_iklan = tb_artikel_iklan.id_harga_iklan')
            ->join('tb_users', 'tb_users.id_user = tb_artikel_iklan.id_marketing');

        // Filter berdasarkan tanggal jika ada
        if ($startDate) {
            $builder->where('tanggal_mulai >=', $startDate);
        }

        if ($endDate) {
            $builder->where('tanggal_selesai <=', $endDate);
        }

        // Menggunakan get() untuk menjalankan query
        return $builder->get()->getResultArray();
    }



    public function getArtikelIklan()
    {
        return $this->select('
            tb_artikel_iklan.*, 
            tb_artikel.judul_artikel, 
            tb_harga_iklan.nama AS nama_iklan, 
            tb_users.username, 
            tb_users.kontak
        ')
            ->join('tb_artikel', 'tb_artikel.id_artikel = tb_artikel_iklan.id_content')
            ->join('tb_harga_iklan', 'tb_harga_iklan.id_harga_iklan = tb_artikel_iklan.id_harga_iklan')
            ->join('tb_users', 'tb_users.id_user = tb_artikel_iklan.id_marketing')
            ->findAll();
    }

    //ngitung iklan diterima/disetujui(?)
    public function countIklanDiterimaByMarketing($id_user)
    {
        return $this->where('status_iklan', 'diterima')
            ->where('id_marketing', $id_user)
            ->countAllResults();
    }

    public function countIklanDitolakByMarketing($id_user)
    {
        return $this->where('status_iklan', 'ditolak')
            ->where('id_marketing', $id_user)
            ->countAllResults();
    }

    public function countIklanDiajukan($id_user)
    {
        return $this->where('status_iklan', 'diajukan')
            ->where('id_marketing', $id_user)
            ->countAllResults();
    }
}
