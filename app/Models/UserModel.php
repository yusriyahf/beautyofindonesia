<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tb_users';
    protected $primaryKey = 'id_user';
    protected $allowedFields = [
        'username', 'email', 'password', 'full_name', 
        'role', 'kontak', 'bank_account_number', 
        'is_active', 'created_at','updated_at'
    ];
}
