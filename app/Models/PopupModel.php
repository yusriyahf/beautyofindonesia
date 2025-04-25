<?php

namespace App\Models;

use CodeIgniter\Model;

class PopupModel extends Model
{
    protected $table = 'tb_popup';
    protected $primaryKey = 'id_popup';
    protected $returnType = 'array';
    protected $allowedFields = ['id_popup', 'nama_popup', 'foto_popup', 'link_popup', 'nama_tombol', 'title_popup'];
}
