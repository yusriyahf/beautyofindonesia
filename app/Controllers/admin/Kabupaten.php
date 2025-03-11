<?php

namespace App\Controllers\admin;

use App\Models\KabupatenModel;
use App\Models\ProvinsiModel;

class Kabupaten extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $kabupaten_model = new KabupatenModel();
        $all_data_kabupaten = $kabupaten_model->getKabupaten();
        $validation = \Config\Services::validation();
        
        return view('admin/kabupaten/index', [
            'all_data_kabupaten' => $all_data_kabupaten,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $provinsi_model = new ProvinsiModel();
        $all_data_provinsi = $provinsi_model->findAll();
        $validation = \Config\Services::validation();

        return view('admin/kabupaten/tambah', [
            'all_data_provinsi' => $all_data_provinsi,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $kabupatenModel = new KabupatenModel();
        $data = [
            'id_kotakabupaten' => $this->request->getVar("id_kotakabupaten"),
            'nama_kotakabupaten' => $this->request->getVar("nama_kotakabupaten"),
            'nama_kotakabupaten_eng' => $this->request->getVar("nama_kotakabupaten_eng"),
            'id_provinsi' => $this->request->getVar("id_provinsi"),
        ];
        $kabupatenModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/kabupaten/index'));
    }

    public function edit($id_kotakabupaten)
    {
        $kabupaten_model = new KabupatenModel();
        $provinsi_model = new ProvinsiModel();
        $kabupatenData = $kabupaten_model->getKabupatenById($id_kotakabupaten);
        $all_data_provinsi = $provinsi_model->findAll();
        $validation = \Config\Services::validation();

        if (!$kabupatenData) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Kabupaten with ID $id_kotakabupaten not found");
        }

        return view('admin/kabupaten/edit', [
            'kabupatenData' => $kabupatenData,
            'all_data_provinsi' => $all_data_provinsi,
            'validation' => $validation
        ]);
    }

    public function proses_edit($id_kotakabupaten = null)
    {
        if (!$id_kotakabupaten) {
            return redirect()->back();
        }

        $kabupatenModel = new KabupatenModel();
        $data = [
            'nama_kotakabupaten' => $this->request->getPost("nama_kotakabupaten"),
            'id_provinsi' => $this->request->getPost("id_provinsi"),
        ];

        $kabupatenModel->update($id_kotakabupaten, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to(base_url('admin/kabupaten/index'));
    }

    public function delete($id = false)
{
    $kabupatenModel = new KabupatenModel();

    if ($id) {
        // Menghapus kabupaten beserta data terkait di tb_kategori_wisata
        $kabupatenModel->delete($id);
        session()->setFlashdata('success', 'Data kabupaten dan kategori wisata terkait berhasil dihapus');
    }

    return redirect()->to(base_url('admin/kabupaten/index'));
}

}
