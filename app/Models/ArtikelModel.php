<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
     protected $table = "tb_artikel";
     protected $primaryKey = "id_artikel";
     protected $returnType = "object";
     protected $allowedFields = [
          'judul_artikel',
          'judul_artikel_en',
          'id_kategori',
          'id_penulis',
          'deskripsi_artikel',
          'deskripsi_artikel_en',
          'tags',
          'tags_en',
          'sumber_foto',
          'meta_title_id',
          'meta_title_en',
          'meta_deskription_id',
          'meta_description_en',
          'tgl_publish',
          'foto_artikel',
          'slug',
          'slug_en'
     ];


     public function getArtikel()
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori=tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis=tb_artikel.id_penulis')
               ->get()->getResultArray();
     }

     public function getAllArtikelWithKategori($limit = 10, $offset = 0)
     {
          return $this->select('tb_artikel.*, 
                          tb_kategori.nama_kategori, 
                          tb_kategori.slug_kategori, 
                          tb_kategori.slug_kategori_en')
               ->join('tb_kategori', 'tb_kategori.id_kategori = tb_artikel.id_kategori') // Join berdasarkan id_kategori
               ->where('tb_artikel.tgl_publish <=', date('Y-m-d')) // Filter artikel dengan tgl_publish <= hari ini
               ->orderBy('tb_artikel.tgl_publish', 'DESC') // Urutkan berdasarkan tgl_publish terbaru
               ->paginate($limit, 'artikel'); // Pagination dengan alias 'artikel'
     }




     public function getAllArtikelWithKategori2($slug)
     {
          return $this->db->table('tb_artikel')
               ->select('tb_artikel.*, tb_kategori.nama_kategori, tb_kategori.slug_kategori, tb_kategori.slug_kategori_en')
               ->join('tb_kategori', 'tb_kategori.id_kategori = tb_artikel.id_kategori')
               ->where('tb_artikel.tgl_publish <=', date('Y-m-d')) // Filter artikel dengan tgl_publish <= hari ini
               ->groupStart() // Mulai grup untuk kondisi OR
               ->where('tb_artikel.slug', $slug) // Filter berdasarkan slug artikel
               ->orWhere('tb_artikel.slug_en', $slug) // Filter berdasarkan slug_en jika bahasa Inggris
               ->groupEnd() // Akhiri grup OR
               ->get()
               ->getRow(); // Ambil satu baris data (jika hasilnya hanya satu)
     }



     public function getArtikelRandom()
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori=tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis=tb_artikel.id_penulis')
                ->orderBy('RAND()')
               ->limit(3)
               ->get()->getResultArray();
     }

     public function getKategoriArtikel($id_kategori)
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori = tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis = tb_artikel.id_penulis')
               ->where('tb_artikel.id_kategori', $id_kategori)
               ->where('tb_artikel.tgl_publish <=', date('Y-m-d'))
               ->get()->getResultArray();
     }


     public function getDetailArtikel($id_artikel, $slug)
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori=tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis=tb_artikel.id_penulis')
               ->where('tb_artikel.id_artikel', $id_artikel)
               ->where('tb_artikel.slug', $slug)
               ->orWhere('tb_artikel.slug_en', $slug)
               ->get()
               ->getRowArray();
     }
     public function getDetailArtikelBySlug($slug)
     {
          return $this->select('tb_artikel.*, tb_kategori.nama_kategori, tb_kategori.nama_kategori_en, tb_kategori.slug_kategori, tb_kategori.slug_kategori_en')
               ->join('tb_kategori', 'tb_artikel.id_kategori = tb_kategori.id_kategori')
               ->join('tb_penulis', ' tb_artikel.id_penulis = tb_penulis.id_penulis')
               ->where('slug', $slug)
               ->orWhere('slug_en', $slug)
               ->get()
               ->getRowArray();
     }


     public function getArtikelLainnya($id_artikel, $limit = 4)
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori = tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis = tb_artikel.id_penulis')
               ->where('id_artikel !=', $id_artikel)
               ->where('tgl_publish <=', date('Y-m-d')) // Filter by tgl_publish to only show articles published today or earlier
               ->orderBy('id_artikel', 'ASC')
               ->limit($limit)
               ->get()->getResultArray();
     }


     public function getArtikelPenulis($id_penulis, $limit = 5)
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori=tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis=tb_artikel.id_penulis')
               ->where('tb_artikel.id_penulis', $id_penulis)
               ->limit($limit)
               ->get()->getResultArray();
     }

     public function getSemuaArtikelPenulis($id_penulis)
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori=tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis=tb_artikel.id_penulis')
               ->where('tb_artikel.id_penulis', $id_penulis)
               ->get()->getResultArray();
     }

     public function getArtikelTerbaru()
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori = tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis = tb_artikel.id_penulis')
               ->where('tgl_publish <=', date('Y-m-d')) // Add filter to ensure only articles with tgl_publish <= today are shown
               ->orderBy('tb_artikel.tgl_publish', 'DESC') // Urutkan berdasarkan tgl_publish terbaru
               ->limit(3) // Limit the number of articles to 6
               ->get()->getResultArray();
     }



     public function getPopularArtikel()
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori=tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis=tb_artikel.id_penulis')
               ->orderBy('views', 'desc')
               ->limit(4)
               ->get()->getResultArray();
     }

     public function getTerpopularArtikel()
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori=tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis=tb_artikel.id_penulis')
               ->orderBy('views', 'desc')
               ->limit(1)
               ->get()->getResultArray();
     }

     public function searchArtikel($keyword)
     {
          return $this->table('tb_artikel')
               ->select('tb_artikel.*, tb_kategori.nama_kategori, tb_kategori.nama_kategori_en, tb_kategori.slug_kategori, tb_kategori.slug_kategori_en, tb_penulis.nama_penulis')
               ->join('tb_kategori', 'tb_kategori.id_kategori = tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis = tb_artikel.id_penulis')
               ->where('tb_artikel.tgl_publish <=', date('Y-m-d')) // Filter articles with tgl_publish <= today
               ->groupStart() // Start of OR conditions for keyword search
               ->like('tb_artikel.tags', $keyword)
               ->orLike('tb_artikel.tags_en', $keyword)
               ->orLike('tb_kategori.nama_kategori', $keyword)
               ->orLike('tb_kategori.nama_kategori_en', $keyword)
               ->orLike('tb_kategori.slug_kategori', $keyword)
               ->orLike('tb_kategori.slug_kategori_en', $keyword)
               ->orLike('tb_penulis.nama_penulis', $keyword)
               ->orLike('tb_artikel.judul_artikel', $keyword) // Searching by article title
               ->orLike('tb_artikel.deskripsi_artikel', $keyword) // Searching by article description
               ->groupEnd() // End of OR conditions
               ->get()
               ->getResultArray();
     }


     public function incrementViews($id_artikel)
     {
          $this->db->table('tb_artikel')
               ->where('id_artikel', $id_artikel)
               ->set('views', 'views+1', FALSE)
               ->update();
     }

     public function incrementViewsBySlug($slug)
     {
          // Increment the 'views' field for the article with the given slug
          return $this->db->table('tb_artikel')
               ->where('slug', $slug)
               ->set('views', 'views + 1', false) // Use SQL expression to increment views
               ->update();
     }

     public function getArtikelLainnyaBySlug($slug, $limit = 4)
     {
          // Fetch related articles from the same category, excluding the current one by slug
          return $this->db->table('tb_artikel')
               ->select('tb_artikel.*, tb_kategori.nama_kategori, tb_kategori.nama_kategori_en, tb_kategori.slug_kategori, tb_kategori.slug_kategori_en') // Ensure slug_kategori is selected
               ->join('tb_kategori', 'tb_kategori.id_kategori = tb_artikel.id_kategori')
               ->where('tb_artikel.slug !=', $slug) // Exclude the current article
               ->where('tb_artikel.tgl_publish <=', date('Y-m-d')) // Only include articles with tgl_publish <= today
               ->orderBy('RAND()') // Fetch random articles
               ->limit($limit) // Limit the number of related articles
               ->get()
               ->getResultArray(); // Return as an array of results
     }


     public function getArtikelByTag($tag)
     {
          return $this->db->table('tb_artikel')
               ->join('tb_kategori', 'tb_kategori.id_kategori = tb_artikel.id_kategori')
               ->join('tb_penulis', 'tb_penulis.id_penulis = tb_artikel.id_penulis')
               ->like('tb_artikel.tags', $tag) // Filter by tag
               ->where('tb_artikel.tgl_publish <=', date('Y-m-d')) // Only include articles with tgl_publish <= today
               ->get()
               ->getResultArray(); // Return as an array of results
     }


     public function getAllTags()
     {
          // Assuming your tags are stored in a table related to articles (e.g., tb_artikel)
          $builder = $this->db->table('tags');

          return $builder
               ->join('tb_artikel', 'tb_artikel.id_artikel = tags.id_artikel') // Join the tags table with the articles table
               ->where('tb_artikel.tgl_publish <=', date('Y-m-d')) // Only include articles with tgl_publish <= today
               ->select('tags.name') // Replace 'name' with the actual tag column name
               ->distinct() // Ensure only distinct tags are returned
               ->get()
               ->getResultArray(); // Return as an array of results
     }
}
//doneeeeeee