<?php

namespace App\Controllers\Admin;

use App\Models\IklanUtamaModel;
use App\Models\JenisIklanUtama;
use App\Models\TipeIklanUtama;

class IklanUtamaController extends BaseController
{

    private $iklanUtamaModel;
    private $tipeIklanUtamaModel;

    public function __construct()
    {
        $this->iklanUtamaModel = new IklanUtamaModel();
        $this->tipeIklanUtamaModel = new TipeIklanUtama();
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

    public function index2()
    {
        $all_data_iklan_utama = $this->iklanUtamaModel->findAll();
        $validation = \Config\Services::validation();
        return view('admin/iklan_utama/index', [
            'all_data_iklan_utama' => $all_data_iklan_utama,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $listJenisIklanUtama = $this->tipeIklanUtamaModel->findAll();


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

        $idTipeIklanUtama = $this->request->getPost('id_tipe_iklan_utama');


        $idMarketing = $this->request->getPost('id_marketing');
        $jenis = $this->request->getPost('jenis');
        $rentangBulan = $this->request->getPost('rentang_bulan');


        $totalHarga = $this->request->getPost('total_harga');
        $cleanTotalHarga = floatval(str_replace([',', ' '], '', $totalHarga));

        // Susun data yang akan disimpan
        $data = [
            'id_tipe_iklan_utama'      => $idTipeIklanUtama,
            'id_marketing'    => $idMarketing,
            'jenis'        => $jenis,
            'rentang_bulan'        => $rentangBulan,
            'status'        => 'diajukan',
            'total_harga'        => $cleanTotalHarga,
            'tanggal_pengajuan' => date('Y-m-d'),
        ];

        // Simpan ke database
        $this->iklanUtamaModel->insert($data);
        $this->tipeIklanUtamaModel->update($idTipeIklanUtama, [
            'status' => 'tidak'
        ]);

        return redirect()->to(base_url('marketing/iklanutama'))->with('success', 'Pengajuan iklan berhasil disimpan.');
    }
}
