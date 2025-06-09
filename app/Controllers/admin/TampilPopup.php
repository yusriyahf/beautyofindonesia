<?php

namespace App\Controllers\Admin;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\PenulisModel;
use App\Models\PopupModel;
use App\Models\TampilPopupModel;
use App\Models\TentangModel;
use CodeIgniter\Config\Services;

class TampilPopup extends BaseController
{

    private $TampilPopupModel;
    private $PopupModel;


    public function __construct()
    {
        $this->TampilPopupModel = new TampilPopupModel();
        $this->PopupModel = new PopupModel();
    }

    public function index()
    {
        $all_data_tampilpopup = $this->TampilPopupModel->getTampilPopup();
        $validation = \Config\Services::validation();
        return view('admin/tampilpopup/index', [
            'all_data_tampilpopup' => $all_data_tampilpopup,
            'validation' => $validation
        ]);
    }

    // public function viewArtikel($id_artikel, $slug)
    // {
    //     $lang = session()->get('lang') ?? 'id'; // 'id' as default if not set

    //     $detail_artikel = $this->ArtikelModel->getDetailArtikel($id_artikel, $slug);



    //     $judul_artikel = $detail_artikel['judul_artikel'] ?? 'Judul Artikel Tidak Ditemukan';
    //     $judul_artikel = strlen($judul_artikel) > 50 ? substr($judul_artikel, 0, 50) . '...' : $judul_artikel;

    //     $nama_tentang = $this->TentangModel->getNamaTentang(); // Jika Anda ingin menggunakan TentangModel, pastikan sudah di-load

    //     $title = "$judul_artikel - $nama_tentang";

    //     // Mengambil foto artikel dari data yang ditemukan
    //     $foto_artikel = $detail_artikel['foto_artikel'] ?? 'default.jpg';

    //     $data = [
    //         'artikel' => $detail_artikel,
    //         'artikel_lain' => $this->ArtikelModel->getArtikelLainnya($id_artikel, 4),
    //         'kategori' => $this->KategoriModel->getKategori(),
    //         'tentang' => $this->TentangModel->getTentangDepan(), // Pastikan sudah ada instance TentangModel
    //         'title' => $title,
    //         'foto_artikel' => $foto_artikel // Menyertakan foto artikel ke data yang dikirimkan ke view
    //     ];

    //     return view('user/home/detail', $data);
    // }


    public function tambah()
    {
        $listPopup = $this->PopupModel->asObject()->findAll();

        $validation = \Config\Services::validation();

        return view('admin/tampilpopup/tambah', [
            'listPopup' => $listPopup,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $data = [
            'id_popup' => $this->request->getVar("id_popup"),
            'url_tampil_popup' => $this->request->getVar("url_tampil_popup"),
            'jenis_url_tampil_popup' => $this->request->getVar("jenis_url_tampil_popup"),
        ];

        $this->TampilPopupModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/tampilpopup'));
    }

    public function edit($id_tampilpopup)
    {
        $tampilPopupData = $this->TampilPopupModel->asObject()->find($id_tampilpopup);
        $listPopup = $this->PopupModel->asObject()->findAll();

        $validation = \Config\Services::validation();

        return view('admin/tampilpopup/edit', [
            'tampilPopupData' => $tampilPopupData,
            'listPopup' => $listPopup,
            'validation' => $validation
        ]);
    }

    // Artikel.php (Controller)
    public function proses_edit($id_tampilpopup = null)
    {
        $tampilPopupData = $this->TampilPopupModel->find($id_tampilpopup);

        if (!$tampilPopupData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'url_tampil_popup' => $this->request->getPost("url_tampil_popup"),
            'jenis_url_tampil_popup' => $this->request->getPost("jenis_url_tampil_popup"),
            'id_popup' => $this->request->getPost("id_popup"),
        ];

        $this->TampilPopupModel->update($id_tampilpopup, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to(base_url('admin/tampilpopup'));
    }

    public function delete($id = false)
    {
        // Cari data artikel berdasarkan ID
        $data = $this->TampilPopupModel->asObject()->find($id);

        if (!$data) {
            session()->setFlashdata('error', 'Data Popup tidak ditemukan');
            return redirect()->to(base_url('admin/tampilpopup'));
        }

        // Hapus data artikel dari database
        $this->TampilPopupModel->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('admin/tampilpopup'));
    }
}
