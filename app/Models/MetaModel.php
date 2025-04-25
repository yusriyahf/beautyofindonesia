<?php

namespace App\Models;

use CodeIgniter\Model;

class MetaModel extends Model
{
    protected $table = "tb_meta";
    protected $primaryKey = "id_seo";
    protected $returnType = "object";
    protected $allowedFields = ['nama_halaman', 'meta_title_id', 'meta_description_id', 'meta_title_en', 'meta_description_en'];
}
