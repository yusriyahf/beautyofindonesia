<?php

namespace App\Controllers\admin;

use App\Models\komisiUser;
use App\Models\KomisiUserModel;
use App\Models\PemasukanUserModel;
use App\Models\PenarikanUserModel;
use App\Models\SaldoModel;

class Komisi extends BaseController
{
    private $komisiUser;
    private $penarikanSaldo;
    private $pemasukanSaldo;
    private $saldoModel;

    public function __construct()
    {
        $this->komisiUser = new KomisiUserModel();
        $this->penarikanSaldo = new PenarikanUserModel();
        $this->pemasukanSaldo = new PemasukanUserModel();
        $this->saldoModel = new SaldoModel();
    }

    public function saldo($user_id = null)
    {
        if ($user_id === null) {
            return redirect()->to('/');
        }

        $model = new SaldoModel();

        $saldo = $model->where('user_id', $user_id)->first();

        if (!$saldo) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Saldo untuk user ID $user_id tidak ditemukan.");
        }

        $all_data_pemasukan_saldo = $this->pemasukanSaldo->findAll();
        foreach ($all_data_pemasukan_saldo as &$pemasukan) {
            $pemasukan['tipe'] = 'pemasukan';
            $pemasukan['tanggal'] = $pemasukan['tanggal_pemasukan'];
        }

        // Ambil data penarikan dan tambahkan field tipe
        $all_data_penarikan_saldo = $this->penarikanSaldo->findAll();
        foreach ($all_data_penarikan_saldo as &$penarikan) {
            $penarikan['tipe'] = 'penarikan';
            $penarikan['tanggal'] = $penarikan['tanggal_pengajuan'];
        }

        // Gabungkan kedua array
        $semua_transaksi = array_merge($all_data_pemasukan_saldo, $all_data_penarikan_saldo);

        // Urutkan berdasarkan tanggal terbaru
        usort($semua_transaksi, function ($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });


        // Kirim data ke view dalam bentuk array terpisah
        return view('saldo/index', [
            'saldo' => $saldo,
            'semua_transaksi' => $semua_transaksi,
        ]);
    }


    public function penarikan()
    {
        $validation = \Config\Services::validation();

        return view('saldo/penarikan', [
            'validation' => $validation
        ]);
    }

    public function proses_penarikan()
    {
        $jumlah = $this->request->getPost('jumlah');
        $status = $this->request->getPost('status');
        $tanggalPengajuan = $this->request->getPost('tanggal_pengajuan');
        $user_id = 2;

        // validasi jika perlu
        if ($jumlah <= 0) {
            return redirect()->back()->withInput()->with('error', 'Jumlah tidak valid');
        }

        // Simpan ke database
        $this->penarikanSaldo->save([
            'user_id' => $user_id,
            'jumlah' => $jumlah,
            'status' => $status,
            'tanggal_pengajuan' => $tanggalPengajuan
        ]);

        return redirect()->to('admin/saldo/2')->with('success', 'Pengajuan berhasil dikirim');
    }



    public function index()
    {
        $all_data_popup = $this->komisiUser->findAll();
        $validation = \Config\Services::validation();
        return view('admin/popup/index', [
            'all_data_popup' => $all_data_popup,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $listPopup = $this->komisiUser->asObject()->findAll();

        $validation = \Config\Services::validation();

        return view('admin/popup/tambah', [
            'listPopup' => $listPopup,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $foto = $this->request->getFile('foto_popup');

        // Validasi input termasuk file gambar
        if (!$this->validate([
            'foto_popup' => [
                'rules' => 'uploaded[foto_popup]|is_image[foto_popup]|mime_in[foto_popup,image/jpg,image/jpeg,image/png]|max_size[foto_popup,2048]',
                'errors' => [
                    'uploaded' => 'Foto popup wajib diunggah',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format gambar harus jpg, jpeg, atau png',
                    'max_size' => 'Ukuran maksimal gambar adalah 2MB'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Proses upload gambar jika valid
        if ($foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/popups', $namaFoto);
        } else {
            $namaFoto = null;
        }

        $data = [
            'nama_popup' => $this->request->getVar("nama_popup"),
            'title_popup' => $this->request->getVar("title_popup"),
            'link_popup' => $this->request->getVar("link_popup"),
            'nama_tombol' => $this->request->getVar("nama_tombol"),
            'foto_popup' => $namaFoto,
        ];

        $this->komisiUser->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/popup'));
    }


    public function edit($id_popup)
    {
        $popup = $this->komisiUser->asObject()->find($id_popup);

        $validation = \Config\Services::validation();

        return view('admin/popup/edit', [
            'popup' => $popup,
            'validation' => $validation
        ]);
    }

    // Artikel.php (Controller)
    public function proses_edit($id_popup = null)
    {
        $popupData = $this->komisiUser->find($id_popup);

        if (!$popupData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $foto = $this->request->getFile('foto_popup');

        // Validasi jika ada file yang diunggah
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!$this->validate([
                'foto_popup' => [
                    'rules' => 'is_image[foto_popup]|mime_in[foto_popup,image/jpg,image/jpeg,image/png]|max_size[foto_popup,2048]',
                    'errors' => [
                        'is_image' => 'File harus berupa gambar',
                        'mime_in' => 'Format gambar harus jpg, jpeg, atau png',
                        'max_size' => 'Ukuran maksimal gambar adalah 2MB'
                    ]
                ]
            ])) {
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }

            // Hapus gambar lama jika ada
            if ($popupData['foto_popup'] && file_exists('uploads/popups/' . $popupData['foto_popup'])) {
                unlink('uploads/popups/' . $popupData['foto_popup']);
            }

            // Simpan gambar baru
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/popups', $namaFoto);
        } else {
            // Gunakan gambar lama jika tidak ada yang baru diunggah
            $namaFoto = $popupData['foto_popup'];
        }

        // Simpan data ke database
        $data = [
            'nama_popup' => $this->request->getPost("nama_popup"),
            'title_popup' => $this->request->getPost("title_popup"),
            'link_popup' => $this->request->getPost("link_popup"),
            'nama_tombol' => $this->request->getPost("nama_tombol"),
            'foto_popup' => $namaFoto,
        ];

        $this->komisiUser->update($id_popup, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to(base_url('admin/popup'));
    }

    public function delete($id = false)
    {
        // Cari data popup berdasarkan ID
        $popupData = $this->komisiUser->asObject()->find($id);

        if (!$popupData) {
            session()->setFlashdata('error', 'Data Popup tidak ditemukan');
            return redirect()->to(base_url('admin/popup'));
        }

        // Hapus gambar jika ada
        if ($popupData->foto_popup && file_exists('uploads/popups/' . $popupData->foto_popup)) {
            unlink('uploads/popups/' . $popupData->foto_popup);
        }

        // Hapus data dari database
        $this->komisiUser->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('admin/popup'));
    }
}
