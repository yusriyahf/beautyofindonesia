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

    public function approve($id_pengajuan)
    {
        // Validasi ID pengajuan
        if (!is_numeric($id_pengajuan)) {
            return redirect()->back()->with('error', 'ID Pengajuan tidak valid');
        }

        // Cari data pengajuan
        $pengajuan = $this->AccUserModel->find($id_pengajuan);

        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan');
        }

        // Update status pengajuan menjadi approved
        $data = [
            'status' => 'approved',
        ];

        if ($this->AccUserModel->update($id_pengajuan, $data)) {
            return redirect()->to('/admin/userRequest')->with('success', 'User berhasil diapprove. Trigger akan membuat user baru.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengapprove user');
        }
    }

    public function reject($id_pengajuan)
    {
        // Validasi ID pengajuan
        if (!is_numeric($id_pengajuan)) {
            return redirect()->back()->with('error', 'ID Pengajuan tidak valid');
        }

        // Cari data pengajuan
        $pengajuan = $this->AccUserModel->find($id_pengajuan);

        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan');
        }

        // Update status menjadi rejected
        $data = [
            'status' => 'rejected',
        ];

        if ($this->AccUserModel->update($id_pengajuan, $data)) {
            return redirect()->to('/admin/userRequest')->with('success', 'User berhasil ditolak');
        } else {
            return redirect()->back()->with('error', 'Gagal menolak user');
        }
    }
}
