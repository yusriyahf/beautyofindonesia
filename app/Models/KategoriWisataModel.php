<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriWisataModel extends Model
{
    protected $table = 'tb_kategori_wisata';
    protected $primaryKey = 'id_kategori_wisata';
    protected $returnType = 'object';
    protected $allowedFields = [
        'id_kategori_wisata',
        'nama_kategori_wisata',
        'nama_kategori_wisata_en',
        'id_kotakabupaten',
        'nama_kotakabupaten',
        'slug_kategori_wisata',
        'slug_kategori_wisata_en'
    ];

    public function getKategoriWisata()
    {
        return $this->findAll();
    }


    // Menambahkan metode untuk mengambil data kategori berdasarkan id
    public function getKategoriWisataById($id)
    {
        return $this->where('id_kategori_wisata', $id)->first(); // Mengambil data pertama yang cocok dengan ID
    }

    public function getKategoriDetail($slug)
    {
        return $this->where('slug_kategori_wisata', $slug)
            ->orWhere('slug_kategori_wisata_en', $slug)
            ->first();
    }
}
