<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriOlehOlehModel extends Model
{
    protected $table = 'tb_kategori_oleholeh';
    protected $primaryKey = 'id_kategori_oleholeh';
    protected $returnType = 'object';
    protected $allowedFields = [
        'id_kategori_oleholeh',
        'nama_kategori_oleholeh',
        'nama_kategori_oleholeh_en',
        'slug_kategori_oleholeh',
        'slug_kategori_oleholeh_en'
    ];

    public function getKategoriOlehOleh()
    {
        return $this->findAll();
    }

    // Add a method to get category data by ID
    public function getKategoriOlehOlehById($id)
    {
        return $this->where('id_kategori_oleholeh', $id)->first(); // Get the first matching data by ID
    }
}
