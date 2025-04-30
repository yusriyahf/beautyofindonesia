<?php

namespace App\Models;

use CodeIgniter\Model;

class TempatWisataModel extends Model
{
    protected $table = 'tb_tempatwisata';
    protected $primaryKey = 'id_wisata';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_kategori_wisata',
        'nama_wisata_ind',
        'nama_wisata_eng',
        'foto_wisata',
        'deskripsi_wisata_ind',
        'deskripsi_wisata_eng',
        'id_kotakabupaten',
        'wisata_latitude',
        'wisata_longitude',
        'slug_wisata_ind',
        'slug_wisata_eng',
        'id_penulis',
        'nama_penulis',
        'sumber_foto',
        'wisata_latitude',
        'meta_title_id',
        'meta_title_en',
        'meta_deskription_id',
        'meta_description_en',
        'views'
    ];

    public function searchTempatWisata($keyword)
    {
        return $this->table('tb_tempatwisata')
            ->select('tb_tempatwisata.*, tb_kategori_wisata.nama_kategori_wisata, tb_kategori_wisata.nama_kategori_wisata_en, tb_kategori_wisata.slug_kategori_wisata, tb_kategori_wisata.slug_kategori_wisata_en, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng, tb_provinsi.slug_provinsi_ind, tb_provinsi.slug_provinsi_eng')
            ->join('tb_kategori_wisata', 'tb_kategori_wisata.id_kategori_wisata = tb_tempatwisata.id_kategori_wisata')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_tempatwisata.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->groupStart()
            ->like('tb_tempatwisata.nama_wisata_ind', $keyword)
            ->orLike('tb_tempatwisata.nama_wisata_eng', $keyword)
            ->orLike('tb_tempatwisata.deskripsi_wisata_ind', $keyword)
            ->orLike('tb_tempatwisata.deskripsi_wisata_eng', $keyword)
            ->orLike('tb_kategori_wisata.nama_kategori_wisata', $keyword)
            ->orLike('tb_kategori_wisata.nama_kategori_wisata_en', $keyword)
            ->orLike('tb_kotakabupaten.nama_kotakabupaten', $keyword)
            ->orLike('tb_kotakabupaten.nama_kotakabupaten_eng', $keyword)
            ->orLike('tb_provinsi.nama_provinsi', $keyword)
            ->orLike('tb_provinsi.nama_provinsi_eng', $keyword)
            ->groupEnd()
            ->orderBy('tb_tempatwisata.id_wisata', 'DESC') // Order by DESC
            // ->limit(20) // Batasi hasil hanya 50 data
            ->get()
            ->getResultArray();
    }




    public function getWisataByKotakabupaten($id_kotakabupaten)
    {
        return $this->select('tb_tempatwisata.*, tb_kategori_wisata.nama_kategori_wisata,tb_kategori_wisata.nama_kategori_wisata_en, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata', 'left')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten', 'left')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi', 'left')
            ->where('tb_tempatwisata.id_kotakabupaten', $id_kotakabupaten)
            ->findAll();
    }

    public function getWisataByKotakabupatenAndKategori($id_kotakabupaten, $id_kategori_wisata)
    {
        return $this->select('tb_tempatwisata.*, tb_kategori_wisata.nama_kategori_wisata,tb_kategori_wisata.nama_kategori_wisata_en, tb_kotakabupaten.nama_kotakabupaten,tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata', 'left')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten', 'left')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi', 'left')
            ->where('tb_tempatwisata.id_kotakabupaten', $id_kotakabupaten)
            ->where('tb_tempatwisata.id_kategori_wisata', $id_kategori_wisata)
            ->findAll();
    }

    public function getWisataByProvinsi($id_provinsi)
    {
        return $this->select('tb_tempatwisata.*, tb_kategori_wisata.nama_kategori_wisata, tb_kategori_wisata.nama_kategori_wisata_en, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata', 'left')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten', 'left')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi', 'left')
            ->where('tb_provinsi.id_provinsi', $id_provinsi)
            ->paginate(9, 'tempatwisata');
    }

    public function getWisataByProvinsiAndKategori($id_provinsi, $id_kategori_wisata)
    {
        return $this->select('tb_tempatwisata.*, tb_kategori_wisata.nama_kategori_wisata, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata', 'left')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten', 'left')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi', 'left')
            ->where('tb_provinsi.id_provinsi', $id_provinsi)
            ->where('tb_tempatwisata.id_kategori_wisata', $id_kategori_wisata)
            ->paginate(9, 'tempatwisata');
    }

    public function randomWisata($id_kotakabupaten, $limitPerCategory = 5)
    {
        // Ambil ID provinsi dari id_kotakabupaten yang diberikan
        $provinsi = $this->db->table('tb_kotakabupaten')
            ->select('id_provinsi')
            ->where('id_kotakabupaten', $id_kotakabupaten)
            ->get()
            ->getRow();

        if (!$provinsi) {
            return []; // Jika tidak ditemukan, kembalikan array kosong
        }

        $id_provinsi = $provinsi->id_provinsi;

        // Query 5 wisata berdasarkan kota/kabupaten
        $wisataKota = $this->select('
            tb_tempatwisata.*, 
            tb_kategori_wisata.nama_kategori_wisata, 
            tb_kategori_wisata.nama_kategori_wisata_en, 
            tb_kategori_wisata.slug_kategori_wisata, 
            tb_kategori_wisata.slug_kategori_wisata_en, 
            tb_kotakabupaten.nama_kotakabupaten, 
            tb_kotakabupaten.nama_kotakabupaten_eng, 
            tb_provinsi.nama_provinsi, 
            tb_provinsi.nama_provinsi_eng
        ')
            ->join('tb_kategori_wisata', 'tb_kategori_wisata.id_kategori_wisata = tb_tempatwisata.id_kategori_wisata')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_tempatwisata.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->where('tb_tempatwisata.id_kotakabupaten', $id_kotakabupaten)
            ->orderBy('RAND()', false)
            ->limit($limitPerCategory)
            ->find();

        // Query 5 wisata berdasarkan provinsi tetapi beda kota/kabupaten
        $wisataProvinsi = $this->select('
            tb_tempatwisata.*, 
            tb_kategori_wisata.nama_kategori_wisata, 
            tb_kategori_wisata.nama_kategori_wisata_en, 
            tb_kategori_wisata.slug_kategori_wisata, 
            tb_kategori_wisata.slug_kategori_wisata_en, 
            tb_kotakabupaten.nama_kotakabupaten, 
            tb_kotakabupaten.nama_kotakabupaten_eng, 
            tb_provinsi.nama_provinsi, 
            tb_provinsi.nama_provinsi_eng
        ')
            ->join('tb_kategori_wisata', 'tb_kategori_wisata.id_kategori_wisata = tb_tempatwisata.id_kategori_wisata')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_tempatwisata.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->where('tb_provinsi.id_provinsi', $id_provinsi)
            ->where('tb_tempatwisata.id_kotakabupaten !=', $id_kotakabupaten) // Hindari kota yang sama
            ->orderBy('RAND()', false)
            ->limit($limitPerCategory)
            ->find();

        // Gabungkan hasilnya
        return array_merge($wisataKota, $wisataProvinsi);
    }





    public function getAllWisataMaps()
    {
        return $this->select('tb_tempatwisata.*, 
                              tb_kategori_wisata.nama_kategori_wisata, 
                              tb_kategori_wisata.nama_kategori_wisata_en, 
                              tb_kotakabupaten.nama_kotakabupaten, 
                              tb_kotakabupaten.nama_kotakabupaten_eng, 
                              tb_provinsi.nama_provinsi, 
                              tb_provinsi.nama_provinsi_eng, 
                              tb_penulis.nama_penulis')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->join('tb_penulis', 'tb_tempatwisata.id_penulis = tb_penulis.id_penulis', 'left') // Join the penulis table
            ->findAll();
    }

    public function getAllWisata($limit = 9)
    {
        return $this->select('tb_tempatwisata.*, 
                          tb_kategori_wisata.nama_kategori_wisata, 
                          tb_kategori_wisata.nama_kategori_wisata_en, 
                          tb_kotakabupaten.nama_kotakabupaten, 
                          tb_kotakabupaten.nama_kotakabupaten_eng, 
                          tb_provinsi.nama_provinsi, 
                          tb_provinsi.nama_provinsi_eng, 
                          tb_penulis.nama_penulis')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->join('tb_penulis', 'tb_tempatwisata.id_penulis = tb_penulis.id_penulis', 'left')
            ->paginate($limit, 'tempatwisata'); // Pagination dengan alias 'tempatwisata'
    }

    public function getAllWisataByKategori($id_kategori_wisata)
    {
        return $this->select('tb_tempatwisata.*, 
                      tb_kategori_wisata.nama_kategori_wisata, 
                      tb_kategori_wisata.nama_kategori_wisata_en, 
                      tb_kotakabupaten.nama_kotakabupaten, 
                      tb_kotakabupaten.nama_kotakabupaten_eng, 
                      tb_provinsi.nama_provinsi, 
                      tb_provinsi.nama_provinsi_eng, 
                      tb_penulis.nama_penulis')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->join('tb_penulis', 'tb_tempatwisata.id_penulis = tb_penulis.id_penulis', 'left')
            ->where('tb_tempatwisata.id_kategori_wisata', $id_kategori_wisata)
            ->paginate(9, 'tempatwisata'); // Pagination dengan alias 'tempatwisata'
    }

    public function getAllWisataAdmin()
    {
        return $this->select('tb_tempatwisata.*, 
                              tb_kategori_wisata.nama_kategori_wisata, 
                              tb_kategori_wisata.nama_kategori_wisata_en, 
                              tb_kotakabupaten.nama_kotakabupaten, 
                              tb_kotakabupaten.nama_kotakabupaten_eng, 
                              tb_provinsi.nama_provinsi, 
                              tb_provinsi.nama_provinsi_eng, 
                              tb_penulis.nama_penulis')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->join('tb_penulis', 'tb_tempatwisata.id_penulis = tb_penulis.id_penulis', 'left') // Join the penulis table
            ->findAll();
    }


    // public function getWisataDetail($id_wisata)
    // {
    //     return $this->select('tb_tempatwisata.*, tb_kategori_wisata.nama_kategori_wisata, tb_kotakabupaten.nama_kotakabupaten, tb_provinsi.nama_provinsi, tb_penulis.nama_penulis')
    //         ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata', 'left')
    //         ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten', 'left')
    //         ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi', 'left')
    //         ->join('tb_penulis', 'tb_tempatwisata.id_penulis = tb_penulis.id_penulis', 'left') // Join the penulis table
    //         ->where('tb_tempatwisata.id_wisata', $id_wisata)
    //         ->first();
    // }

    public function getWisataDetail($slug_wisata)
    {


        return $this->select('tb_tempatwisata.*, tb_kategori_wisata.nama_kategori_wisata, tb_kategori_wisata.nama_kategori_wisata_en, tb_kategori_wisata.slug_kategori_wisata, tb_kategori_wisata.slug_kategori_wisata_en, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng, tb_penulis.nama_penulis')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata', 'left')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten', 'left')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi', 'left')
            ->join('tb_penulis', 'tb_tempatwisata.id_penulis = tb_penulis.id_penulis', 'left') // Join the penulis table
            ->where('slug_wisata_ind', $slug_wisata)
            ->orWhere('slug_wisata_eng', $slug_wisata)
            ->first();
    }



    public function incrementViews($id_wisata)
    {
        $this->set('views', 'views + 1', false);
        $this->where('id_wisata', $id_wisata);
        $this->update();
    }

    // Fungsi untuk mendapatkan wisata random
    public function getRandomWisata($limit = 9)
    {
        return $this->select('tb_tempatwisata.*, tb_kategori_wisata.nama_kategori_wisata, tb_kategori_wisata.nama_kategori_wisata_en, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng, tb_penulis.nama_penulis, slug_kategori_wisata, slug_kategori_wisata_en')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->join('tb_penulis', 'tb_tempatwisata.id_penulis = tb_penulis.id_penulis', 'left')
            ->orderBy('RAND()')
            ->limit($limit)
            ->findAll();
    }

    public function getWisataByCategory($categoryId)
    {
        return $this->select('tb_tempatwisata.*, tb_kategori_wisata.nama_kategori_wisata, tb_kategori_wisata.nama_kategori_wisata_en, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng, tb_penulis.nama_penulis')
            ->join('tb_kategori_wisata', 'tb_tempatwisata.id_kategori_wisata = tb_kategori_wisata.id_kategori_wisata')
            ->join('tb_kotakabupaten', 'tb_tempatwisata.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->where('tb_tempatwisata.id_kategori_wisata', $categoryId)
            ->findAll();
    }
}
