<?php

namespace App\Controllers;

use App\Models\ArtikelIklanModel;

class ArtikelIklan extends BaseController
{
    private $ArtikelIklanModel;

    public function __construct()
    {
        $this->ArtikelIklanModel = new ArtikelIklanModel();
    }

    public function index()
    {
        $all_data_artikeliklan = $this->ArtikelIklanModel->findAll();
        $validation = \Config\Services::validation();
        return view('marketing/iklan/index', [
            'all_data_artikeliklan' => $all_data_artikeliklan,
            dd($all_data_artikeliklan),
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $listArtikelIklan = $this->ArtikelIklanModel->asObject()->findAll();

        $validation = \Config\Services::validation();

        return view('marketing/popup/tambah', [
            'listArtikelIklan' => $listArtikelIklan,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $foto = $this->request->getFile('foto_popup');

        // Validasi input termasuk file gambar
        if (!$this->validate([
            'foto_popup' => [
                'rules' => 'uploaded[foto_popup]|is_image[foto_popup]|mime_in[foto_popup,image/jpg,image/jpeg,image/png]|max_size[foto_popup,2048]',
                'errors' => [
                    'uploaded' => 'Foto popup wajib diunggah',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format gambar harus jpg, jpeg, atau png',
                    'max_size' => 'Ukuran maksimal gambar adalah 2MB'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Proses upload gambar jika valid
        if ($foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/popups', $namaFoto);
        } else {
            $namaFoto = null;
        }

        $data = [
            'nama_popup' => $this->request->getVar("nama_popup"),
            'title_popup' => $this->request->getVar("title_popup"),
            'link_popup' => $this->request->getVar("link_popup"),
            'nama_tombol' => $this->request->getVar("nama_tombol"),
            'foto_popup' => $namaFoto,
        ];

        $this->ArtikelIklanModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/popup'));
    }


    public function edit($id_popup)
    {
        $popup = $this->ArtikelIklanModel->asObject()->find($id_popup);

        $validation = \Config\Services::validation();

        return view('admin/popup/edit', [
            'popup' => $popup,
            'validation' => $validation
        ]);
    }

    // Artikel.php (Controller)
    public function proses_edit($id_popup = null)
    {
        $popupData = $this->ArtikelIklanModel->find($id_popup);

        if (!$popupData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $foto = $this->request->getFile('foto_popup');

        // Validasi jika ada file yang diunggah
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!$this->validate([
                'foto_popup' => [
                    'rules' => 'is_image[foto_popup]|mime_in[foto_popup,image/jpg,image/jpeg,image/png]|max_size[foto_popup,2048]',
                    'errors' => [
                        'is_image' => 'File harus berupa gambar',
                        'mime_in' => 'Format gambar harus jpg, jpeg, atau png',
                        'max_size' => 'Ukuran maksimal gambar adalah 2MB'
                    ]
                ]
            ])) {
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }

            // Hapus gambar lama jika ada
            if ($popupData['foto_popup'] && file_exists('uploads/popups/' . $popupData['foto_popup'])) {
                unlink('uploads/popups/' . $popupData['foto_popup']);
            }

            // Simpan gambar baru
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/popups', $namaFoto);
        } else {
            // Gunakan gambar lama jika tidak ada yang baru diunggah
            $namaFoto = $popupData['foto_popup'];
        }

        // Simpan data ke database
        $data = [
            'nama_popup' => $this->request->getPost("nama_popup"),
            'title_popup' => $this->request->getPost("title_popup"),
            'link_popup' => $this->request->getPost("link_popup"),
            'nama_tombol' => $this->request->getPost("nama_tombol"),
            'foto_popup' => $namaFoto,
        ];

        $this->ArtikelIklanModel->update($id_popup, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to(base_url('admin/popup'));
    }

    public function delete($id = false)
    {
        // Cari data popup berdasarkan ID
        $popupData = $this->ArtikelIklanModel->asObject()->find($id);

        if (!$popupData) {
            session()->setFlashdata('error', 'Data Popup tidak ditemukan');
            return redirect()->to(base_url('admin/popup'));
        }

        // Hapus gambar jika ada
        if ($popupData->foto_popup && file_exists('uploads/popups/' . $popupData->foto_popup)) {
            unlink('uploads/popups/' . $popupData->foto_popup);
        }

        // Hapus data dari database
        $this->ArtikelIklanModel->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('admin/popup'));
    }
}
