<?php

namespace App\Controllers\admin; // Sesuaikan dengan namespace yang sesuai di aplikasi Anda
use App\Controllers\BaseController;
use App\Models\TentangModel;

class Tentang extends BaseController
{
    public function edit()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
            // Ubah 'login' sesuai dengan halaman login Anda
        }

        $model = new TentangModel();

        // Jika ada data yang dikirim dari formulir pengubahan profil
        if ($this->request->getMethod() === 'post') {
            try {
                $data = [
                    'nama_tentang' => $this->request->getPost('nama_tentang'),
                    'deskripsi_tentang' => $this->request->getPost('deskripsi_tentang'),
                    'deskripsi_tentang_en' => $this->request->getPost('deskripsi_tentang_en'),
                    'alamat' => $this->request->getPost('alamat'),
                    'no_telp' => $this->request->getPost('no_telp'),
                    'email' => $this->request->getPost('email'),
                    'instagram' => $this->request->getPost('instagram'),
                    'tiktok' => $this->request->getPost('tiktok'),
                    'youtube' => $this->request->getPost('youtube'),
                    'footer' => $this->request->getPost('footer'),
                    'username' => $this->request->getPost('username'),
                    'password' => $this->request->getPost('password'),
                    'slogan' => $this->request->getPost('slogan'), // Added 'slogan'
                ];
                

                $oldFotoTentang = $this->request->getPost('old_foto_tentang');

                // Check if a new 'foto_tentang' file is uploaded
                $newFotoTentang = $this->request->getFile('foto_tentang');
                if ($newFotoTentang->isValid()) {
                    // Get the old foto_tentang filename from the database
                    $oldFoto = $oldFotoTentang;

                    // Delete the old 'foto_tentang' file if it exists
                    if ($oldFoto && file_exists(FCPATH . 'assets-baru/img/' . $oldFoto)) {
                        unlink(FCPATH . 'assets-baru/img/' . $oldFoto);
                    }

                    // Generate a new unique filename for the 'foto_tentang' file
                    $fotoName = $newFotoTentang->getName();

                    // Move the uploaded file to the 'assets-baru/img/' directory
                    $newFotoTentang->move(FCPATH . 'assets-baru/img/', $fotoName);

                    // Update the 'foto_tentang' field in the database with the new filename
                    $data['foto_tentang'] = $fotoName;
                } else {
                    // If no new 'foto_tentang' file is uploaded, preserve the old filename in the database
                    $data['foto_tentang'] = $oldFotoTentang;
                }

                // var_dump($data);
                // die;

                // Update data profil di database berdasarkan username yang sudah login
                $username_pengguna = session()->get('username');
                // var_dump($username_pengguna);
                // die;
                // $updateSuccess = $model->update($username_pengguna, $data);
                // $model->db->getLastQuery();
                // var_dump($updateSuccess);
                // die;
                $model->where('username', $username_pengguna);
                $model->set($data);
                $model->update();

                if ($model->affectedRows() > 0) {
                    session()->setFlashdata('success', 'Profil berhasil diubah.');
        
                    // Jika username berubah, arahkan ke halaman login
                    if ($data['username'] !== $username_pengguna) {
                        return redirect()->to(base_url('logout'));
                    } else {
                        // Jika username tidak berubah, arahkan ke halaman profil
                        return redirect()->to(base_url('admin/tentang/edit'));
                    }
                } else {
                    session()->setFlashdata('error', 'Terjadi kesalahan dalam pembaruan profil.');
                }
            } catch (\Exception $e) {
                // Tangani error di sini
                // Misalnya, tampilkan pesan error ke pengguna
                session()->setFlashdata('error', 'Terjadi kesalahan saat mengubah profil: ' . $e->getMessage());
                return redirect()->to(base_url('admin/tentang/edit'));
            }
        }

        // Jika belum ada data yang dikirim, tampilkan halaman untuk mengubah profil
        $data['tentang_pengguna'] = $model->getTentang();

        return view('admin/tentang/edit', $data); // Ubah 'vw_ubah_profil' sesuai dengan halaman ubah profil Anda
    }
}
