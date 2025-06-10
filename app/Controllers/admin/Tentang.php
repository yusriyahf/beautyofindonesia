<?php

namespace App\Controllers\Admin; // Sesuaikan dengan namespace yang sesuai di aplikasi Anda
use App\Controllers\BaseController;
use App\Models\TentangModel;

class Tentang extends BaseController
{
    private $tentangModel;

    public function __construct()
    {
        $this->tentangModel = new TentangModel();
    }

    public function edit()
    {
        // Ambil data pertama (asumsi hanya ada satu row)
        $tentang = $this->tentangModel->first();

        if ($this->request->getMethod() === 'post') {
            // Validasi (bisa disesuaikan sesuai kebutuhan)
            $validationRules = [
                'nama_tentang' => 'required',
                'deskripsi_tentang' => 'required',
                'email' => 'required|valid_email',
                // Tambahkan aturan lainnya sesuai kebutuhan
            ];

            if (!$this->validate($validationRules)) {
                return view('admin/tentang_edit', [
                    'tentang' => $tentang,
                    'validation' => $this->validator
                ]);
            }

            // Ambil data dari input
            $data = $this->request->getPost();

            // Upload foto jika ada
            $file = $this->request->getFile('foto_tentang');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('assets-baru/img/', $newName);
                $data['foto_tentang'] = $newName;
            }

            $this->tentangModel->update($tentang->id_tentang, $data);

            return redirect()->to('admin/tentang/edit')->with('success', 'Data berhasil diperbarui');
        }

        return view('admin/tentang/edit', ['tentang' => $tentang]);
    }
}
