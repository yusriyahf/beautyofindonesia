<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AccUserModel;
use App\Models\UsersModel;

class AccUserController extends BaseController
{
    private $AccUserModel;

    public function __construct()
    {
        $this->AccUserModel = new AccUserModel();

    }

    public function index()
    {
        $all_data_users = $this->AccUserModel->findAll();
        $validation = \Config\Services::validation();

        $id_user = session()->get('id_user');
        $usersModel = new UsersModel();
        
        $userData = $usersModel->getUsernameById($id_user);
        $photo_user = $userData['photo_user'] ?? null;
        $profileImage = $photo_user ? base_url('assets-baru/img/user/' . $photo_user) : base_url('assets-baru/img/user/default_profil.jpg');
        
        return view('admin/users/index_acc.php', [
            'all_data_users' => $all_data_users,
            'validation' => $validation,
            'profileImage' => $profileImage
        ]);
    }
}
