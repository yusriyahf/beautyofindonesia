<?php

namespace App\Controllers\Admin;

use App\Models\ArtikelIklanModel;
use App\Models\ArtikelModel;
use App\Models\HargaIklanModel;
use App\Models\KomisiModel;
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
    protected $komisiIklanModel;
    protected $komisiModel;
    protected $PemasukanKomisiModel;

    public function __construct()
    {
        $this->artikelIklanModel = new ArtikelIklanModel();
        $this->artikelModel = new ArtikelModel();
        $this->wisataModel = new TempatWisataModel();
        $this->olehOlehModel = new OlehOlehModel();
        $this->hargaIklanModel = new HargaIklanModel();
        $this->UserModel = new UserModel();
        $this->komisiIklanModel = new \App\Models\KomisiIklanModel();
        $this->komisiModel = new \App\Models\KomisiModel();
        $this->PemasukanKomisiModel = new PemasukanUserModel();
    }

    public function index()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $status = $this->request->getGet('status');
        
        $all_data = $this->artikelIklanModel->getArtikelByFilter();
        $validation = \Config\Services::validation();
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
            $user = $this->UserModel->find($iklan['id_marketing']);
            $iklan['username'] = $user['username'] ?? 'Tidak ditemukan';

            $komisiModel = new KomisiModel();
            // Ambil komisi admin (id 1)
            $komisiAdmin = $komisiModel->find(1);
            // Ambil komisi penulis (id 2)
            $komisiPenulis = $komisiModel->find(2);
            // Ambil komisi marketing (id 3)
            $komisiMarketing = $komisiModel->find(3);
        }
        return view('admin/artikel_iklan/index', [
            'all_data_artikeliklan' => $all_data,
            'validation' => $validation,
            'komisiMarketing' => (float)$komisiMarketing['komisi'],
            'komisiPenulis' => (float)$komisiPenulis['komisi'], // Diset 0 sesuai permintaan
            'komisiAdmin' => (float)$komisiAdmin['komisi'],
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

    public function ubahstatus()
    {
        // Validasi CSRF
        if (!$this->validate([
            'id_iklan' => 'required|integer',
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_selesai' => 'required|valid_date',
            'status_iklan' => 'required|in_list[diterima]',
            'total_harga' => 'required|numeric',
            'id_marketing' => 'required|integer',
            'tipe_content' => 'required|in_list[artikel,oleholeh,tempatwisata]',
            'id_content' => 'required|integer'
        ])) {
            return redirect()->back()->with('error', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $idIklan = $this->request->getPost('id_iklan');
            $status = $this->request->getPost('status');
            $tanggalMulai = $this->request->getPost('tanggal_mulai');
            $tanggalSelesai = $this->request->getPost('tanggal_selesai');
            $totalHarga = floatval($this->request->getPost('total_harga'));
            $idMarketing = $this->request->getPost('id_marketing');
            $tipeContent = $this->request->getPost('tipe_content');
            $idContent = $this->request->getPost('id_content');
            $useCustomCommission = $this->request->getPost('use_custom_commission');

            // 1. Update status iklan dan tanggal
            $updateData = [
                'status_iklan' => 'diterima',
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'diperbarui_pada' => date('Y-m-d H:i:s')
            ];

            if (!$this->artikelIklanModel->update($idIklan, $updateData)) {
                throw new \Exception('Gagal mengupdate status iklan');
            }

            // 2. Handle komisi custom jika dipilih
            if ($status == 'diterima') {
            if ($useCustomCommission == '1') {
                $komisiMarketing = floatval($this->request->getPost('komisi_marketing') ?? 0);
                $komisiPenulis = floatval($this->request->getPost('komisi_penulis') ?? 0);
                $komisiAdmin = floatval($this->request->getPost('komisi_admin') ?? 0);

                // Validasi total komisi tidak lebih dari 100%
                $totalKomisiPersen = $komisiMarketing + $komisiPenulis + $komisiAdmin;
                if ($totalKomisiPersen > 100) {
                    throw new \Exception('Total komisi tidak boleh melebihi 100%');
                }

                // Dapatkan user ID untuk masing-masing peran
                $penulisId = $this->getPenulisId($tipeContent, $idContent);
                $adminId = $this->getAdminId();

                // Validasi apakah semua user ID ditemukan
                if (!$penulisId) {
                    throw new \Exception("Penulis tidak ditemukan untuk {$tipeContent} ID: {$idContent}");
                }

                if (!$adminId) {
                    throw new \Exception("Admin tidak ditemukan");
                }

                // Simpan komisi custom ke tb_komisi_iklan
                $komisiData = [
                    [
                        'id_iklan' => (int)$idIklan,
                        'id_user' => (int)$idMarketing, // Marketing user
                        'tipe_iklan' => 'konten',
                        'peran' => 'marketing',
                        'persen' => (int)$komisiMarketing,
                        'jumlah_komisi' => (int)round($totalHarga * $komisiMarketing / 100),
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'id_iklan' => (int)$idIklan,
                        'id_user' => (int)$penulisId, // Penulis user
                        'tipe_iklan' => 'konten',
                        'peran' => 'penulis',
                        'persen' => (int)$komisiPenulis,
                        'jumlah_komisi' => (int)round($totalHarga * $komisiPenulis / 100),
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'id_iklan' => (int)$idIklan,
                        'id_user' => (int)$adminId, // Admin user
                        'tipe_iklan' => 'konten',
                        'peran' => 'admin',
                        'persen' => (int)$komisiAdmin,
                        'jumlah_komisi' => (int)round($totalHarga * $komisiAdmin / 100),
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ];

                // Hapus komisi custom sebelumnya jika ada
                $this->komisiIklanModel->where('id_iklan', $idIklan)->delete();

                // Insert komisi custom baru
                if (!$this->komisiIklanModel->insertBatch($komisiData)) {
                    throw new \Exception('Gagal menyimpan komisi custom');
                }
            }

            // 3. Proses perhitungan dan penyimpanan komisi ke tb_pemasukan_komisi
            $this->prosesKomisiPemasukan($idIklan, $totalHarga, $idMarketing, $tipeContent, $idContent);
        }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaksi database gagal');
            }

            return redirect()->back()->with('success', 'Iklan berhasil disetujui dan komisi telah dihitung');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error in ubahstatus: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function prosesKomisiPemasukan($idIklan, $totalHarga, $idMarketing, $tipeContent, $idContent)
    {
        // Cek apakah ada komisi custom untuk iklan ini
        $komisiCustom = $this->komisiIklanModel->where('id_iklan', $idIklan)->findAll();

        if (!empty($komisiCustom)) {
            // Gunakan komisi custom
            foreach ($komisiCustom as $komisi) {
                $userId = (int)$komisi['id_user'];
                if ($userId === 0) {
                    throw new \Exception("user_id kosong atau 0 untuk peran: {$komisi['peran']}");
                }

                $pemasukanData = [
                    'user_id' => $userId,
                    'jumlah' => (int)$komisi['jumlah_komisi'],
                    'status' => 'disetujui',
                    'tanggal_pemasukan' => date('Y-m-d H:i:s'),
                    'keterangan' => "Komisi {$komisi['peran']} untuk iklan ID: {$idIklan} ({$komisi['persen']}%)",
                    'id_iklan' => (int)$idIklan,
                    'jenis_komisi' => $komisi['peran']
                ];

                if (!$this->PemasukanKomisiModel->insert($pemasukanData)) {
                    throw new \Exception("Gagal menyimpan komisi {$komisi['peran']} - user_id: {$userId}");
                }
            }
        } else {
            // Gunakan komisi default
            $komisiDefault = $this->komisiModel->findAll();
            $komisiMap = [];

            foreach ($komisiDefault as $komisi) {
                $komisiMap[$komisi['id']] = $komisi['komisi'];
            }

            // Hitung komisi berdasarkan nilai default
            $komisiMarketing = isset($komisiMap['3']) ? $komisiMap['1'] : 0;
            $komisiPenulis = isset($komisiMap['2']) ? $komisiMap['2'] : 0;
            $komisiAdmin = isset($komisiMap['1']) ? $komisiMap['3'] : 0;

            $komisiData = [
                'marketing' => [
                    'id_user' => (int)$idMarketing,
                    'persen' => (int)$komisiMarketing,
                    'jumlah' => (int)round($totalHarga * $komisiMarketing / 100)
                ],
                'penulis' => [
                    'id_user' => (int)$this->getPenulisId($tipeContent, $idContent),
                    'persen' => (int)$komisiPenulis,
                    'jumlah' => (int)round($totalHarga * $komisiPenulis / 100)
                ],
                'admin' => [
                    'id_user' => (int)$this->getAdminId(),
                    'persen' => (int)$komisiAdmin,
                    'jumlah' => (int)round($totalHarga * $komisiAdmin / 100)
                ]
            ];

            foreach ($komisiData as $peran => $data) {
                if ($data['id_user']) {
                    date_default_timezone_set('Asia/Jakarta');
                    $pemasukanData = [
                        'user_id' => $data['id_user'],
                        'jumlah' => $data['jumlah'],
                        'status' => 'disetujui',
                        'tanggal_pemasukan' => date('Y-m-d H:i:s'),
                        'keterangan' => "Komisi {$peran} untuk iklan ID: {$idIklan} ({$data['persen']}%)",
                        'id_iklan' => (int)$idIklan,
                        'tipe_iklan' => 'konten',
                    ];

                    if (!$this->PemasukanKomisiModel->insert($pemasukanData)) {
                        throw new \Exception("Gagal menyimpan komisi {$peran}");
                    }
                }
            }
        }
    }

    private function getPenulisId($tipeContent, $idContent)
    {
        $db = \Config\Database::connect();

        try {
            $query = false;

            switch ($tipeContent) {
                case 'artikel':
                    $query = $db->query("SELECT id_penulis FROM tb_artikel WHERE id_artikel = ?", [$idContent]);
                    break;

                case 'oleholeh':
                    $query = $db->query("SELECT id_penulis FROM tb_oleholeh WHERE id_oleholeh = ?", [$idContent]);
                    break;

                case 'tempatwisata':
                    $query = $db->query("SELECT id_penulis FROM tb_tempatwisata WHERE id_tempat_wisata = ?", [$idContent]);
                    break;

                default:
                    log_message('warning', "Invalid tipe_content: {$tipeContent}");
                    return null;
            }

            // Cek apakah query berhasil
            if ($query === false) {
                log_message('error', "Database query failed for tipe_content: {$tipeContent}, id_content: {$idContent}");
                log_message('error', "Database error: " . $db->error()['message']);
                return null;
            }

            $result = $query->getRow();

            if (!$result) {
                log_message('warning', "No content found for tipe_content: {$tipeContent}, id_content: {$idContent}");
                return null;
            }

            // Perbaikan: menggunakan id_user (bukan id_user)
            if (!isset($result->id_penulis)) {
                log_message('error', "Field id_user not found in table for tipe_content: {$tipeContent}");
                return null;
            }

            return (int)$result->id_penulis;
        } catch (\Exception $e) {
            log_message('error', 'Error getting penulis ID: ' . $e->getMessage());
            log_message('error', 'Trace: ' . $e->getTraceAsString());
            return null;
        }
    }

    private function getAdminId()
    {
        try {
            // Ambil ID user dari session yang sedang login
            $session = session();
            $adminId = $session->get('id_user'); // atau sesuaikan dengan nama key session Anda

            if (!$adminId) {
                // Jika tidak ada di session, coba alternatif key session
                $adminId = $session->get('id_user') ?? $session->get('logged_in_id_user');
            }

            if (!$adminId) {
                log_message('warning', 'No admin ID found in session, using default ID 1');
                return 1; // Default admin ID
            }

            return (int)$adminId;
        } catch (\Exception $e) {
            log_message('error', 'Error getting admin ID from session: ' . $e->getMessage());
            log_message('error', 'Trace: ' . $e->getTraceAsString());
            return 1; // Default admin ID
        }
    }

    // Method untuk mendapatkan marketing ID dari tb_iklan_artikel
    private function getMarketingId($idIklan)
    {
        try {
            $iklan = $this->artikelIklanModel->find($idIklan);

            if (!$iklan) {
                log_message('warning', "Iklan dengan ID {$idIklan} tidak ditemukan");
                return null;
            }

            // Ambil id_marketing dari tb_iklan_artikel
            if (!isset($iklan['id_marketing'])) {
                log_message('error', 'Field id_marketing not found in iklan data');
                return null;
            }

            return (int)$iklan['id_marketing'];
        } catch (\Exception $e) {
            log_message('error', 'Error getting marketing ID: ' . $e->getMessage());
            log_message('error', 'Trace: ' . $e->getTraceAsString());
            return null;
        }
    }

    // Method untuk mendapatkan data komisi (untuk API atau AJAX)
    public function getKomisiData($idIklan)
    {
        try {
            $komisiCustom = $this->komisiIklanModel->where('id_iklan', $idIklan)->findAll();

            if (!empty($komisiCustom)) {
                $result = [];
                foreach ($komisiCustom as $komisi) {
                    $result[$komisi['peran']] = [
                        'persen' => (int)$komisi['persen'],
                        'jumlah' => (int)$komisi['jumlah_komisi'],
                        'id_user' => (int)$komisi['id_user']
                    ];
                }
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $result,
                    'type' => 'custom'
                ]);
            } else {
                $komisiDefault = $this->komisiModel->findAll();
                $result = [];
                foreach ($komisiDefault as $komisi) {
                    $result[$komisi['nama']] = [
                        'persen' => (int)$komisi['komisi']
                    ];
                }
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $result,
                    'type' => 'default'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function tolakIklan()
    {
        // Validasi CSRF dan hanya membutuhkan id_iklan dan status_iklan
        if (!$this->validate([
            'id_iklan' => 'required|integer',
            'status_iklan' => 'required|in_list[ditolak]'
        ])) {
            return redirect()->back()->with('error', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $idIklan = $this->request->getPost('id_iklan');
            $alasanPenolakan = $this->request->getPost('alasan_penolakan') ?? 'Tidak disebutkan';

            // 1. Update status iklan menjadi ditolak
            $updateData = [
                'status_iklan' => 'ditolak',
                'alasan_penolakan' => $alasanPenolakan,
                'diperbarui_pada' => date('Y-m-d H:i:s')
            ];

            if (!$this->artikelIklanModel->update($idIklan, $updateData)) {
                throw new \Exception('Gagal mengupdate status iklan');
            }

            // 2. Hapus komisi yang mungkin sudah dibuat sebelumnya (jika ada)
            $this->komisiIklanModel->where('id_iklan', $idIklan)->delete();

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaksi database gagal');
            }

            return redirect()->back()->with('success', 'Iklan berhasil ditolak');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error in tolakIklan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    
}
