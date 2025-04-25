<?php

namespace App\Controllers\admin;

use App\Models\KomisiModel;

class Komisi extends BaseController
{
    private $komisiModel;

    public function __construct()
    {
        $this->komisiModel = new KomisiModel();
    }

    public function index()
    {
        $all_data_komisi = $this->komisiModel->findAll();
        $validation = \Config\Services::validation();
        return view('admin/komisi/index', [
            'all_data_komisi' => $all_data_komisi,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $validation = \Config\Services::validation();

        return view('admin/komisi/tambah', [
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
{
    if (!$this->validate([
        'nama' => 'required|string',
        'komisi' => 'required|numeric',
    ])) {
        return redirect()->back()->withInput()->with('validation', $this->validator);
    }

    $data = [
        'nama' => $this->request->getVar("nama"),
        'komisi' => $this->request->getVar("komisi"),
    ];

    $this->komisiModel->save($data);

    session()->setFlashdata('success', 'Data komisi berhasil disimpan');
    return redirect()->to(base_url('admin/komisi'));
}


    public function edit($id)
    {
        $komisi = $this->komisiModel->find($id);
        $validation = \Config\Services::validation();

        if (!$komisi) {
            return redirect()->to(base_url('admin/komisi'))->with('error', 'Data tidak ditemukan');
        }

        return view('admin/komisi/edit', [
            'komisi' => $komisi,
            'validation' => $validation
        ]);
    }

    public function proses_edit($id = null)
    {
        $komisiData = $this->komisiModel->find($id);

        if (!$komisiData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        if (!$this->validate([
            'nama' => 'required|string',
            'komisi' => 'required|numeric',
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama' => $this->request->getPost("nama"),
            'komisi' => $this->request->getPost("komisi"),
        ];

        $this->komisiModel->update($id, $data);

        session()->setFlashdata('success', 'Data komisi berhasil diperbarui');
        return redirect()->to(base_url('admin/komisi'));
    }

    public function delete($id = false)
    {
        if (!$id || !$this->komisiModel->find($id)) {
            session()->setFlashdata('error', 'Data komisi tidak ditemukan');
            return redirect()->to(base_url('admin/komisi'));
        }
    
        $this->komisiModel->where('id', $id)->delete();
    
        session()->setFlashdata('success', 'Data komisi berhasil dihapus');
        return redirect()->to(base_url('admin/komisi'));
    }
}
