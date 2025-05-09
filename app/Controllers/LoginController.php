<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        // Pengecekan jika pengguna sudah login
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('admin/dashboard')); // Halaman setelah login
        }

        // Proses login jika pengguna belum login
        return view('admin/login/index');
    }

    public function process()
{
    $users = new UserModel();
    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');
    
    // Ambil data pengguna berdasarkan username
    $dataUser = $users->where('username', $username)->first(); // Ubah ini jika perlu

    // Pastikan dataUser adalah objek
    if ($dataUser) {
        // Verifikasi password
        if (password_verify($password, $dataUser['password'])) { // Akses sebagai array
            session()->set([
                'username' => $dataUser['username'], // Akses sebagai array
                'full_name' => $dataUser['full_name'], // Akses sebagai array
                'role' => $dataUser['role'], // Akses sebagai array
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

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}