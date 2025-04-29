<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArtikelIklanModel;
use App\Models\ArtikelModel;
use App\Models\TempatWisataModel;
use App\Models\OlehOlehModel;
use App\Models\HargaIklanModel;
use Config\Services;

class IklanController extends BaseController
{
    protected $artikelIklanModel;
    protected $artikelModel;
    protected $wisataModel;
    protected $olehOlehModel;
    protected $hargaIklanModel;

    public function __construct()
    {
        $this->artikelIklanModel = new ArtikelIklanModel();
        $this->artikelModel = new ArtikelModel();
        $this->wisataModel = new TempatWisataModel();
        $this->olehOlehModel = new OlehOlehModel();
        $this->hargaIklanModel = new HargaIklanModel();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $all_data = $this->artikelIklanModel->getArtikelIklanByDateFilter($startDate, $endDate) ?? [];

        foreach ($all_data as &$iklan) {
            $judul = 'Tidak ditemukan';

            switch ($iklan['tipe_content']) {
                case 'artikel':
                    $data = $this->artikelModel->find($iklan['id_content']);
                    $judul = $data->judul_artikel ?? $judul;

                    break;

                case 'wisata':
                    $data = $this->wisataModel->find($iklan['id_content']);
                    $judul = $data['nama_wisata_ind'] ?? $judul;
                    break;

                case 'oleholeh':
                    $data = $this->olehOlehModel->find($iklan['id_content']);
                    $judul = $data['nama_oleholeh'] ?? $judul;
                    break;
            }

            $iklan['judul_konten'] = $judul;
        }

        return view('admin/artikel/artikel_iklan', [
            'all_data' => $all_data,
            'validation' => Services::validation(),
        ]);
    }

    public function tambah_artikel_iklan()
    {
        $data = [
            'artikel'    => $this->artikelModel->findAll(),
            'wisata'     => $this->wisataModel->findAll(),
            'oleholeh'   => $this->olehOlehModel->findAll(),
            'harga_iklan' => $this->hargaIklanModel->findAll(),
        ];

        return view('admin/artikel/tambah_artikel_iklan', $data);
    }

    public function proses_tambah()
    {


        // $idPenulis = session()->get('id_user');
        // if (!$idPenulis) {
        //     return redirect()->back()->with('error', 'User tidak ditemukan dalam sesi.');
        // }

        $idHargaIklan = $this->request->getPost('id_harga_iklan');
        $hargaData = $this->hargaIklanModel->find($idHargaIklan);

        if (!$hargaData) {
            return redirect()->back()->with('error', 'Harga iklan tidak ditemukan.');
        }

        $rentangBulan = $this->request->getPost('rentang_bulan');
        $tipeContent = $this->request->getPost('tipe_content');
        $idContent = $this->request->getPost('id_content');
        $totalHargaFix = $this->request->getPost('total_harga');
        $totalHargaFix = floatval(preg_replace('/[^\d]/', '', $totalHargaFix));


        // Validasi konten
        $modelMap = [
            'artikel'    => $this->artikelModel,
            'tempatwisata'     => $this->wisataModel,
            'oleholeh'  => $this->olehOlehModel,
        ];

        if (!isset($modelMap[$tipeContent]) || !$modelMap[$tipeContent]->find($idContent)) {
            return redirect()->back()->with('error', ucfirst($tipeContent) . ' tidak ditemukan.');
        }

        // Susun data yang akan disimpan
        $data = [
            'id_content'        => $idContent,
            'tipe_content'      => $tipeContent,
            'id_harga_iklan'    => $idHargaIklan,
            'id_marketing'      => 1,
            // 'id_marketing'      => $idPenulis,
            'rentang_bulan'     => $rentangBulan,
            'total_harga'       => $totalHargaFix,
            'tanggal_pengajuan' => date('Y-m-d'),
            'status_iklan'      => 'diajukan',
            'catatan_admin'     => $this->request->getPost('catatan_admin'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        // Simpan ke database pakai model
        if ($this->artikelIklanModel->insert($data)) {
            return redirect()->to(base_url('admin/artikel/artikel_beriklan'))->with('success', 'Pengajuan iklan berhasil disimpan.');
        } else {
            // Ambil error jika insert gagal
            $errors = $this->artikelIklanModel->errors();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . implode(', ', $errors));
        }
    }
}
