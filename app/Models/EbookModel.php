<?php

namespace App\Models;

use CodeIgniter\Model;

class EbookModel extends Model
{
    protected $table = "tb_ebook";
    protected $primaryKey = "id_ebook";
    protected $returnType = "object";
    protected $allowedFields = ['id_ebook', 'nama_ebook', 'foto_ebook', 'sinopsis', 'nama_penulis', 'file_ebook'];


    public function getEbook()
    {
         return $this->db->table('tb_ebook');  
    }
    
    // public function getRandomPenulis()
    // {
    //     return $this->db->table('tb_penulis')
    //                     ->orderBy('RAND()')
    //                     ->limit(5)
    //                     ->get()->getResultArray();
    // }

    public function getEbookLainnya($id_ebook, $limit)
    {
        return $this->where('id_ebook !=', $id_ebook)
            ->orderBy('RAND()')
            ->limit($limit)
            ->get()->getResultArray();
    }
}
