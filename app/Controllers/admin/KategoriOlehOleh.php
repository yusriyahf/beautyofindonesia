<?php

namespace App\Controllers\Admin;

use App\Models\KategoriOlehOlehModel;
use App\Models\KabupatenModel;

class KategoriOlehOleh extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
            // Ubah 'login' sesuai dengan halaman login Anda
        }
        $kategoriOlehOlehModel = new KategoriOlehOlehModel();
        $all_data_kategori_oleholeh = $kategoriOlehOlehModel->getKategoriOlehOleh();
        $validation = \Config\Services::validation();

        return view('admin/kategori_oleholeh/index', [
            'all_data_kategori_oleholeh' => $all_data_kategori_oleholeh,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $kabupatenModel = new KabupatenModel();
        $all_data_kabupaten = $kabupatenModel->findAll();
        $validation = \Config\Services::validation();

        return view('admin/kategori_oleholeh/tambah', [
            'all_data_kabupaten' => $all_data_kabupaten,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $kategoriOlehOlehModel = new KategoriOlehOlehModel();

        if (!$this->validate([
            'nama_kategori_oleholeh' => 'required|min_length[3]',
            'nama_kategori_oleholeh_en' => 'required|min_length[3]',
        ])) {
            $role = session()->get('role');
            return redirect()->to(base_url($role. '/kategori_oleholeh/tambah'))->withInput()->with('validation', \Config\Services::validation());
        }

        // Ambil inputan dari form
        $nama_kategori_oleholeh = $this->request->getPost("nama_kategori_oleholeh");
        $nama_kategori_oleholeh_en = $this->request->getPost("nama_kategori_oleholeh_en");

        // Buat slug dengan mengganti spasi menjadi - dan mengubah ke huruf kecil
        $slug_kategori_oleholeh = strtolower(str_replace(' ', '-', $nama_kategori_oleholeh));
        $slug_kategori_oleholeh_en = strtolower(str_replace(' ', '-', $nama_kategori_oleholeh_en));

        $data = [
            'nama_kategori_oleholeh' => $nama_kategori_oleholeh,
            'nama_kategori_oleholeh_en' => $nama_kategori_oleholeh_en,
            'slug_kategori_oleholeh' => $slug_kategori_oleholeh,
            'slug_kategori_oleholeh_en' => $slug_kategori_oleholeh_en,
            'meta_title_id' => $this->request->getVar("meta_title_id"),
            'meta_title_en' => $this->request->getVar("meta_title_en"),
            'meta_description_id' => $this->request->getVar("meta_description_id"),
            'meta_description_en' => $this->request->getVar("meta_description_en"),
        ];

        // Simpan data ke database
        $kategoriOlehOlehModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        $role = session()->get('role');
        return redirect()->to(base_url($role . '/kategori_oleholeh/index'));
    }

    public function edit($id_kategori_oleholeh)
    {
        $kategoriOlehOlehModel = new KategoriOlehOlehModel();
        $kategoriOlehOlehData = $kategoriOlehOlehModel->getKategoriOlehOlehById($id_kategori_oleholeh);

        if (!$kategoriOlehOlehData) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori Oleh-Oleh tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        return view('admin/kategori_oleholeh/edit', [
            'kategoriOlehOlehData' => $kategoriOlehOlehData,
            'validation' => $validation
        ]);
    }

    public function proses_edit($id_kategori_oleholeh = null)
    {
        if (!$id_kategori_oleholeh) {
            return redirect()->back();
        }

        // Validate the input
        if (!$this->validate([
            'nama_kategori_oleholeh' => 'required|min_length[3]',
            'nama_kategori_oleholeh_en' => 'required|min_length[3]',
        ])) {
            $role = session()->get('role');
            return redirect()->to(base_url($role . '/kategori_oleholeh/edit/' . $id_kategori_oleholeh))
                ->withInput()
                ->with('validation', \Config\Services::validation());
        }

        $kategoriOlehOlehModel = new KategoriOlehOlehModel();

        // Get the data based on ID
        $kategori = $kategoriOlehOlehModel->find($id_kategori_oleholeh);

        if (!$kategori) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan');
        }

        // Get input data
        $namaKategori = $this->request->getPost("nama_kategori_oleholeh");
        $namaKategoriEn = $this->request->getPost("nama_kategori_oleholeh_en");

        // Generate the slug for both Indonesian and English names
        $slugKategori = url_title($namaKategori, '-', true);
        $slugKategoriEn = url_title($namaKategoriEn, '-', true);

        // Data for update
        $data = [
            'nama_kategori_oleholeh' => $namaKategori,
            'nama_kategori_oleholeh_en' => $namaKategoriEn,
            'slug_kategori_oleholeh' => $slugKategori,
            'slug_kategori_oleholeh_en' => $slugKategoriEn,
            'meta_title_id' => $this->request->getPost("meta_title_id"),
            'meta_title_en' => $this->request->getPost("meta_title_en"),
            'meta_description_id' => $this->request->getPost("meta_description_id"),
            'meta_description_en' => $this->request->getPost("meta_description_en"),
        ];

        // Update the category data
        $kategoriOlehOlehModel->update($id_kategori_oleholeh, $data);

        // Set flashdata and redirect
        session()->setFlashdata('success', 'Kategori oleh-oleh berhasil diperbarui');
        $role = session()->get('role');
        return redirect()->to(base_url($role . '/kategori_oleholeh/index'));
    }

    public function delete($id = false)
    {
        $kategoriOlehOlehModel = new KategoriOlehOlehModel();

        $kategoriOlehOlehModel->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        $role = session()->get('role');
        return redirect()->to(base_url($role . '/kategori_oleholeh/index'));
    }
}
