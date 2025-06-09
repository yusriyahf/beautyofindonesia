<?php

namespace App\Controllers\Admin;

use App\Models\UsersModel;

class Users extends BaseController
{
    private $UsersModel;

    public function __construct()
    {
        $this->UsersModel = new UsersModel();
    }

    public function index()
    {
        $all_data_users = $this->UsersModel->findAll();
        $validation = \Config\Services::validation();
        return view('admin/users/index', [
            'all_data_users' => $all_data_users,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $listUsers = $this->UsersModel->asObject()->findAll();

        $validation = \Config\Services::validation();

        return view('admin/users/tambah', [
            'listUsers' => $listUsers,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $data = [
            'username' => $this->request->getVar("username"),
            'email' => $this->request->getVar("email"),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getVar("full_name"),
            'role' => $this->request->getVar("role"),
            'bank_account_number' => $this->request->getVar("bank_account_number"),
        ];

        $this->UsersModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/users'));
    }


    public function edit($id_user)
    {
        $users = $this->UsersModel->asObject()->find($id_user);

        $validation = \Config\Services::validation();

        return view('admin/users/edit', [
            'users' => $users,
            'validation' => $validation
        ]);
    }

    // Artikel.php (Controller)
    public function proses_edit($id_user = null)
    {
        $popupData = $this->UsersModel->find($id_user);

        if (!$popupData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Simpan data ke database
        $data = [
            'username' => $this->request->getPost("username"),
            'email' => $this->request->getPost("email"),
            'password' => $this->request->getPost("password"),
            'full_name' => $this->request->getPost("full_name"),
            'role' => $this->request->getPost("role"),
            'bank_account_number' => $this->request->getPost("bank_account_number"),
        ];

        $this->UsersModel->update($id_user, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to(base_url('admin/users'));
    }

    public function delete($id = false)
    {
        // Cari data popup berdasarkan ID
        $UsersData = $this->UsersModel->asObject()->find($id);

        if (!$UsersData) {
            session()->setFlashdata('error', 'Data tidak ditemukan');
            return redirect()->to(base_url('admin/users'));
        }

        // Hapus data dari database
        $this->UsersModel->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('admin/users'));
    }
}
