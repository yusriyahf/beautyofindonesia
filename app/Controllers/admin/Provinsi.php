<?php

namespace App\Controllers\Admin;

use App\Models\ProvinsiModel;

class Provinsi extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $provinsiModel = new ProvinsiModel();
        $all_data_provinsi = $provinsiModel->findAll();
        $validation = \Config\Services::validation();

        return view('admin/provinsi/index', [
            'all_data_provinsi' => $all_data_provinsi,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $validation = \Config\Services::validation();
        return view('admin/provinsi/tambah', [
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $provinsiModel = new ProvinsiModel();
        $data = [
            'id_provinsi' => $this->request->getVar("id_provinsi"),
            'nama_provinsi' => $this->request->getVar("nama_provinsi"),
            'nama_provinsi_eng' => $this->request->getVar("nama_provinsi_eng"),
        ];

        $provinsiModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/provinsi/index'));
    }

    public function edit($id_provinsi)
    {
        $provinsiModel = new ProvinsiModel();
        $provinsiData = $provinsiModel->find($id_provinsi);
        $validation = \Config\Services::validation();

        return view('admin/provinsi/edit', [
            'provinsiData' => $provinsiData,
            'validation' => $validation
        ]);
    }

    public function proses_edit($id_provinsi = null)
    {
        if (!$id_provinsi) {
            return redirect()->back();
        }

        $provinsiModel = new ProvinsiModel();
        $data = [
            'nama_provinsi' => $this->request->getPost("nama_provinsi"),
            'nama_provinsi_eng' => $this->request->getPost("nama_provinsi_eng"),
        ];

        $provinsiModel->update($id_provinsi, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to(base_url('admin/provinsi/index'));
    }

    public function delete($id = false)
    {
        $provinsiModel = new ProvinsiModel();

        $provinsiModel->delete($id);

        return redirect()->to(base_url('admin/provinsi/index'));
    }
}
