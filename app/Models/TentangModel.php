<?php

namespace App\Models;

use CodeIgniter\Model;

class TentangModel extends Model
{
    protected $table = "tb_tentang";
    protected $primaryKey = "id_tentang";
    protected $returnType = "object";
    protected $allowedFields = ['id_tentang', 'nama_tentang', 'foto_tentang', 'deskripsi_tentang', 'deskripsi_tentang_en', 'alamat', 'no_telp', 'email', 'instagram', 'tiktok', 'youtube', 'footer', 'username', 'password', 'slogan']; // Added 'slogan'


    public function getTentangDepan()
    {
        return $this->db->table('tb_tentang')->get()->getResultArray();
    }

    public function getNamaTentang()
    {
        $data = $this->db->table('tb_tentang')->select('nama_tentang')->get()->getRow();
        return ($data) ? $data->nama_tentang : '';
    }

    public function getTentang()
    {
        if (isset($_SESSION['username'])) {
            // Ambil data panduan khusus dari pengguna yang sedang login
            $userData = $this->db->table('tb_tentang')
                ->where('username', $_SESSION['username'])
                ->get()
                ->getResultArray();

            return $userData;
        }
    }
}
