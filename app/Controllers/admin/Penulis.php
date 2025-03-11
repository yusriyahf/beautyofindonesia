<?php

namespace App\Controllers\admin;

use App\Models\PenulisModel;

class Penulis extends BaseController
{
    public function index()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login')); 
            // Ubah 'login' sesuai dengan halaman login Anda
        }
        $penulis_model = new PenulisModel();
        $all_data_penulis = $penulis_model->findAll();
        $validation = \Config\Services::validation();
        return view('admin/penulis/index', [
            'all_data_penulis' => $all_data_penulis,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $penulis_model = new PenulisModel();
        $all_data_penulis = $penulis_model->findAll();
        $validation = \Config\Services::validation();
        return view('admin/penulis/tambah', [
            'all_data_penulis' => $all_data_penulis,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        if (!$this->validate([
            'foto_penulis' => [
                'rules' => 'uploaded[foto_penulis]|is_image[foto_penulis]|max_dims[foto_penulis,3000,3000]|mime_in[foto_penulis,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih foto terlebih dahulu',
                    'is_image' => 'File yang anda pilih bukan gambar',
                    'max_dims' => 'Maksimal ukuran gambar 572x572 pixels',
                    'mime_in' => 'File yang anda pilih wajib berekstensikan jpg/jpeg/png'
                ]
            ]
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        } else {
            $file_foto = $this->request->getFile('foto_penulis');
            $file_foto->move('assets-baru/img/');
            $file_name = $file_foto->getName();
            $penulisModel = new PenulisModel();
            $data = [
                'nama_penulis' => $this->request->getVar("nama_penulis"),
                'deskripsi_penulis' => $this->request->getVar("deskripsi_penulis"),
                'foto_penulis' => $file_name
            ];
            $penulisModel->save($data);

            session()->setFlashdata('success', 'Data berhasil disimpan');
            return redirect()->to(base_url('admin/penulis/index'));
        }
    }

    public function edit($id_penulis)
    {
        $penulis_model = new PenulisModel();
        $penulisData = $penulis_model->find($id_penulis);
        $validation = \Config\Services::validation();

        return view('admin/penulis/edit', [
            'penulisData' => $penulisData,
            'validation' => $validation
        ]);
    }

    // Penulis.php (Controller)
    public function proses_edit($id_penulis = null)
    {
        if (!$id_penulis) {
            return redirect()->back();
        }

        $penulisModel = new PenulisModel();
        $penulisData = $penulisModel->find($id_penulis);

        // Check if new 'foto_penulis' file is uploaded
        if ($this->request->getFile('foto_penulis')->isValid()) {
            // Delete the old 'foto_penulis' file
            unlink('assets-baru/img/' . $penulisData->foto_penulis);

            // Upload the new 'foto_penulis' file
            $dataPenulis = $this->request->getFile('foto_penulis');
            $fotoName = $dataPenulis->getRandomName();
            $dataPenulis->move('assets-baru/img/', $fotoName);

            // Update the 'foto_penulis' field in the database with a "where" clause
            $penulisModel->where('id_penulis', $id_penulis)->set([
                'foto_penulis' => $fotoName,
                'nama_penulis' => $this->request->getPost("nama_penulis"),
                'deskripsi_penulis' => $this->request->getPost("deskripsi_penulis"),
            ])->update();
        } else {
            // If no new 'foto_penulis' file is uploaded, update only the other fields
            $penulisModel->where('id_penulis', $id_penulis)->set([
                'nama_penulis' => $this->request->getPost("nama_penulis"),
                'deskripsi_penulis' => $this->request->getPost("deskripsi_penulis"),
            ])->update();
        }

        session()->setFlashdata('success', 'Berkas berhasil diperbarui');
        return redirect()->to(base_url('admin/penulis/index'));
    }




    public function delete($id = false)
    {
        $penulisModel = new PenulisModel();

        $data = $penulisModel->find($id);

        unlink('assets-baru/img/' . $data->foto_penulis);

        $penulisModel->delete($id);

        return redirect()->to(base_url('admin/penulis/index'));
    }
}
