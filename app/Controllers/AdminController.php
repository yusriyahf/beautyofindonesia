<?php

namespace App\Controllers;

use App\Models\PengajuanModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    public function accPengajuan($id)
    {
        $pengajuanModel = new PengajuanModel();
        $userModel = new UserModel();

        // Cari data pengajuan berdasarkan ID
        $pengajuan = $pengajuanModel->find($id);

        if (!$pengajuan) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data pengajuan tidak ditemukan.'
            ]);
        }

        // Cek apakah username/email/kontak sudah terdaftar di tb_users
        $existingUser = $userModel
            ->where('username', $pengajuan['username'])
            ->orWhere('email', $pengajuan['email'])
            ->orWhere('kontak', $pengajuan['kontak'])
            ->first();

        if ($existingUser) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Username, email, atau kontak sudah terdaftar di user aktif.'
            ]);
        }

        // Simpan ke tb_users
        $dataUser = [
            'username' => $pengajuan['username'],
            'email' => $pengajuan['email'],
            'password' => $pengajuan['password'], // Sudah ter-hash
            'full_name' => $pengajuan['full_name'],
            'role' => $pengajuan['role'],
            'kontak' => $pengajuan['kontak'],
            'bank_account_number' => $pengajuan['bank_account_number'],
            'artikel' => $pengajuan['artikel'],
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $userModel->insert($dataUser);

        // Update status pengajuan menjadi 'approved'
        $pengajuanModel->update($id, ['status' => 'approved']);


        // Hapus dari tb_pengajuan
        // $pengajuanModel->delete($id);

        // return $this->response->setJSON([
        //     'status' => 'success',
        //     'message' => 'Pengajuan telah disetujui dan dipindahkan ke tb_users.'
        // ]);
    }

    public function tolakPengajuan($id)
    {
        $pengajuanModel = new PengajuanModel();

        // Cek apakah data pengajuan ada
        $pengajuan = $pengajuanModel->find($id);

        if (!$pengajuan) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data pengajuan tidak ditemukan.'
            ]);
        }

        // Update status jadi 'rejected'
        $pengajuanModel->update($id, ['status' => 'rejected']);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Pengajuan telah ditolak.'
        ]);
    }

}