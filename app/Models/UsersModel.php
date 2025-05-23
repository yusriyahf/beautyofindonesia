<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'tb_users';
    protected $primaryKey = 'id_user';
    protected $returnType = 'array';
    protected $allowedFields = ['id_user', 'username','photo_user', 'email', 'password', 'full_name', 'role', 'bank_account_number'];

    public function getUsernameById($id_user)
    {
        return $this->select(['username', 'photo_user'])
                    ->where('id_user', $id_user)
                    ->first();
    }
}
