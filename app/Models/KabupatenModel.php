<?php

namespace App\Models;

use CodeIgniter\Model;

class KabupatenModel extends Model
{
    protected $table = 'tb_kotakabupaten';
    protected $primaryKey = 'id_kotakabupaten';
    protected $returnType = 'array';
    protected $allowedFields = ['id_kotakabupaten', 'nama_kotakabupaten_eng', 'nama_kotakabupaten', 'id_provinsi', 'slug_kotakabupaten_ind', 'slug_kotakabupaten_eng'];

    public function getKotakabupatenBySlug($slug)
    {
        return $this->where('slug_kotakabupaten_ind', $slug)
            ->orWhere('slug_kotakabupaten_eng', $slug)
            ->select('id_kotakabupaten', 'nama_kotakabupaten', 'nama_kotakabupaten_eng', 'id_provinsi')
            ->first();
    }

    public function getKabupaten($lang = 'id')
    {
        $nama_kabupaten_field = ($lang === 'en') ? 'nama_kotakabupaten_eng' : 'nama_kotakabupaten';
        $nama_provinsi_field = ($lang === 'en') ? 'nama_provinsi_eng' : 'nama_provinsi';

        return $this->db->table($this->table)
            ->select("tb_kotakabupaten.id_kotakabupaten, $nama_kabupaten_field AS nama_kotakabupaten, $nama_provinsi_field AS nama_provinsi, tb_kotakabupaten.nama_kotakabupaten_eng AS nama_kotakabupaten_eng")
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->get()
            ->getResultArray();
    }

    public function getKabupatenSlug($lang = 'id')
    {
        $nama_kabupaten_field = ($lang === 'en') ? 'nama_kotakabupaten_eng' : 'nama_kotakabupaten';
        $slug_field = ($lang === 'en') ? 'slug_kotakabupaten_eng' : 'slug_kotakabupaten_ind';

        return $this->db->table($this->table)
            ->select("$slug_field AS slug_kotakabupaten, $nama_kabupaten_field AS nama_kotakabupaten")
            ->get()
            ->getResult();
    }
}
