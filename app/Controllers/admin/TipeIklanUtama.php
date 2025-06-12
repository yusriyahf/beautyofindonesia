<?php

namespace App\Controllers\Admin;

use App\Models\KategoriModel;
use App\Models\KategoriOlehOlehModel;
use App\Models\KategoriWisataModel;
use App\Models\TipeIklanUtamaModel;

class TipeIklanUtama extends BaseController
{
    protected $model;
    protected $kategoriModel;
    protected $wisataModel;
    protected $oleholehModel;

    public function __construct()
    {
        $this->model = new TipeIklanUtamaModel();
        $this->kategoriModel = new KategoriModel();
        $this->wisataModel = new KategoriWisataModel();
        $this->oleholehModel = new KategoriOlehOlehModel();
    }

    public function index()
    {
        $data['tipeiklanutama'] = $this->model->findAll();
        foreach ($data['tipeiklanutama'] as &$tipe) {
            $parts = explode(' - ', $tipe['nama']);

            $tipe['jenis_konten'] = $parts[0] ?? null;

            if ($tipe['jenis_konten'] === 'Beranda') {
                $tipe['kategori'] = null;
                $tipe['tipe'] = $parts[1] ?? null;
            } else {
                $tipe['kategori'] = $parts[1] ?? null;
                $tipe['tipe'] = $parts[2] ?? null;
            }
        }
        $data['kategori'] = $this->kategoriModel->findAll();
        $data['wisata'] = $this->wisataModel->findAll();
        $data['oleholeh'] = $this->oleholehModel->findAll();
        return view('admin/tipe_iklan_utama/index', $data);
    }

    public function tambah()
    {
        $validation = \Config\Services::validation();

        return view('admin/tipe_iklan_utama/tambah', [
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $jenis_konten = $this->request->getPost('jenis_konten');
        $kategori = $this->request->getPost('kategori');
        $tipe = $this->request->getPost('tipe');
        $missing = [];

        if (!$jenis_konten) $missing[] = 'Jenis Konten';
        if ($jenis_konten !== 'Beranda' && !$kategori) $missing[] = 'Kategori';
        if (!$tipe) $missing[] = 'Tipe Iklan';

        if (!empty($missing)) {
            $fieldList = implode(', ', $missing);
            return redirect()->back()->withInput()->with('error', "Gagal ditambahkan. Mohon isi terlebih dahulu: {$fieldList}.");
        }

        $nama = ($jenis_konten === 'Beranda') ? "{$jenis_konten} - {$tipe}" : "{$jenis_konten} - {$kategori} - {$tipe}";

        // cek data existing (duplicate)
        $existing = $this->model->where('nama', $nama)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data. Tipe iklan utama tersebut sudah ada.');
        }

        $validation = \Config\Services::validation();
        $this->model->save([
            'nama' => $nama,
            'harga' => $this->request->getPost('harga'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/tipeiklanutama')->with('success', 'Data berhasil ditambahkan.'); // <- sudah bener
    }

    public function edit($id)
    {
        $iklan = $this->model->find($id); // Mengambil data iklan berdasarkan id

        // Jika data iklan tidak ditemukan
        if (!$iklan) {
            return redirect()->to('/admin/tipeiklanutama')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/tipe_iklan_utama/edit', [
            'iklan' => $iklan,  // Mengirim data iklan ke view
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $jenis_konten = $this->request->getPost('jenis_konten');
        $kategori = $this->request->getPost('kategori');
        $tipe = $this->request->getPost('tipe');

        $nama = ($jenis_konten === 'Beranda') ? "{$jenis_konten} - {$tipe}" : "{$jenis_konten} - {$kategori} - {$tipe}";

        // cek data existing (duplicate)
        $existing = $this->model->where('nama', $nama)->where('id_tipe_iklan_utama !=', $id)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Gagal merubah data. Tipe iklan utama tersebut sudah ada.');
        }

        $this->model->update($id, [
            'nama' => $nama,
            'harga' => $this->request->getPost('harga'),
            'status' => $this->request->getPost('status'),
            'created_at' => $this->request->getPost('created_at'),
        ]);

        return redirect()->to('/admin/tipeiklanutama')->with('success', 'Data berhasil dirubah.'); // <- sudah bener
    }

    public function delete($id)
    {
        if ($id === null) {
            // Misalnya kalo id kosong/null, biar aman lempar balik
            return redirect()->to('/admin/tipeiklanutama')->with('error', 'ID tidak ditemukan.');
        }

        $deleted = $this->model->delete($id);

        if ($deleted) {
            return redirect()->to('/admin/tipeiklanutama')->with('success', 'Data berhasil dihapus.');
        } else {
            return redirect()->to('/admin/tipeiklanutama')->with('error', 'Gagal menghapus data.');
        }
    }
}
