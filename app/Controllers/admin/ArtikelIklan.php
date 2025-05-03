<?php

namespace App\Controllers\admin;

use App\Models\ArtikelIklanModel;
use App\Models\ArtikelModel;
use App\Models\HargaIklanModel;
use App\Models\OlehOlehModel;
use App\Models\PemasukanUserModel;
use App\Models\TempatWisataModel;
use App\Models\UserModel;

class ArtikelIklan extends BaseController
{
    protected $artikelIklanModel;
    protected $artikelModel;
    protected $wisataModel;
    protected $olehOlehModel;
    protected $hargaIklanModel;
    protected $UserModel;
    protected $PemasukanUserModel;

    public function __construct()
    {
        $this->artikelIklanModel = new ArtikelIklanModel();
        $this->artikelModel = new ArtikelModel();
        $this->wisataModel = new TempatWisataModel();
        $this->olehOlehModel = new OlehOlehModel();
        $this->hargaIklanModel = new HargaIklanModel();
        $this->UserModel = new UserModel();
        $this->PemasukanUserModel = new PemasukanUserModel();
    }

    public function index()
    {
        $all_data = $this->artikelIklanModel->getArtikelIklan();
        $validation = \Config\Services::validation();
        foreach ($all_data as &$iklan) {
            $judul = 'Tidak ditemukan';

            switch ($iklan['tipe_content']) {
                case 'artikel':
                    $data = $this->artikelModel->find($iklan['id_content']);
                    $judul = $data->judul_artikel ?? $judul;

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
            $user = $this->UserModel->find($iklan['id_marketing']);
            $iklan['username'] = $user['username'] ?? 'Tidak ditemukan';
        }
        return view('admin/artikel_iklan/index', [
            'all_data_artikeliklan' => $all_data,
            'validation' => $validation
        ]);
    }

    public function tambah()
    {
        $listPopup = $this->artikelIklanModel->asObject()->findAll();

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

        $this->artikelIklanModel->save($data);

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to(base_url('admin/popup'));
    }


    public function edit($id_popup)
    {
        $popup = $this->artikelIklanModel->asObject()->find($id_popup);

        $validation = \Config\Services::validation();

        return view('admin/popup/edit', [
            'popup' => $popup,
            'validation' => $validation
        ]);
    }

    // Artikel.php (Controller)
    public function proses_edit($id_popup = null)
    {
        $popupData = $this->artikelIklanModel->find($id_popup);

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

        $this->artikelIklanModel->update($id_popup, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to(base_url('admin/popup'));
    }

    public function delete($id = false)
    {
        // Cari data popup berdasarkan ID
        $popupData = $this->artikelIklanModel->asObject()->find($id);

        if (!$popupData) {
            session()->setFlashdata('error', 'Data Popup tidak ditemukan');
            return redirect()->to(base_url('admin/popup'));
        }

        // Hapus gambar jika ada
        if ($popupData->foto_popup && file_exists('uploads/popups/' . $popupData->foto_popup)) {
            unlink('uploads/popups/' . $popupData->foto_popup);
        }

        // Hapus data dari database
        $this->artikelIklanModel->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('admin/popup'));
    }

    public function ubahStatus()
    {
        $id = $this->request->getPost('id'); // id dari tb_artikel_iklan
        $status = $this->request->getPost('status_iklan'); // disetujui / ditolak
        $nama_iklan = $this->request->getPost('nama_iklan'); // Iklan Banner / Iklan Sidebar / Iklan Footer
        $id_artikel = $this->request->getPost('id_content'); // id artikel terkait
        $tanggal_mulai = $this->request->getPost('tanggal_mulai'); // tanggal mulai iklan (user input)
        $durasi_bulan = (int) $this->request->getPost('durasi_bulan'); // durasi bulan (user input)

        // Mapping nama_iklan ke kolom database
        $mapping = [
            'Iklan Banner' => 'iklan_banner',
            'Iklan Sidebar' => 'iklan_sidebar',
            'Iklan Footer' => 'iklan_footer'
        ];

        // Validasi status
        if (!in_array($status, ['diterima', 'ditolak'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        // Data yang mau diupdate di tb_artikel_iklan
        $dataIklan = [
            'status_iklan' => $status
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

            $this->PemasukanUserModel->insert($dataPemasukan);
        } else {
            // Kalau ditolak, kosongkan tanggal_mulai dan tanggal_selesai
            $dataIklan['tanggal_mulai'] = null;
            $dataIklan['tanggal_selesai'] = null;
        }

        // Update status iklan di tb_artikel_iklan
        $this->artikelIklanModel->update($id, $dataIklan);

        // Validasi nama_iklan hanya jika statusnya 'ditolak' atau 'diterima'
        if (!array_key_exists($nama_iklan, $mapping)) {
            return redirect()->back()->with('error', 'Nama iklan tidak valid.');
        }

        // Tentukan kolom yang akan diubah
        $kolomIklan = $mapping[$nama_iklan];

        // Ubah kolom iklan di tb_artikel berdasarkan id_artikel
        $this->artikelModel->update($id_artikel, [
            $kolomIklan => $status === 'diterima' ? 'tidak' : 'ada'
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }


    // public function tambah()
    // {
    //     $listPopup = $this->artikelIklanModel->asObject()->findAll();

    //     $validation = \Config\Services::validation();

    //     return view('admin/popup/tambah', [
    //         'listPopup' => $listPopup,
    //         'validation' => $validation
    //     ]);
    // }

    // public function proses_tambah()
    // {
    //     $foto = $this->request->getFile('foto_popup');

    //     // Validasi input termasuk file gambar
    //     if (!$this->validate([
    //         'foto_popup' => [
    //             'rules' => 'uploaded[foto_popup]|is_image[foto_popup]|mime_in[foto_popup,image/jpg,image/jpeg,image/png]|max_size[foto_popup,2048]',
    //             'errors' => [
    //                 'uploaded' => 'Foto popup wajib diunggah',
    //                 'is_image' => 'File harus berupa gambar',
    //                 'mime_in' => 'Format gambar harus jpg, jpeg, atau png',
    //                 'max_size' => 'Ukuran maksimal gambar adalah 2MB'
    //             ]
    //         ]
    //     ])) {
    //         return redirect()->back()->withInput()->with('validation', $this->validator);
    //     }

    //     // Proses upload gambar jika valid
    //     if ($foto->isValid() && !$foto->hasMoved()) {
    //         $namaFoto = $foto->getRandomName();
    //         $foto->move('uploads/popups', $namaFoto);
    //     } else {
    //         $namaFoto = null;
    //     }

    //     $data = [
    //         'nama_popup' => $this->request->getVar("nama_popup"),
    //         'title_popup' => $this->request->getVar("title_popup"),
    //         'link_popup' => $this->request->getVar("link_popup"),
    //         'nama_tombol' => $this->request->getVar("nama_tombol"),
    //         'foto_popup' => $namaFoto,
    //     ];

    //     $this->artikelIklanModel->save($data);

    //     session()->setFlashdata('success', 'Data berhasil disimpan');
    //     return redirect()->to(base_url('admin/popup'));
    // }


    // public function edit($id_popup)
    // {
    //     $popup = $this->artikelIklanModel->asObject()->find($id_popup);

    //     $validation = \Config\Services::validation();

    //     return view('admin/popup/edit', [
    //         'popup' => $popup,
    //         'validation' => $validation
    //     ]);
    // }

    // // Artikel.php (Controller)
    // public function proses_edit($id_popup = null)
    // {
    //     $popupData = $this->artikelIklanModel->find($id_popup);

    //     if (!$popupData) {
    //         return redirect()->back()->with('error', 'Data tidak ditemukan');
    //     }

    //     $foto = $this->request->getFile('foto_popup');

    //     // Validasi jika ada file yang diunggah
    //     if ($foto && $foto->isValid() && !$foto->hasMoved()) {
    //         if (!$this->validate([
    //             'foto_popup' => [
    //                 'rules' => 'is_image[foto_popup]|mime_in[foto_popup,image/jpg,image/jpeg,image/png]|max_size[foto_popup,2048]',
    //                 'errors' => [
    //                     'is_image' => 'File harus berupa gambar',
    //                     'mime_in' => 'Format gambar harus jpg, jpeg, atau png',
    //                     'max_size' => 'Ukuran maksimal gambar adalah 2MB'
    //                 ]
    //             ]
    //         ])) {
    //             return redirect()->back()->withInput()->with('validation', $this->validator);
    //         }

    //         // Hapus gambar lama jika ada
    //         if ($popupData['foto_popup'] && file_exists('uploads/popups/' . $popupData['foto_popup'])) {
    //             unlink('uploads/popups/' . $popupData['foto_popup']);
    //         }

    //         // Simpan gambar baru
    //         $namaFoto = $foto->getRandomName();
    //         $foto->move('uploads/popups', $namaFoto);
    //     } else {
    //         // Gunakan gambar lama jika tidak ada yang baru diunggah
    //         $namaFoto = $popupData['foto_popup'];
    //     }

    //     // Simpan data ke database
    //     $data = [
    //         'nama_popup' => $this->request->getPost("nama_popup"),
    //         'title_popup' => $this->request->getPost("title_popup"),
    //         'link_popup' => $this->request->getPost("link_popup"),
    //         'nama_tombol' => $this->request->getPost("nama_tombol"),
    //         'foto_popup' => $namaFoto,
    //     ];

    //     $this->artikelIklanModel->update($id_popup, $data);

    //     session()->setFlashdata('success', 'Data berhasil diperbarui');
    //     return redirect()->to(base_url('admin/popup'));
    // }

    // public function delete($id = false)
    // {
    //     // Cari data popup berdasarkan ID
    //     $popupData = $this->artikelIklanModel->asObject()->find($id);

    //     if (!$popupData) {
    //         session()->setFlashdata('error', 'Data Popup tidak ditemukan');
    //         return redirect()->to(base_url('admin/popup'));
    //     }

    //     // Hapus gambar jika ada
    //     if ($popupData->foto_popup && file_exists('uploads/popups/' . $popupData->foto_popup)) {
    //         unlink('uploads/popups/' . $popupData->foto_popup);
    //     }

    //     // Hapus data dari database
    //     $this->artikelIklanModel->delete($id);

    //     session()->setFlashdata('success', 'Data berhasil dihapus');
    //     return redirect()->to(base_url('admin/popup'));
    // }






    // public function ubahStatus()
    // {
    //     $id = $this->request->getPost('id');
    //     $status = $this->request->getPost('status');
    //     $nama_iklan = $this->request->getPost('nama_iklan');
    //     $id_content = $this->request->getPost('id_content');

    //     // Validasi status
    //     if (!in_array($status, ['disetujui', 'ditolak'])) {
    //         return redirect()->back()->with('error', 'Status tidak valid.');
    //     }
    //     $this->artikelIklanModel->update($id, ['status' => $status]);

    //     $this->Artikel->update();

    //     return redirect()->back()->with('success', 'Status berhasil diubah.');
    // }

    // public function ubahStatus1()
    // {
    //     $id = $this->request->getPost('id');
    //     $status = $this->request->getPost('status');
    //     $status = $this->request->getPost('status');
    //     $id_content = $this->request->getPost('id_content');

    //     // Validasi status
    //     if (!in_array($status, ['disetujui', 'ditolak'])) {
    //         return redirect()->back()->with('error', 'Status tidak valid.');
    //     }

    //     // Ambil artikel
    //     $artikel = $this->artikelIklanModel->find($id);
    //     if (!$artikel) {
    //         return redirect()->back()->with('error', 'Artikel tidak ditemukan.');
    //     }

    //     // Ambil iklan yang berelasi (anggap kamu punya kolom 'id_iklan' atau relasi pivot)
    //     $iklanModel = new \App\Models\IklanModel(); // pastikan modelnya sesuai
    //     $relasiIklan = $iklanModel->where('id_content', $id)->findAll(); // sesuaikan jika nama kolom beda

    //     // Siapkan update iklan
    //     $updateData = ['status' => $status];

    //     foreach ($relasiIklan as $iklan) {
    //         $nama = strtolower($iklan['nama']);
    //         if (str_contains($nama, 'banner')) {
    //             $updateData['iklan_banner'] = 'ada';
    //         }
    //         if (str_contains($nama, 'sidebar')) {
    //             $updateData['iklan_sidebar'] = 'ada';
    //         }
    //         if (str_contains($nama, 'footer')) {
    //             $updateData['iklan_footer'] = 'ada';
    //         }
    //     }

    //     $this->artikelIklanModel->update($id, $updateData);

    //     return redirect()->back()->with('success', 'Status berhasil diubah.');
    // }
}
