<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;

class Dashboardctrl extends BaseController
{
    public function index()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); 
            // Ubah 'login' sesuai dengan halaman login Anda
        }
        return view('admin/dashboard/index');
    }
}
