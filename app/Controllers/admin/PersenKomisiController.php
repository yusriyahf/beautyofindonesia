<?php namespace App\Controllers\Admin;

use App\Controllers\admin\Komisi;
use App\Controllers\BaseController;
use App\Models\KomisiDefaultModel;
use App\Models\KomisiCustomModel;
use App\Models\KomisiIklanModel;
use App\Models\KomisiModel;

class PersenKomisiController extends BaseController
{
    protected $komisiDefaultModel;
    protected $komisiCustomModel;

    public function __construct()
    {
        $this->komisiDefaultModel = new KomisiModel();
        $this->komisiCustomModel = new KomisiIklanModel();
    }

    // Menampilkan halaman utama manajemen komisi
    public function index()
    {
        $data = [
            'title' => 'Manajemen Komisi',
            'komisi_default' => $this->komisiDefaultModel->findAll(),
            'komisi_custom' => $this->komisiCustomModel->getKomisiWithDetails(),
            'total_pemasukan' => 0, // Sesuaikan dengan model Anda
            'total_pengeluaran' => 0, // Sesuaikan dengan model Anda
            'saldo' => ['saldo' => 0] // Sesuaikan dengan model Anda
        ];

        return view('admin/komisi/index', $data);
    }

    // Menambahkan komisi default baru
    public function tambah_default()
    {
        if (!$this->validate([
            'nama' => 'required|alpha_space|max_length[50]',
            'komisi' => 'required|numeric|greater_than[0]|less_than_equal_to[100]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'komisi' => $this->request->getPost('komisi')
        ];

        if ($this->komisiDefaultModel->save($data)) {
            return redirect()->to('/admin/riwayatkomisi')->with('success', 'Komisi default berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan komisi default');
        }
    }

    // Mengupdate komisi default
    public function update_default($id)
    {
        if (!$this->validate([
            'nama' => 'required|alpha_space|max_length[50]',
            'komisi' => 'required|numeric|greater_than[0]|less_than_equal_to[100]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'nama' => $this->request->getPost('nama'),
            'komisi' => $this->request->getPost('komisi')
        ];

        if ($this->komisiDefaultModel->save($data)) {
            return redirect()->to('/admin/riwayatkomisi')->with('success', 'Komisi default berhasil diupdate');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate komisi default');
        }
    }

    // Menghapus komisi default
    public function delete_default($id)
    {
        if ($this->komisiDefaultModel->delete($id)) {
            return redirect()->to('/admin/riwayatkomisi')->with('success', 'Komisi default berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus komisi default');
        }
    }

    // Menambahkan komisi custom baru
    public function tambah_custom()
    {
        if (!$this->validate([
            'id_iklan' => 'required|numeric',
            'tipe_iklan' => 'required|in_list[konten,utama]',
            'id_user' => 'required|numeric',
            'peran' => 'required|in_list[penulis,marketing,admin]',
            'persen' => 'required|numeric|greater_than[0]|less_than_equal_to[100]',
            'jumlah_komisi' => 'required|numeric|greater_than[0]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_iklan' => $this->request->getPost('id_iklan'),
            'tipe_iklan' => $this->request->getPost('tipe_iklan'),
            'id_user' => $this->request->getPost('id_user'),
            'peran' => $this->request->getPost('peran'),
            'persen' => $this->request->getPost('persen'),
            'jumlah_komisi' => $this->request->getPost('jumlah_komisi')
        ];

        if ($this->komisiCustomModel->save($data)) {
            return redirect()->to('/admin/riwayatkomisi')->with('success', 'Komisi custom berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan komisi custom');
        }
    }

    // Menghapus komisi custom
    public function delete_custom($id)
    {
        if ($this->komisiCustomModel->delete($id)) {
            return redirect()->to('/admin/riwayatkomisi')->with('success', 'Komisi custom berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus komisi custom');
        }
    }

    // Mendapatkan detail komisi custom untuk AJAX
    public function get_detail_custom($id)
    {
        $komisi = $this->komisiCustomModel->find($id);
        
        if (!$komisi) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data komisi tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $komisi
        ]);
    }
}