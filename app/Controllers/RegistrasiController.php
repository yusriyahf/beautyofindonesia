<?php

namespace App\Controllers;

use App\Models\AccUserModel;
use App\Models\PengajuanModel;
use App\Models\UsersModel;

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
            $errorMsg = 'Username, email, atau kontak sudah terdaftar.';
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $errorMsg,
                ]);
            }

            session()->setFlashdata('error', $errorMsg);
            return redirect()->back()->withInput();
        }

        // Set artikel ke null jika bukan penulis
        if ($role !== 'penulis') {
            $artikel = null;
        }

        // Siapkan data
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash,
            'full_name' => $fullName,
            'role' => $role,
            'kontak' => $kontak,
            'bank_account_number' => $bankAccountNumber,
            'contoh_karya_artikel' => $artikel,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Simpan data
        if ($model->save($data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true]);
            } else {
                session()->setFlashdata('success', true);
                return redirect()->to('/registrasi');
            }
        } else {
            $errors = $model->errors();
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data.',
                    'errors' => $errors,
                ]);
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data.');
                return redirect()->back()->withInput();
            }
        }
    }
}
