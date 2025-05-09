<?php

namespace App\Models;

use CodeIgniter\Model;

class TipeIklanKontenModel extends Model
{
    protected $table = 'tb_harga_iklan';
    protected $primaryKey = 'id_harga_iklan';
    protected $returnType = 'array';
    protected $allowedFields = ['nama', 'harga', 'created_at', 'updated_at'];
}
