<?php

namespace App\Models;

use CodeIgniter\Model;

class OlehOlehModel extends Model
{
    protected $table = 'tb_oleholeh';
    protected $primaryKey = 'id_oleholeh';
    protected $allowedFields = [
        'id_kategori_oleholeh',
        'nama_oleholeh',
        'nama_oleholeh_eng',
        'foto_oleholeh',
        'sumber_foto',
        'deskripsi_oleholeh',
        'deskripsi_oleholeh_eng',
        'id_kotakabupaten',
        'views',
        'slug_oleholeh',
        'slug_en',
        'nomor_tlp',
        'link_website',
        'oleholeh_latitude',
        'oleholeh_longitude',
        'id_penulis',
        'meta_title_id',
        'meta_title_en',
        'meta_description_id',
        'meta_description_en'
    ];

    public function searchOlehOleh($keyword)
    {
        return $this->table('tb_oleholeh')
            ->select('tb_oleholeh.*, tb_kategori_oleholeh.nama_kategori_oleholeh, tb_kategori_oleholeh.nama_kategori_oleholeh_en, tb_kategori_oleholeh.slug_kategori_oleholeh, tb_kategori_oleholeh.slug_kategori_oleholeh_en, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng')
            ->join('tb_kategori_oleholeh', 'tb_kategori_oleholeh.id_kategori_oleholeh = tb_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_oleholeh.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->groupStart()
            ->like('tb_oleholeh.nama_oleholeh', $keyword)
            ->orLike('tb_oleholeh.nama_oleholeh_eng', $keyword)
            ->orLike('tb_oleholeh.deskripsi_oleholeh', $keyword)
            ->orLike('tb_oleholeh.deskripsi_oleholeh_eng', $keyword)
            ->orLike('tb_kategori_oleholeh.nama_kategori_oleholeh', $keyword)
            ->orLike('tb_kategori_oleholeh.nama_kategori_oleholeh_en', $keyword)
            ->orLike('tb_kotakabupaten.nama_kotakabupaten', $keyword)
            ->orLike('tb_kotakabupaten.nama_kotakabupaten_eng', $keyword)
            ->orLike('tb_provinsi.nama_provinsi', $keyword)
            ->orLike('tb_provinsi.nama_provinsi_eng', $keyword)
            ->groupEnd()
            ->get()
            ->getResultArray();
    }


    public function getOlehOlehByKabupaten($id_kotakabupaten)
    {
        return $this->select('tb_oleholeh.*, tb_kategori_oleholeh.nama_kategori_oleholeh,tb_kategori_oleholeh.nama_kategori_oleholeh_en, tb_kategori_oleholeh.slug_kategori_oleholeh, tb_kategori_oleholeh.slug_kategori_oleholeh_en, 
        tb_kotakabupaten.nama_kotakabupaten, tb_provinsi.nama_provinsi')
            ->join('tb_kategori_oleholeh', 'tb_kategori_oleholeh.id_kategori_oleholeh = tb_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_oleholeh.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->where('tb_oleholeh.id_kotakabupaten', $id_kotakabupaten)
            ->paginate(9, 'oleholeh');
    }

    public function getOlehOlehByProvinsi($id_provinsi)
    {
        return $this->select('tb_oleholeh.*, tb_kategori_oleholeh.nama_kategori_oleholeh, tb_kategori_oleholeh.nama_kategori_oleholeh_en, tb_kategori_oleholeh.slug_kategori_oleholeh,tb_kategori_oleholeh.slug_kategori_oleholeh_en, tb_kotakabupaten.nama_kotakabupaten, tb_provinsi.nama_provinsi')
            ->join('tb_kategori_oleholeh', 'tb_kategori_oleholeh.id_kategori_oleholeh = tb_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_oleholeh.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->where('tb_provinsi.id_provinsi', $id_provinsi)
            ->paginate(9, 'oleholeh');
    }

    public function getOlehOlehByKabupatenAndKategori($id_kotakabupaten, $id_kategori_oleholeh)
    {
        return $this->select('tb_oleholeh.*, tb_kategori_oleholeh.nama_kategori_oleholeh, tb_kategori_oleholeh.nama_kategori_oleholeh_en, tb_kategori_oleholeh.slug_kategori_oleholeh, tb_kategori_oleholeh.slug_kategori_oleholeh_en, tb_kotakabupaten.nama_kotakabupaten, tb_provinsi.nama_provinsi')
            ->join('tb_kategori_oleholeh', 'tb_kategori_oleholeh.id_kategori_oleholeh = tb_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_oleholeh.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->where('tb_oleholeh.id_kotakabupaten', $id_kotakabupaten)
            ->where('tb_oleholeh.id_kategori_oleholeh', $id_kategori_oleholeh)
            ->paginate(9, 'oleholeh');
    }

    public function getOlehOlehByProvinsiAndKategori($id_provinsi, $id_kategori_oleholeh)
    {
        return $this->select('tb_oleholeh.*, tb_kategori_oleholeh.nama_kategori_oleholeh, tb_kategori_oleholeh.nama_kategori_oleholeh_en, tb_kategori_oleholeh.slug_kategori_oleholeh, tb_kategori_oleholeh.slug_kategori_oleholeh_en, tb_kotakabupaten.nama_kotakabupaten, tb_provinsi.nama_provinsi')
            ->join('tb_kategori_oleholeh', 'tb_kategori_oleholeh.id_kategori_oleholeh = tb_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_oleholeh.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->where('tb_provinsi.id_provinsi', $id_provinsi)
            ->where('tb_oleholeh.id_kategori_oleholeh', $id_kategori_oleholeh)
            ->paginate(9, 'oleholeh');
    }


    public function randomOlehOleh($id_kotakabupaten, $limit_per_section = 5)
    {
        // Ambil ID Provinsi berdasarkan id_kotakabupaten
        $kotakabupaten = $this->db->table('tb_kotakabupaten')
            ->select('id_provinsi')
            ->where('id_kotakabupaten', $id_kotakabupaten)
            ->get()
            ->getRow();

        if (!$kotakabupaten) {
            return []; // Jika tidak ditemukan, return array kosong
        }

        $id_provinsi = $kotakabupaten->id_provinsi;

        // Query 1: Ambil 5 oleh-oleh berdasarkan id_kotakabupaten
        $olehOlehKota = $this->select('
                tb_oleholeh.*, 
                tb_kategori_oleholeh.nama_kategori_oleholeh, 
                tb_kategori_oleholeh.nama_kategori_oleholeh_en, 
                tb_kategori_oleholeh.slug_kategori_oleholeh, 
                tb_kategori_oleholeh.slug_kategori_oleholeh_en, 
                tb_kotakabupaten.nama_kotakabupaten, 
                tb_kotakabupaten.nama_kotakabupaten_eng, 
                tb_provinsi.nama_provinsi, 
                tb_provinsi.nama_provinsi_eng
            ')
            ->join('tb_kategori_oleholeh', 'tb_kategori_oleholeh.id_kategori_oleholeh = tb_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_oleholeh.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->where('tb_oleholeh.id_kotakabupaten', $id_kotakabupaten)
            ->orderBy('RAND()', false)
            ->limit($limit_per_section)
            ->find();

        $olehOlehProvinsi = $this->select('
                tb_oleholeh.*, 
                tb_kategori_oleholeh.nama_kategori_oleholeh, 
                tb_kategori_oleholeh.nama_kategori_oleholeh_en, 
                tb_kategori_oleholeh.slug_kategori_oleholeh, 
                tb_kategori_oleholeh.slug_kategori_oleholeh_en, 
                tb_kotakabupaten.nama_kotakabupaten, 
                tb_kotakabupaten.nama_kotakabupaten_eng, 
                tb_provinsi.nama_provinsi, 
                tb_provinsi.nama_provinsi_eng
            ')
            ->join('tb_kategori_oleholeh', 'tb_kategori_oleholeh.id_kategori_oleholeh = tb_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_kotakabupaten.id_kotakabupaten = tb_oleholeh.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi = tb_kotakabupaten.id_provinsi')
            ->where('tb_kotakabupaten.id_provinsi', $id_provinsi)
            ->where('tb_oleholeh.id_kotakabupaten !=', $id_kotakabupaten) // Hindari duplikasi dari yang pertama
            ->orderBy('RAND()', false)
            ->limit($limit_per_section)
            ->find();

        // Gabungkan hasil query pertama dan kedua
        return array_merge($olehOlehKota, $olehOlehProvinsi);
    }



    public function increaseViews($id)
    {
        $this->set('views', 'views + 1', false)
            ->where('id_oleholeh', $id)
            ->update();
    }

    public function getTopOlehOleh($limit = 3, $offset = 0)
    {
        return $this->select('tb_oleholeh.*, 
                      tb_kategori_oleholeh.nama_kategori_oleholeh, 
                      tb_kategori_oleholeh.nama_kategori_oleholeh_en, 
                      tb_kotakabupaten.nama_kotakabupaten, 
                      tb_kotakabupaten.nama_kotakabupaten_eng, 
                      tb_provinsi.nama_provinsi, 
                      tb_provinsi.nama_provinsi_eng, 
                      tb_penulis.nama_penulis, 
                      slug_kategori_oleholeh, 
                      slug_kategori_oleholeh_en')
            ->join('tb_kategori_oleholeh', 'tb_oleholeh.id_kategori_oleholeh = tb_kategori_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_oleholeh.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->join('tb_penulis', 'tb_oleholeh.id_penulis = tb_penulis.id_penulis', 'left')
            ->orderBy('tb_oleholeh.views', 'DESC') // Urut berdasarkan views terbanyak
            ->limit($limit) // Ambil hanya 3 data teratas
            ->findAll(); // Gunakan findAll() untuk menghindari paginasi
    }

    public function getAllOlehOleh($limit = 9, $offset = 0)
    {
        return $this->select('tb_oleholeh.*, 
                          tb_kategori_oleholeh.nama_kategori_oleholeh, 
                          tb_kategori_oleholeh.nama_kategori_oleholeh_en, 
                          tb_kotakabupaten.nama_kotakabupaten, 
                          tb_kotakabupaten.nama_kotakabupaten_eng, 
                          tb_provinsi.nama_provinsi, 
                          tb_provinsi.nama_provinsi_eng, 
                          tb_penulis.nama_penulis, 
                          slug_kategori_oleholeh, 
                          slug_kategori_oleholeh_en')
            ->join('tb_kategori_oleholeh', 'tb_oleholeh.id_kategori_oleholeh = tb_kategori_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_oleholeh.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->join('tb_penulis', 'tb_oleholeh.id_penulis = tb_penulis.id_penulis', 'left')
            ->orderBy('tb_oleholeh.views', 'DESC') // Urutkan berdasarkan views terbanyak
            ->paginate($limit, 'oleholeh'); // Pagination dengan alias 'oleholeh'
    }

    public function getOlehOlehByCategory($id_kategori_oleholeh, $limit = 9, $offset = 0)
    {
        return $this->select('tb_oleholeh.*, 
                          tb_kategori_oleholeh.nama_kategori_oleholeh, 
                          tb_kategori_oleholeh.nama_kategori_oleholeh_en, 
                          tb_kotakabupaten.nama_kotakabupaten, 
                          tb_kotakabupaten.nama_kotakabupaten_eng, 
                          tb_provinsi.nama_provinsi, 
                          tb_provinsi.nama_provinsi_eng, 
                          tb_penulis.nama_penulis, 
                          slug_kategori_oleholeh, 
                          slug_kategori_oleholeh_en')
            ->join('tb_kategori_oleholeh', 'tb_oleholeh.id_kategori_oleholeh = tb_kategori_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_oleholeh.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->join('tb_penulis', 'tb_oleholeh.id_penulis = tb_penulis.id_penulis', 'left')
            ->where('tb_oleholeh.id_kategori_oleholeh', $id_kategori_oleholeh)
            ->orderBy('tb_oleholeh.views', 'DESC') // Urutkan berdasarkan views terbanyak
            ->paginate($limit, 'oleholeh'); // Pagination dengan alias 'oleholeh'
    }

    public function getOlehOlehDetailBySlug($slug)

    {
        return $this->select('tb_oleholeh.*, tb_kategori_oleholeh.nama_kategori_oleholeh, tb_kategori_oleholeh.nama_kategori_oleholeh_en, tb_kategori_oleholeh.slug_kategori_oleholeh, tb_kategori_oleholeh.slug_kategori_oleholeh_en, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng, tb_penulis.nama_penulis')
            ->join('tb_kategori_oleholeh', 'tb_oleholeh.id_kategori_oleholeh = tb_kategori_oleholeh.id_kategori_oleholeh')
            ->join('tb_kotakabupaten', 'tb_oleholeh.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi')
            ->join('tb_penulis', 'tb_oleholeh.id_penulis = tb_penulis.id_penulis') // Join with penulis table
            ->where('slug_oleholeh', $slug)
            ->orWhere('slug_en', $slug) // Assuming your slug field is named 'slug'
            ->first();
    }
    public function getRandomOlehOlehByKategori($id_kategori)
    {
        return $this->select('tb_oleholeh.*, tb_kategori_oleholeh.nama_kategori_oleholeh, tb_kategori_oleholeh.nama_kategori_oleholeh_en, tb_kotakabupaten.nama_kotakabupaten, tb_provinsi.nama_provinsi')
            ->join('tb_kategori_oleholeh', 'tb_oleholeh.id_kategori_oleholeh = tb_kategori_oleholeh.id_kategori_oleholeh', 'left')
            ->join('tb_kotakabupaten', 'tb_oleholeh.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten', 'left') // Assuming there's a relation here
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi', 'left')
            ->where('tb_kategori_oleholeh.id_kategori_oleholeh', $id_kategori)
            ->orderBy('RAND()')
            ->limit(4)
            ->findAll();
    }
    public function getRandomOlehOleh()
    {
        return $this->select('tb_oleholeh.*, tb_kategori_oleholeh.nama_kategori_oleholeh, tb_kategori_oleholeh.nama_kategori_oleholeh_en, tb_kotakabupaten.nama_kotakabupaten, tb_kotakabupaten.nama_kotakabupaten_eng, tb_provinsi.nama_provinsi, tb_provinsi.nama_provinsi_eng, slug_kategori_oleholeh, slug_kategori_oleholeh_en')
            ->join('tb_kategori_oleholeh', 'tb_oleholeh.id_kategori_oleholeh = tb_kategori_oleholeh.id_kategori_oleholeh', 'left')
            ->join('tb_kotakabupaten', 'tb_oleholeh.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten', 'left')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi', 'left')
            ->orderBy('RAND()') // Mengambil secara acak
            ->limit(3) // Batasi hanya 3 item
            ->findAll();
    }
    public function getRandomOlehOlehByKabupaten($kabupatenId)
    {
        return $this->select('tb_oleholeh.*, tb_kategori_oleholeh.nama_kategori_oleholeh, tb_kategori_oleholeh.nama_kategori_oleholeh_en, tb_kotakabupaten.nama_kotakabupaten, tb_provinsi.nama_provinsi')
            ->join('tb_kategori_oleholeh', 'tb_oleholeh.id_kategori_oleholeh = tb_kategori_oleholeh.id_kategori_oleholeh', 'left')
            ->join('tb_kotakabupaten', 'tb_oleholeh.id_kotakabupaten = tb_kotakabupaten.id_kotakabupaten', 'left')
            ->join('tb_provinsi', 'tb_kotakabupaten.id_provinsi = tb_provinsi.id_provinsi', 'left')
            ->where('tb_kotakabupaten.id_kotakabupaten', $kabupatenId) // Filter by kabupaten
            ->orderBy('RAND()') // Randomly select
            ->limit(4) // Limit to 4 items
            ->findAll();
    }
}
