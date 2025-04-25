<?php

namespace App\Models;

use CodeIgniter\Model;

class KomisiModel extends Model
{
    protected $table = 'tb_komisi';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'nama', 'komisi'];

    // Untuk otomatis isi created_at dan updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
