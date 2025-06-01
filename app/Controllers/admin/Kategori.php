<?php

namespace App\Controllers\admin;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    public function index()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
            // Ubah 'login' sesuai dengan halaman login Anda
        }
        $kategori_model = new KategoriModel();
        $all_data_kategori = $kategori_model->findAll();
        $validation = \Config\Services::validation();
        return view('admin/kategori/index', [
            'all_data_kategori' => $all_data_kategori,
            'validation' => $validation
        ]);
    }
    public function tambah()
    {
        $kategori_model = new KategoriModel();
        $all_data_kategori = $kategori_model->findAll();
        $validation = \Config\Services::validation();
        return view('admin/kategori/tambah', [
            'all_data_kategori' => $all_data_kategori,
            'validation' => $validation
        ]);
    }
    public function proses_tambah()
    {
        $kategoriModel = new KategoriModel();

        // Ambil input dari request
        $namaKategori = $this->request->getVar("nama_kategori");
        $namaKategoriEn = $this->request->getVar("nama_kategori_en");

        // Buat slug secara otomatis
        $slugKategori = url_title($namaKategori, '-', true); // true untuk lowercase
        $slugKategoriEn = url_title($namaKategoriEn, '-', true);

        // Data yang akan disimpan
        $data = [
            'nama_kategori' => $namaKategori,
            'nama_kategori_en' => $namaKategoriEn,
            'slug_kategori' => $slugKategori,
            'slug_kategori_en' => $slugKategoriEn,
        ];

        // Simpan ke database
        $kategoriModel->save($data);

        // Set flashdata dan redirect
        session()->setFlashdata('success', 'Data berhasil disimpan');
        $role = session()->get('role');
        return redirect()->to(base_url($role . '/kategori/index'));
    }


    public function edit($id_kategori)
    {
        $kategori_model = new KategoriModel();
        $kategoriData = $kategori_model->find($id_kategori);
        $validation = \Config\Services::validation();

        return view('admin/kategori/edit', [
            'kategoriData' => $kategoriData,
            'validation' => $validation
        ]);
    }

    public function proses_edit($id_kategori = null)
    {
        if (!$id_kategori) {
            return redirect()->back();
        }

        $kategoriModel = new KategoriModel();
        $kategoriData = $kategoriModel->find($id_kategori);

        if (!$kategoriData) {
            session()->setFlashdata('error', 'Data kategori tidak ditemukan');
            $role = session()->get('role');
            return redirect()->to(base_url($role . '/kategori/index'));
        }

        // Ambil input dari pengguna
        $namaKategori = $this->request->getPost("nama_kategori");
        $namaKategoriEn = $this->request->getPost("nama_kategori_en");

        // Buat slug berdasarkan nama kategori yang baru
        $slugKategori = url_title($namaKategori, '-', true);
        $slugKategoriEn = url_title($namaKategoriEn, '-', true);

        // Update data dalam database
        $kategoriModel->update($id_kategori, [
            'nama_kategori' => $namaKategori,
            'nama_kategori_en' => $namaKategoriEn,
            'slug_kategori' => $slugKategori,
            'slug_kategori_en' => $slugKategoriEn,
        ]);

        session()->setFlashdata('success', 'Data kategori berhasil diperbarui');
        $role = session()->get('role');
        return redirect()->to(base_url($role . '/kategori/index'));
    }
    

    public function delete($id = false)
    {
        $kategoriModel = new KategoriModel();

        $data = $kategoriModel->find($id);

        $kategoriModel->delete($id);

        $role = session()->get('role');
        return redirect()->to(base_url($role . '/kategori/index'));
    }
}
