<?php

namespace App\Models;

use CodeIgniter\Model;

class KomisiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_komisi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
    'komisi'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getDefaultKomisiIklanKonten()
    {
        $data = [];
        foreach (['admin', 'marketing', 'penulis'] as $role) {
            $result = $this->select('komisi')
                           ->where('nama', $role)
                           ->orderBy('id', 'ASC')
                           ->limit(1)
                           ->get()
                           ->getRow();
            $data[$role] = $result ? (float)$result->komisi : 0;
        }
        return $data;
    }
}
