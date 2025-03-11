<?php

namespace App\Controllers\admin;

use App\Models\MetaModel;

class MetaController extends BaseController
{
    public function index()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
            // Ubah 'login' sesuai dengan halaman login Anda
        }
        $meta_model = new MetaModel();
        $all_data_meta = $meta_model->findAll();
        $validation = \Config\Services::validation();
        return view('admin/meta/index', [
            'all_data_meta' => $all_data_meta,
            'validation' => $validation
        ]);
    }
    public function tambah()
    {
        $meta_model = new MetaModel();
        $all_data_meta = $meta_model->findAll();
        $validation = \Config\Services::validation();
        return view('admin/meta/tambah', [
            'all_data_meta' => $all_data_meta,
            'validation' => $validation
        ]);
    }
    public function proses_tambah()
    {
        $metaModel = new MetaModel();
        $data = [
            'nama_halaman' => $this->request->getVar("nama_halaman"),
            'meta_title_id' => $this->request->getVar("meta_title_id"),
            'meta_description_id' => $this->request->getVar("meta_description_id"),
            'meta_title_en' => $this->request->getVar("meta_title_en"),
            'meta_description_en' => $this->request->getVar("meta_description_en"),
        ];
        $metaModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/meta/index'));
    }

    public function edit($id_seo)
    {
        $meta_model = new MetaModel();
        $metaData = $meta_model->find($id_seo);
        $validation = \Config\Services::validation();

        return view('admin/meta/edit', [
            'metaData' => $metaData,
            'validation' => $validation
        ]);
    }

    public function proses_edit($id_seo = null)
    {
        if (!$id_seo) {
            return redirect()->back();
        }

        $metaModel = new MetaModel();
        $metaData = $metaModel->find($id_seo);

        // Update the 'foto_produk' field in the database with a "where" clause
        $metaModel->where('id_seo', $id_seo)->set([
            'nama_halaman' => $this->request->getPost("nama_halaman"),
            'meta_title_id' => $this->request->getPost("meta_title_id"),
            'meta_description_id' => $this->request->getPost("meta_description_id"),
            'meta_title_en' => $this->request->getPost("meta_title_en"),
            'meta_description_en' => $this->request->getPost("meta_description_en"),
        ])->update();

        session()->setFlashdata('success', 'Berkas berhasil diperbarui');
        return redirect()->to(base_url('admin/meta/index'));
    }

    public function delete($id = false)
    {
        $metaModel = new MetaModel();

        $data = $metaModel->find($id);

        $metaModel->delete($id);

        return redirect()->to(base_url('admin/meta/index'));
    }
}
