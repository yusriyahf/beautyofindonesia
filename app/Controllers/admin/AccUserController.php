<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AccUserModel;

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
        
        return view('admin/users/index_acc.php', [
            'all_data_users' => $all_data_users,
            'validation' => $validation
        ]);
    }
}
