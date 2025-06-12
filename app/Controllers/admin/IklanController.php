<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArtikelIklanModel;
use App\Models\ArtikelModel;
use App\Models\TempatWisataModel;
use App\Models\OlehOlehModel;
use App\Models\HargaIklanModel;
use App\Models\UserModel;
use App\Models\UsersModel;
use Config\Services;

class IklanController extends BaseController
{
    protected $artikelIklanModel;
    protected $artikelModel;
    protected $wisataModel;
    protected $olehOlehModel;
    protected $hargaIklanModel;
    protected $UsersModel;

    public function __construct()
    {
        $this->artikelIklanModel = new ArtikelIklanModel();
        $this->artikelModel = new ArtikelModel();
        $this->wisataModel = new TempatWisataModel();
        $this->olehOlehModel = new OlehOlehModel();
        $this->hargaIklanModel = new HargaIklanModel();
        $this->UsersModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $role = session()->get('role');
        $userId = session()->get('id_user');
        $startDate = $this->request->getGet('created_at');
        $endDate = $this->request->getGet('updated_at');

        // Ambil data berdasarkan role
        if ($role == 'marketing') {
            $all_data = $this->artikelIklanModel->getArtikelIklanByMarketing($userId, $startDate, $endDate) ?? [];
        } elseif ($role == 'penulis') {
            $all_data = $this->artikelIklanModel->getArtikelIklanByPenulis($userId, $startDate, $endDate) ?? [];
        } else {
            $all_data = $this->artikelIklanModel->getArtikelIklanByDateFilter($startDate, $endDate) ?? [];
        }

        foreach ($all_data as &$iklan) {
            $judul = 'Tidak ditemukan';

            switch ($iklan['tipe_content']) {
                case 'artikel':
                    $data = $this->artikelModel->find($iklan['id_content']);
                    $judul = $data['judul_artikel'] ?? $judul;
                    break;

                case 'tempatwisata':
                    $data = $this->wisataModel->find($iklan['id_content']);
                    $judul = $data['nama_wisata_ind'] ?? $judul;
                    break;

                case 'oleholeh':
                    $data = $this->olehOlehModel->find($iklan['id_content']);
                    $judul = $data['nama_oleholeh'] ?? $judul;
                    break;
            }

            $iklan['judul_konten'] = $judul;
            // Ambil nama iklan dari tb_harga_iklan
            $harga = $this->hargaIklanModel->find($iklan['id_harga_iklan']);
            $iklan['nama'] = $harga['nama'] ?? 'Tidak ditemukan';

            // Ambil username dari tb_users
            $user = $this->UsersModel->find($iklan['id_marketing']);
            $iklan['username'] = $user['username'] ?? 'Tidak ditemukan';
        }

        // dd($all_data);

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
        $idMarketing = session()->get('id_user');
        if (!$idMarketing) {
            return redirect()->back()->with('error', 'User tidak ditemukan dalam sesi.');
        }

        // Validasi input
        $validation = Services::validation();
        $validation->setRules([
            'id_harga_iklan' => 'required',
            'rentang_bulan' => 'required|numeric|greater_than[0]',
            'tipe_content' => 'required',
            'id_content' => 'required',
            'total_harga' => 'required',
            'thumbnail_iklan' => 'uploaded[thumbnail_iklan]|max_size[thumbnail_iklan,2048]|is_image[thumbnail_iklan]',
            'link_iklan' => 'required|valid_url'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

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

        // Handle upload gambar
        $gambar = $this->request->getFile('thumbnail_iklan');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move('assets/images/iklan_konten', $newName);
        } else {
            return redirect()->back()->with('error', 'Gagal mengupload gambar thumbnail iklan.');
        }

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
            'id_marketing'      => $idMarketing,
            'rentang_bulan'     => $rentangBulan,
            'total_harga'       => $totalHargaFix,
            'tanggal_pengajuan' => date('Y-m-d'),
            'thumbnail_iklan'   => $newName,
            'link_iklan'        => $this->request->getPost('link_iklan'),
            'no_pengaju'        => $this->request->getPost('no_pengaju'),
            'status_iklan'      => 'diajukan',
            'catatan_admin'     => $this->request->getPost('catatan_admin'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        // Simpan ke database pakai model
        if ($this->artikelIklanModel->insert($data)) {
            $role = session()->get('role');
            return redirect()->to(base_url($role . '/daftariklankonten'))->with('success', 'Pengajuan iklan berhasil disimpan.');
        } else {
            // Ambil error jika insert gagal
            $errors = $this->artikelIklanModel->errors();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . implode(', ', $errors));
        }
    }

    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Ambil data iklan
        $iklan = $this->artikelIklanModel->find($id);
        if (!$iklan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Ambil semua harga iklan
        $harga_iklan = $this->hargaIklanModel->findAll();

        // Ambil konten sesuai tipe
        $artikel_terpilih = $wisata_terpilih = $oleholeh_terpilih = [];

        switch ($iklan['tipe_content']) {
            case 'artikel':
                $artikel_terpilih = $this->artikelModel->find($iklan['id_content']);
                break;
            case 'tempatwisata':
                $wisata_terpilih = $this->wisataModel->find($iklan['id_content']);
                break;
            case 'oleholeh':
                $oleholeh_terpilih = $this->olehOlehModel->find($iklan['id_content']);
                break;
        }

        // Ambil data marketing
        $marketing = $this->UsersModel->find($iklan['id_marketing']);

        // Kirim ke view
        return view('admin/artikel/edit_artikel_iklan', [
            'iklan' => $iklan,
            'harga_iklan' => $harga_iklan,
            'artikel_terpilih' => $artikel_terpilih,
            'wisata_terpilih' => $wisata_terpilih,
            'oleholeh_terpilih' => $oleholeh_terpilih,
            'marketing' => $marketing,
            'validation' => Services::validation(),
        ]);
    }

    public function proses_edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Validasi input
        $validation = Services::validation();
        $validation->setRules([
            'id_harga_iklan' => 'required',
            'rentang_bulan' => 'required|numeric|greater_than[0]',
            'tipe_content' => 'required',
            'id_content' => 'required',
            'total_harga' => 'required',
            'thumbnail_iklan' => 'if_exist|max_size[thumbnail_iklan,2048]|is_image[thumbnail_iklan]',
            'link_iklan' => 'required|valid_url'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data lama
        $iklanLama = $this->artikelIklanModel->find($id);
        if (!$iklanLama) {
            return redirect()->back()->with('error', 'Data iklan tidak ditemukan.');
        }

        // Ambil data yang dikirim dari form
        $tipeContent = $this->request->getPost('tipe_content');
        $idContent = $this->request->getPost('id_content');
        $idHargaIklan = $this->request->getPost('id_harga_iklan');
        $rentangBulan = $this->request->getPost('rentang_bulan');
        $totalHargaFix = $this->request->getPost('total_harga');
        $totalHargaFix = floatval(preg_replace('/[^\d]/', '', $totalHargaFix));
        $linkIklan = $this->request->getPost('link_iklan');
        $noPengaju = $this->request->getPost('no_pengaju');
        $catatanAdmin = $this->request->getPost('catatan_admin');

        // Handle upload gambar baru jika ada
        $gambar = $this->request->getFile('thumbnail_iklan');
        $newName = $iklanLama['thumbnail_iklan'];

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move('assets/images/iklan_konten', $newName);
            
            // Hapus gambar lama jika ada
            if ($iklanLama['thumbnail_iklan'] && file_exists('assets/images/iklan_konten/' . $iklanLama['thumbnail_iklan'])) {
                unlink('assets/images/iklan_konten/' . $iklanLama['thumbnail_iklan']);
            }
        }

        // Validasi tipe konten
        $modelMap = [
            'artikel'       => $this->artikelModel,
            'tempatwisata'  => $this->wisataModel,
            'oleholeh'      => $this->olehOlehModel,
        ];

        if (!isset($modelMap[$tipeContent]) || !$modelMap[$tipeContent]->find($idContent)) {
            return redirect()->back()->with('error', ucfirst($tipeContent) . ' tidak ditemukan.');
        }

        // Data untuk update
        $dataUpdate = [
            'tipe_content'      => $tipeContent,
            'id_content'        => $idContent,
            'id_harga_iklan'    => $idHargaIklan,
            'rentang_bulan'     => $rentangBulan,
            'total_harga'       => $totalHargaFix,
            'thumbnail_iklan'   => $newName,
            'link_iklan'        => $linkIklan,
            'no_pengaju'        => $noPengaju,
            'catatan_admin'     => $catatanAdmin,
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        // Proses update
        if ($this->artikelIklanModel->update($id, $dataUpdate)) {
            $role = session()->get('role');
            return redirect()->to(base_url($role . '/daftariklankonten'))->with('success', 'Data iklan berhasil diperbarui.');
        } else {
            // Ambil error jika update gagal
            $errors = $this->artikelIklanModel->errors();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . implode(', ', $errors));
        }
    }

    public function detail($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Ambil data iklan berdasarkan ID
        $iklan = $this->artikelIklanModel->find($id);
        if (!$iklan) {
            return redirect()->back()->with('error', 'Data iklan tidak ditemukan.');
        }

        // Ambil nama konten berdasarkan tipe_content
        $judul = 'Tidak ditemukan';
        switch ($iklan['tipe_content']) {
            case 'artikel':
                $data = $this->artikelModel->find($iklan['id_content']);
                $judul = $data['judul_artikel'] ?? $judul;
                break;
            case 'tempatwisata':
                $data = $this->wisataModel->find($iklan['id_content']);
                $judul = $data['nama_wisata_ind'] ?? $judul;
                break;
            case 'oleholeh':
                $data = $this->olehOlehModel->find($iklan['id_content']);
                $judul = $data['nama_oleholeh'] ?? $judul;
                break;
        }

        $iklan['judul_konten'] = $judul;

        // Ambil nama iklan dari tb_harga_iklan
        $harga = $this->hargaIklanModel->find($iklan['id_harga_iklan']);
        $iklan['nama'] = $harga['nama'] ?? 'Tidak ditemukan';

        // Ambil data user marketing
        $marketing = $this->UsersModel->find($iklan['id_marketing']);
        $iklan['username'] = $marketing['username'] ?? 'Tidak ditemukan';

        // Kirim data ke view
        return view('admin/artikel/detail_artikel_iklan', [
            'iklan' => $iklan,
            'judul_konten' => $judul,
            'harga' => $harga,
            'marketing' => $marketing,
        ]);
    }

    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Cek apakah data iklan ada
        $iklan = $this->artikelIklanModel->find($id);
        if (!$iklan) {
            return redirect()->back()->with('error', 'Data iklan tidak ditemukan.');
        }

        // Hapus gambar thumbnail jika ada
        if ($iklan['thumbnail_iklan'] && file_exists('assets/images/iklan_konten/' . $iklan['thumbnail_iklan'])) {
            unlink('assets/images/iklan_konten/' . $iklan['thumbnail_iklan']);
        }

        // Lakukan penghapusan
        if ($this->artikelIklanModel->delete($id)) {
            return redirect()->to(base_url('marketing/daftariklankonten'))->with('success', 'Data iklan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data iklan.');
        }
    }
}