<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinsiModel extends Model
{
    protected $table = "tb_provinsi";
    protected $primaryKey = "id_provinsi";
    protected $returnType = "object";
    protected $allowedFields = ['id_provinsi', 'nama_provinsi', 'nama_provinsi_eng', 'slug_provinsi_ind', 'slug_provinsi_eng'];

    public function getAllProvinsi()
    {
        return $this->findAll();
    }

    public function getProvinceIdBySlug($slug)
    {
        return $this->where('slug_provinsi_ind', $slug)
            ->orWhere('slug_provinsi_eng', $slug)
            ->select('id_provinsi')
            ->first();
    }


    public function getProvinsi($lang = 'id')
    {
        $nama_provinsi_field = ($lang === 'en') ? 'nama_provinsi_eng' : 'nama_provinsi';

        return $this->db->table($this->table)
            ->select("id_provinsi, $nama_provinsi_field AS nama_provinsi")
            ->get()
            ->getResult();
    }



    public function getProvinsiSlug($lang = 'id')
    {
        $nama_provinsi_field = ($lang === 'en') ? 'nama_provinsi_eng' : 'nama_provinsi';
        $slug_field = ($lang === 'en') ? 'slug_provinsi_eng' : 'slug_provinsi_ind';

        return $this->db->table($this->table)
            ->select("$slug_field AS slug_provinsi, $nama_provinsi_field AS nama_provinsi")
            ->get()
            ->getResult();
    }
}
