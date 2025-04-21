<?php

namespace App\Models;

use CodeIgniter\Model;

class IklanModel extends Model
{
    protected $table = 'tb_harga_iklan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id_popup', 'nama', 'harga'];
}
