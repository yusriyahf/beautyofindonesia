<?php

namespace App\Controllers\admin;

use App\Models\IklanModel;

class Iklan extends BaseController
{
    private $iklanModel;

    public function __construct()
    {
        $this->iklanModel = new IklanModel();
    }

    public function index()
    {
        $all_data_iklan = $this->iklanModel->findAll();
        $validation = \Config\Services::validation();
        return view('admin/iklan/index', [
            'all_data_iklan' => $all_data_iklan,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $validation = \Config\Services::validation();

        return view('admin/iklan/tambah', [
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        if (!$this->validate([
            'nama' => 'required|string',
            'harga' => 'required|numeric',
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama' => $this->request->getVar("nama"),
            'harga' => $this->request->getVar("harga"),
        ];

        $this->iklanModel->save($data);

        session()->setFlashdata('success', 'Data iklan berhasil disimpan');
        return redirect()->to(base_url('admin/iklan'));
    }

    public function edit($id)
    {
        $iklan = $this->iklanModel->find($id);
        $validation = \Config\Services::validation();

        if (!$iklan) {
            return redirect()->to(base_url('admin/iklan'))->with('error', 'Data tidak ditemukan');
        }

        return view('admin/iklan/edit', [
            'iklan' => $iklan,
            'validation' => $validation
        ]);
    }

    public function proses_edit($id = null)
    {
        $iklanData = $this->iklanModel->find($id);

        if (!$iklanData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        if (!$this->validate([
            'nama' => 'required|string',
            'harga' => 'required|numeric',
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'nama' => $this->request->getPost("nama"),
            'harga' => $this->request->getPost("harga"),
        ];

        $this->iklanModel->update($id, $data);

        session()->setFlashdata('success', 'Data iklan berhasil diperbarui');
        return redirect()->to(base_url('admin/iklan'));
    }

    public function delete($id = false)
    {
        $iklanData = $this->iklanModel->find($id);

        if (!$iklanData) {
            session()->setFlashdata('error', 'Data iklan tidak ditemukan');
            return redirect()->to(base_url('admin/iklan'));
        }

        $this->iklanModel->delete($id);

        session()->setFlashdata('success', 'Data iklan berhasil dihapus');
        return redirect()->to(base_url('admin/iklan'));
    }
}
