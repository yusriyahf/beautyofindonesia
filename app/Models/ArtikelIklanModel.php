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
        'thumbnail_iklan',
        'link_iklan',
        'no_pengaju',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan_admin',
        'alasan_penolakan',
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

    public function getArtikelByFilter($startDate = null, $endDate = null, $status = null)
    {
        $builder = $this->table('tb_artikel_iklan')
            ->select('tb_artikel_iklan.*, tb_artikel.judul_artikel, tb_harga_iklan.nama AS nama_iklan, tb_users.username, tb_users.kontak')
            ->join('tb_artikel', 'tb_artikel.id_artikel = tb_artikel_iklan.id_content')
            ->join('tb_harga_iklan', 'tb_harga_iklan.id_harga_iklan = tb_artikel_iklan.id_harga_iklan')
            ->join('tb_users', 'tb_users.id_user = tb_artikel_iklan.id_marketing');
        // ->findAll();
        if ($startDate) {
            $builder->where('tanggal_mulai >=', $startDate);
        }

        if ($endDate) {
            $builder->where('tanggal_selesai <=', $endDate);
        }

        if ($status) {
            $builder->where('status = ', $status);
        }

        return $builder->get()->getResultArray();
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

    // Untuk marketing - tampilkan iklan yang dibuat oleh marketing tersebut
    public function getArtikelIklanByMarketing($idMarketing, $startDate = null, $endDate = null)
    {
        $builder = $this->db->table('tb_artikel_iklan')
            ->where('id_marketing', $idMarketing);

        if ($startDate && $endDate) {
            $builder->where('created_at >=', $startDate)
                ->where('created_at <=', $endDate);
        }

        return $builder->get()->getResultArray();
    }

    // Untuk penulis - tampilkan iklan yang kontennya dibuat oleh penulis tersebut
    public function getArtikelIklanByPenulis($idPenulis, $startDate = null, $endDate = null)
    {
        // Dapatkan semua konten yang dibuat oleh penulis ini
        $artikelPenulis = $this->db->table('tb_artikel')
            ->where('id_penulis', $idPenulis)
            ->get()->getResultArray();

        $wisataPenulis = $this->db->table('tb_tempatwisata')
            ->where('id_penulis', $idPenulis)
            ->get()->getResultArray();

        $olehOlehPenulis = $this->db->table('tb_oleholeh')
            ->where('id_penulis', $idPenulis)
            ->get()->getResultArray();

        // Kumpulkan semua id konten
        $contentIds = [];
        foreach ($artikelPenulis as $artikel) {
            $contentIds[] = ['id' => $artikel['id_artikel'], 'type' => 'artikel'];
        }
        foreach ($wisataPenulis as $wisata) {
            $contentIds[] = ['id' => $wisata['id_wisata'], 'type' => 'tempatwisata'];
        }
        foreach ($olehOlehPenulis as $oleholeh) {
            $contentIds[] = ['id' => $oleholeh['id_oleholeh'], 'type' => 'oleholeh'];
        }

        // Jika tidak ada konten, return array kosong
        if (empty($contentIds)) {
            return [];
        }

        // Buat query untuk mencari iklan yang terkait dengan konten penulis
        $builder = $this->db->table('tb_artikel_iklan');

        $whereGroup = [];
        foreach ($contentIds as $content) {
            $whereGroup[] = "(id_content = {$content['id']} AND tipe_content = '{$content['type']}')";
        }

        $builder->where('(' . implode(' OR ', $whereGroup) . ')');

        if ($startDate && $endDate) {
            $builder->where('created_at >=', $startDate)
                ->where('created_at <=', $endDate);
        }

        return $builder->get()->getResultArray();
    }

    public function updateStatusIklan()
    {
        $today = date('Y-m-d');

        // Update status 'berjalan'
        $builder = $this->builder();

        $builder->where('status_iklan', 'diterima')
            ->where("tanggal_mulai IS NOT NULL", null, false)
            ->where("tanggal_selesai IS NOT NULL", null, false)
            ->where('tanggal_mulai <=', $today)
            ->where('tanggal_selesai >=', $today)
            ->set(['status_iklan' => 'berjalan'])
            ->update();

        // Update status 'selesai'
        $builder = $this->builder();

        $builder->where('status_iklan', 'berjalan')
            ->where("tanggal_selesai IS NOT NULL", null, false)
            ->where('tanggal_selesai <', $today)
            ->set(['status_iklan' => 'selesai'])
            ->update();
    }

    //ambil tanggal mulai
    public function getAktivitasIklan($user_id)
    {
        return $this->select("tanggal_mulai as tanggal, 'iklan' as jenis, 'Iklan ditayangkan di artikel Anda' as keterangan")
            ->where('id_marketing', $user_id)
            ->where('tanggal_mulai IS NOT NULL', null, false)
            ->where('LENGTH(tanggal_mulai) > 0', null, false)
            ->orderBy('tanggal_mulai', 'DESC')
            ->findAll();
    }

    public function getDiajukanAktivitas()
    {
        return $this->select('dibuat_pada AS tanggal')
            ->where('status_iklan', 'diajukan')
            ->findAll();
    }

    public function getLinkIklanByArtikelId($id_content)
    {
        $iklan = $this->db->table('tb_artikel_iklan')
            ->where('id_content', $id_content)
            ->where('status_iklan', 'berjalan')
            ->get()
            ->getRowArray();

        if (!$iklan) {
            return null; // Tidak ada iklan aktif
        }

        $tipe = $iklan['tipe_content'];
        $valid = false;

        // Validasi apakah id_content memang ada di tabel sesuai tipe
        if ($tipe === 'artikel') {
            $valid = $this->db->table('tb_artikel')->where('id_artikel', $id_content)->countAllResults() > 0;
        } elseif ($tipe === 'tempatwisata') {
            $valid = $this->db->table('tb_tempatwisata')->where('id_wisata', $id_content)->countAllResults() > 0;
        } elseif ($tipe === 'oleholeh') {
            $valid = $this->db->table('tb_oleholeh')->where('id_oleholeh', $id_content)->countAllResults() > 0;
        }

        if ($valid) {
            return [
                'link_iklan' => $iklan['link_iklan'],
                'thumbnail_iklan' => $iklan['thumbnail_iklan'],
            ];
        }

        return null; // Tidak valid, mungkin konten sudah dihapus
    }


    public function getTipeIklanArtikel($id_content, $tipe_konten)
    {
        return $this->db->table('tb_artikel_iklan')
            ->select('tb_artikel_iklan.id_content, tb_harga_iklan.nama')
            ->where('tb_artikel_iklan.id_content', $id_content)
            ->where('tb_artikel_iklan.tipe_content', $tipe_konten)
            ->join('tb_harga_iklan', 'tb_harga_iklan.id_harga_iklan = tb_artikel_iklan.id_harga_iklan')
            ->get()
            ->getResult();
    }

    public function updateCustomField($id_content, $column, $tipe_content)
    {
        $table = 'tb_' . $tipe_content;
        $id = $this->getContentId($tipe_content);

        return $this->db->table($table)
            ->where($id, $id_content)
            ->update([$column => 'ada']);
    }

    public function checkCustomField($id_content, $column, $tipe_content)
    {
        $table = 'tb_' . $tipe_content;
        $id = $this->getContentId($tipe_content);

        return $this->db->table($table)
            ->select($column)
            ->where($id, $id_content)
            ->get()
            ->getResult();
    }

    // get field tempat wisata
    private function getContentId($tipe_content): string
    {
        return ($tipe_content === 'tempatwisata') ? 'id_wisata' : 'id_' . $tipe_content;
    }
}
