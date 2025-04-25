<?php

namespace App\Controllers\admin;

use App\Models\KategoriWisataModel;
use App\Models\KabupatenModel;

class KategoriWisata extends BaseController
{
    public function index()
    {
        $kategoriWisataModel = new KategoriWisataModel();
        $all_data_kategori_wisata = $kategoriWisataModel->getKategoriWisata();
        $validation = \Config\Services::validation();

        return view('admin/kategori_wisata/index', [
            'all_data_kategori_wisata' => $all_data_kategori_wisata,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $kabupatenModel = new KabupatenModel();
        $all_data_kabupaten = $kabupatenModel->findAll();
        $validation = \Config\Services::validation();

        return view('admin/kategori_wisata/tambah', [
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $kategoriWisataModel = new KategoriWisataModel();

        // Validasi input
        if (!$this->validate([
            'nama_kategori_wisata' => 'required|min_length[3]',
            'nama_kategori_wisata_en' => 'required|min_length[3]',
        ])) {
            return redirect()->to(base_url('admin/kategori_wisata/tambah'))->withInput()->with('validation', \Config\Services::validation());
        }

        // Data input
        $namaKategori = $this->request->getPost("nama_kategori_wisata");
        $namaKategoriEn = $this->request->getPost("nama_kategori_wisata_en");

        // Buat slug
        $slugKategori = url_title($namaKategori, '-', true); // Mengubah nama menjadi slug
        $slugKategoriEn = url_title($namaKategoriEn, '-', true); // Mengubah nama menjadi slug

        // Data yang akan disimpan
        $data = [
            'nama_kategori_wisata' => $namaKategori,
            'nama_kategori_wisata_en' => $namaKategoriEn,
            'slug_kategori_wisata' => $slugKategori,
            'slug_kategori_wisata_en' => $slugKategoriEn,
        ];

        // Simpan data ke database
        $kategoriWisataModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/kategori_wisata/index'));
    }


    public function edit($id_kategori_wisata)
    {
        $kategoriWisataModel = new KategoriWisataModel();
        $kategoriWisataData = $kategoriWisataModel->getKategoriWisataById($id_kategori_wisata);

        if (!$kategoriWisataData) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori Wisata tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        return view('admin/kategori_wisata/edit', [
            'kategoriWisataData' => $kategoriWisataData,
            'validation' => $validation
        ]);
    }

    public function proses_edit($id_kategori_wisata = null)
    {
        if (!$id_kategori_wisata) {
            return redirect()->back();
        }

        $kategoriWisataModel = new KategoriWisataModel();

        // Mengambil data kategori berdasarkan id
        $kategori = $kategoriWisataModel->find($id_kategori_wisata);

        if (!$kategori) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan');
        }

        // Validasi input
        if (!$this->validate([
            'nama_kategori_wisata' => 'required|min_length[3]',
            'nama_kategori_wisata_en' => 'required|min_length[3]',
        ])) {
            return redirect()->to(base_url('admin/kategori_wisata/edit/' . $id_kategori_wisata))->withInput()->with('validation', \Config\Services::validation());
        }

        // Data input
        $namaKategori = $this->request->getPost("nama_kategori_wisata");
        $namaKategoriEn = $this->request->getPost("nama_kategori_wisata_en");

        // Buat slug baru
        $slugKategori = url_title($namaKategori, '-', true);
        $slugKategoriEn = url_title($namaKategoriEn, '-', true);

        // Data untuk update
        $data = [
            'nama_kategori_wisata' => $namaKategori,
            'nama_kategori_wisata_en' => $namaKategoriEn,
            'slug_kategori_wisata' => $slugKategori,
            'slug_kategori_wisata_en' => $slugKategoriEn,
        ];

        // Update data
        $kategoriWisataModel->update($id_kategori_wisata, $data);

        session()->setFlashdata('success', 'Kategori wisata berhasil diperbarui');
        return redirect()->to(base_url('admin/kategori_wisata/index'));
    }



    public function delete($id = false)
    {
        $kategoriWisataModel = new KategoriWisataModel();

        $kategoriWisataModel->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('admin/kategori_wisata/index'));
    }
}
