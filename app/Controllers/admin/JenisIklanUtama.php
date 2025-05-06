<?php

namespace App\Controllers\Admin;

use App\Models\JenisIklanUtamaModel;

class JenisIklanUtama extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new JenisIklanUtamaModel();
    }

    public function index()
    {
        $data['jenisiklanutama'] = $this->model->findAll();
        return view('admin/jenis_iklan_utama/index', $data);
    }

    public function tambah()
    {
        $validation = \Config\Services::validation();
    
        return view('admin/jenis_iklan_utama/tambah', [
            'validation' => $validation
        ]);
    }   

    public function proses_tambah()
    {
        $this->model->save([
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    
        return redirect()->to('/admin/jenisiklanutama'); // <- sudah bener
    }

    public function edit($id)
    {
        $iklan = $this->model->find($id); // Mengambil data iklan berdasarkan id

        // Jika data iklan tidak ditemukan
        if (!$iklan) {
            return redirect()->to('/admin/jenisiklanutama')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/jenis_iklan_utama/edit', [
            'iklan' => $iklan,  // Mengirim data iklan ke view
            'validation' => \Config\Services::validation()
        ]);
    }
        
    public function update($id)
    {
        $this->model->update($id, [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'status' => $this->request->getPost('status'),
            'created_at' => $this->request->getPost('created_at'),
        ]);
    
        return redirect()->to('/admin/jenisiklanutama'); // <- sudah bener
    }
    
    public function delete($id)
{
    if ($id === null) {
        // Misalnya kalo id kosong/null, biar aman lempar balik
        return redirect()->to('/admin/jenisiklanutama')->with('error', 'ID tidak ditemukan.');
    }

    $deleted = $this->model->delete($id);

    if ($deleted) {
        return redirect()->to('/admin/jenisiklanutama')->with('success', 'Data berhasil dihapus.');
    } else {
        return redirect()->to('/admin/jenisiklanutama')->with('error', 'Gagal menghapus data.');
    }
}


}