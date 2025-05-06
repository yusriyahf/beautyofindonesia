<?php

namespace App\Models;

use CodeIgniter\Model;

class PenulisModel extends Model
{
    protected $table = "tb_penulis";
    protected $primaryKey = "id_penulis";
    protected $returnType = "object";
    protected $allowedFields = ['id_penulis', 'nama_penulis', 'foto_penulis', 'deskripsi_penulis'];


    public function getPenulis()
    {
         return $this->db->table('tb_penulis');  
    }
    
    public function getRandomPenulis()
    {
        return $this->db->table('tb_penulis')
                        ->orderBy('RAND()')
                        ->limit(5)
                        ->get()->getResultArray();
    }

    public function getPenulisLainnya($id_penulis, $limit = 4)
    {
        return $this->where('id_penulis !=', $id_penulis)
            ->orderBy('RAND()')
            ->limit($limit)
            ->get()->getResultArray();
    }

    public function getNamaPenulisByUserId($user_id)
    {
        return $this->select('nama_penulis')
                    ->where('id_penulis', $user_id)
                    ->first();
    }

}
