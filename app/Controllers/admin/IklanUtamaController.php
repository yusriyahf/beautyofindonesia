<?php

namespace App\Controllers\Admin;

use App\Models\IklanUtamaModel;
use App\Models\JenisIklanUtama;

class IklanUtamaController extends BaseController
{

    private $iklanUtamaModel;
    private $jenisIklanUtamaModel;

    public function __construct()
    {
        $this->iklanUtamaModel = new IklanUtamaModel();
        $this->jenisIklanUtamaModel = new JenisIklanUtama();
    }

    public function index()
    {
        $all_data_iklan_utama = $this->iklanUtamaModel->findAll();
        $validation = \Config\Services::validation();
        return view('marketing/iklan_utama/index', [
            'all_data_iklan_utama' => $all_data_iklan_utama,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $listJenisIklanUtama = $this->jenisIklanUtamaModel->findAll();


        return view('marketing/iklan_utama/create', [
            'listJenisIklanUtama' => $listJenisIklanUtama,
        ]);
    }

    public function proses_tambah()
    {
        $idMarkerting = session()->get('id_user');
        if (!$idMarkerting) {
            return redirect()->back()->with('error', 'User tidak ditemukan dalam sesi.');
        }

        $idJenisIklanUtama = $this->request->getPost('id_jenis_iklan_utama');
        $idMarketing = $this->request->getPost('id_marketing');
        $urlIklan = $this->request->getPost('url_iklan');
        $rentangBulan = $this->request->getPost('rentang_bulan');


        $totalHarga = $this->request->getPost('total_harga');
        $cleanTotalHarga = floatval(str_replace([',', ' '], '', $totalHarga));

        // Susun data yang akan disimpan
        $data = [
            'id_jenis_iklan_utama'      => $idJenisIklanUtama,
            'id_marketing'    => $idMarketing,
            'url_iklan'        => $urlIklan,
            'rentang_bulan'        => $rentangBulan,
            'status'        => 'diajukan',
            'total_harga'        => $cleanTotalHarga,
            'tanggal_pengajuan' => date('Y-m-d'),
        ];

        // Simpan ke database
        $this->iklanUtamaModel->insert($data);
        $this->jenisIklanUtamaModel->update($idJenisIklanUtama, [
            'status' => 'tidak'
        ]);

        return redirect()->to(base_url('admin/iklanutama'))->with('success', 'Pengajuan iklan berhasil disimpan.');
    }
}
