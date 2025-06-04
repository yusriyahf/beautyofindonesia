<?php

namespace App\Controllers;

use App\Models\AccUserModel;
use App\Models\PengajuanModel;

class RegistrasiController extends BaseController
{
    public function index()
    {
        return view('admin/registrasi/index');
    }

    public function process()
    {
        $model = new AccUserModel();

        // Ambil data dari form
        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $fullName = $this->request->getVar('full_name');
        $role = $this->request->getVar('role');
        $kontak = $this->request->getVar('kontak');
        $bankAccountNumber = $this->request->getVar('bank_account_number');
        $artikel = $this->request->getVar('artikel');

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username, email, atau kontak sudah ada
        if (
            $model->where('username', $username)->first() ||
            $model->where('email', $email)->first() ||
            $model->where('kontak', $kontak)->first()
        ) {
            session()->setFlashdata('error', 'Username, email, atau kontak sudah terdaftar.');
            return redirect()->back()->withInput();
        }

        // Set artikel to null if role is marketing or admin
        if ($role === 'marketing' || $role === 'admin') {
            $artikel = null;
        }

        

        // Data untuk disimpan
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash,
            'full_name' => $fullName,
            'role' => $role,
            'kontak' => $kontak,
            'bank_account_number' => $bankAccountNumber,
            'artikel' => $artikel,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Simpan data
        if ($model->save($data)) {
            session()->setFlashdata('success', true);
            return view('admin/registrasi/index'); // atau view yang sesuai
        
        } else {
            // Jika gagal simpan, tampilkan error
            $errors = $model->errors();
            session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data.');
            return redirect()->back()->withInput();
        }
    }
}
