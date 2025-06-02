<?php

namespace App\Models;

use CodeIgniter\Model;

class AccUserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_pengajuan_user';
    protected $primaryKey       = 'id_pengajuan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'photo_user',
        'email',
        'password',
        'full_name',
        'role',
        'kontak',
        'bank_account_number',
        'is_active',
        'contoh_karya_artikel',
        'status',
        'alasan_penolakan',
        'created_at',
        'updated_at'
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
}
