<?php

namespace App\Controllers\Admin;

use App\Models\IklanUtamaModel;
use App\Models\JenisIklanUtama;
use App\Models\PemasukanUserModel;
use App\Models\TipeIklanUtama;
use App\Models\TipeIklanUtamaModel;
use App\Models\UserModel;

class IklanUtamaController extends BaseController
{

    private $iklanUtamaModel;
    private $tipeIklanUtamaModel;
    private $PemasukanUserModel;
    private $usermodel;

    public function __construct()
    {
        $this->iklanUtamaModel = new IklanUtamaModel();
        $this->tipeIklanUtamaModel = new TipeIklanUtamaModel();
        $this->PemasukanUserModel = new PemasukanUserModel();
        $this->usermodel = new UserModel();
    }

    public function index()
    {
        // $all_data_iklan_utama = $this->iklanUtamaModel->findAll();
        $all_data_iklan_utama = $this->iklanUtamaModel->getAllWithUserAndTipe();


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
        $linkIklan = $this->request->getPost('link_iklan');
        $jenis = $this->request->getPost('jenis');
        $rentangBulan = $this->request->getPost('rentang_bulan');
        $totalHarga = $this->request->getPost('total_harga');
        $cleanTotalHarga = floatval(str_replace([',', ' '], '', $totalHarga));

        $gambar = $this->request->getFile('thumbnail_iklan');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName(); // nama file unik
            $gambar->move('assets/images/iklan_utama', $newName); // simpan ke folder tujuan
        } else {
            return redirect()->back()->with('error', 'Gagal mengupload gambar.');
        }

        // Susun data yang akan disimpan
        $data = [
            'id_tipe_iklan_utama'      => $idTipeIklanUtama,
            'id_marketing'    => $idMarketing,
            'jenis'        => $jenis,
            'rentang_bulan'        => $rentangBulan,
            'status'        => 'diajukan',
            'total_harga'        => $cleanTotalHarga,
            'tanggal_pengajuan' => date('Y-m-d'),
            'link_iklan' => $linkIklan,
            'thumbnail_iklan' => $newName,
        ];

        // Simpan ke database
        $this->iklanUtamaModel->insert($data);
        // $this->tipeIklanUtamaModel->update($idTipeIklanUtama, [
        //     'status' => 'tidak'
        // ]);

        return redirect()->to(base_url('marketing/iklanutama'))->with('success', 'Pengajuan iklan berhasil disimpan.');
    }


    public function ubahStatus()
    {
        $id_iklan_utama = $this->request->getPost('id_iklan_utama');
        $id_tipe_iklan_utama = $this->request->getPost('id_tipe_iklan_utama');
        $status = $this->request->getPost('status');
        $tanggal_mulai = $this->request->getPost('tanggal_mulai');
        $durasi_bulan = (int) $this->request->getPost('durasi_bulan');

        // Validasi status
        if (!in_array($status, ['diterima', 'ditolak'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        // Data yang mau diupdate di tb_artikel_iklan
        $dataIklan = [
            'status' => $status
        ];

        if ($status == 'diterima') {
            if (!$tanggal_mulai || !$durasi_bulan) {
                return redirect()->back()->with('error', 'Tanggal mulai dan durasi bulan wajib diisi.');
            }

            // Hitung tanggal selesai otomatis
            $tanggal_mulai_obj = new \DateTime($tanggal_mulai);
            $tanggal_selesai_obj = clone $tanggal_mulai_obj;
            $tanggal_selesai_obj->modify("+{$durasi_bulan} months");

            $dataIklan['tanggal_mulai'] = $tanggal_mulai_obj->format('Y-m-d');
            $dataIklan['tanggal_selesai'] = $tanggal_selesai_obj->format('Y-m-d');

            // Insert Komisi Pemasukan
            $user_id = $this->request->getPost('user_id');
            $total_harga = (float) $this->request->getPost('total_harga');

            $dataPemasukan = [
                'user_id'    => $user_id,
                'jumlah'    => $total_harga,
                'status'    => 'disetujui',
                'tanggal'    => date('Y-m-d'),
            ];

            $this->tipeIklanUtamaModel->update($id_tipe_iklan_utama, [
                'status' => 'tidak'
            ]);
            $this->iklanUtamaModel->update($id_iklan_utama, [
                'status' => 'diterima',
                'tanggal_mulai' =>  $dataIklan['tanggal_mulai'],
                'tanggal_selesai' =>  $dataIklan['tanggal_selesai'],
            ]);



            $this->PemasukanUserModel->insert($dataPemasukan);
        } else {
            // Kalau ditolak, kosongkan tanggal_mulai dan tanggal_selesai
            $dataIklan['tanggal_mulai'] = null;
            $dataIklan['tanggal_selesai'] = null;
        }

        // Update status iklan di tb_artikel_iklan



        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }

    public function klik($id)
    {
        // Ambil data iklan berdasarkan ID
        $iklan = $this->iklanUtamaModel->find($id);

        if ($iklan) {
            // Update jumlah klik
            $this->iklanUtamaModel->update($id, [
                'jumlah_klik' => $iklan['jumlah_klik'] + 1
            ]);

            // Redirect ke link iklan
            return redirect()->to($iklan['link_iklan']);
        } else {
            // Kalau tidak ditemukan, kembali ke home
            return redirect()->to('/');
        }
    }
}
