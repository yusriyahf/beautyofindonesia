<?php

namespace App\Controllers;

use App\Models\TentangModel;
use App\Models\UserModel;
use App\Models\UsersModel;

class Login extends BaseController
{
    public function index()
    {
        // Pengecekan jika pengguna sudah login
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('admin/dashboard')); // Ubah 'vw_home' sesuai dengan halaman yang diinginkan setelah login
        }

        // Proses login jika pengguna belum login
        return view('admin/login/index');
    }

    public function process()
    {
        $users = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $dataUser = $users->where('username', $username)->first();

        if ($dataUser) {
            // Jika password belum di-hash
            if ($password === $dataUser['password']) {
                session()->set([
                    'id_user'   => $dataUser['id_user'],
                    'username'  => $dataUser['username'],
                    'nama_user' => $dataUser['nama_user'] ?? 'Tidak Ada Nama',
                    'email'     => $dataUser['email'] ?? '-',
                    'role'      => $dataUser['role'],
                    'logged_in' => TRUE
                ]);
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                session()->setFlashdata('error', 'Username & Password Salah');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Username & Password Salah');
            return redirect()->back();
        }
    }

    function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
