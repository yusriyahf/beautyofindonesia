<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UsersModel;

class Profile extends BaseController
{

    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Dump semua data session login
        // dd(session()->get());

        // Ambil data pengguna dari session atau database
        $userModel = new UserModel();
        $userId = session()->get('user_id'); // Pastikan nama key-nya sesuai
        $user = $userModel->find($userId);
        
        $id_user = session()->get('id_user');
        $usersModel = new UsersModel();
        $userData = $usersModel->getUsernameById($id_user);
        $photo_user = $userData['photo_user'] ?? null;
        $profileImage = $photo_user ? base_url('assets-baru/img/user/' . $photo_user) : base_url('assets-baru/img/user/default_profil.jpg');


        return view('admin/profile/index', [
            'user' => $user,
            'profileImage' => $profileImage
        ]);
    }


    public function edit()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Ambil data user dari session atau database
        $userModel = new UserModel();
        $userId = session()->get('user_id'); // Contoh mengambil user_id dari session
        $user = $userModel->find($userId);
         

        $id_user = session()->get('id_user');
        $usersModel = new UsersModel();
        
        $userData = $usersModel->getUsernameById($id_user);
        $photo_user = $userData['photo_user'] ?? null;
        $profileImage = $photo_user ? base_url('assets-baru/img/user/' . $photo_user) : base_url('assets-baru/img/user/default_profil.jpg');

        // Tampilkan halaman edit profil dengan data user
        return view('admin/profile/edit', ['user' => $user, 'profileImage' => $profileImage]);
    }

    public function update()
    {
        // Pastikan user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('id_user');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $profilePictures = $this->request->getFile('profilePictureInput');
        log_message('debug', 'File anjing: ' . $profilePictures);

        // Validasi form input
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'username' => 'required|min_length[3]|max_length[20]',
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'kontak' => 'required',
            'rekening' => 'required',
            // 'photo_user' => 'uploaded[photo_user]|mime_in[photo_user,image/jpg,image/jpeg,image/png]|max_size[photo_user,2048]',  // Validasi foto jika ada
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Proses upload gambar jika ada
        $profilePicture = $this->request->getFile('photo_user');
        // if (!$profilePicture->isValid()) {
        //     log_message('error', 'File not valid: ' . $profilePicture->getErrorString());
        // } else {
        //     log_message('debug', 'File uploaded successfully: ' . $profilePicture->getName());
        // }
        $currentPhoto = $user['photo_user'] ?? 'assets-baru/img/user/default_profil.jpg';
        $profilePictureName = $currentPhoto;

        if ($profilePicture && $profilePicture->isValid() && !$profilePicture->hasMoved()) {
            log_message('debug', 'Gambar valid: ' . $profilePicture->getName());

            // Hapus gambar lama jika bukan default
            if (!empty($currentPhoto) && $currentPhoto !== 'assets-baru/img/user/default_profil.jpg') {
                $oldImagePath = ROOTPATH . 'public/' . $currentPhoto;
                // Pastikan file benar-benar ada sebelum dihapus
                if (is_file($oldImagePath) && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Generate nama file baru
            $newName = $profilePicture->getRandomName();

            // Pastikan folder tujuan ada
            $destination = ROOTPATH . 'public/assets-baru/img/user/';
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true); // Buat folder jika belum ada
            }

            // Pindahkan file ke folder tujuan
            if ($profilePicture->move($destination, $newName)) {
                $profilePictureName = 'assets-baru/img/user/' . $newName;
                log_message('debug', 'Upload sukses ke: ' . $profilePictureName);
            } else {
                log_message('error', 'Gagal memindahkan file.');
            }
        }

        // Jika tombol hapus foto ditekan
        if ($this->request->getPost('photo_user_removed') == '1') {
            if ($currentPhoto !== 'assets-baru/img/user/default_profil.jpg') {
                $oldImagePath = ROOTPATH . 'public/' . $currentPhoto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $profilePictureName = 'assets-baru/img/user/default_profil.jpg';
        }

        // Ambil data dari form
        $data = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'kontak' => $this->request->getPost('kontak'),
            'bank_account_number' => $this->request->getPost('rekening'),
            'photo_user' => $profilePictureName
        ];

        // Jika password diisi, update
        if (!empty($this->request->getPost('password'))) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Simpan ke database
        if (!$userModel->update($userId, $data)) {
            log_message('error', 'Gagal update profil: ' . print_r($data, true));
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil');
        }

        // Update session
        $updatedUser = $userModel->find($userId);
        session()->set([
            'username' => $updatedUser['username'],
            'email' => $updatedUser['email'],
            'photo_user' => base_url($updatedUser['photo_user'] ?? 'assets-baru/img/user/default_profil.jpg')
        ]);

        return redirect()->to('/admin/profile')->with('success', 'Profil berhasil diperbarui');
    }
    
}
