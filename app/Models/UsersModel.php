<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'tb_users';
    protected $primaryKey = 'id_user';
    protected $returnType = 'array';
    protected $allowedFields = ['id_user', 'username', 'email', 'password', 'full_name', 'role', 'bank_account_number'];
}
