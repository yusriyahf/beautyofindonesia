<?php

namespace App\Controllers\Admin;

use App\Models\IklanUtamaModel;
use App\Models\JenisIklanUtama;
use App\Models\KomisiModel;
use App\Models\TipeIklanUtama;
use App\Models\TipeIklanUtamaModel;
use App\Models\UserModel;


class IklanUtamaController extends BaseController
{

    private $iklanUtamaModel;
    private $tipeIklanUtamaModel;
    private $TipeIklanUtama;
    private $UserModel;
    private $komisiIklanModel;
    private $pemasukanKomisiModel;
    private $komisiModel;

    public function __construct()
    {
        $this->iklanUtamaModel = new IklanUtamaModel();
        $this->tipeIklanUtamaModel = new TipeIklanUtamaModel();
        $this->TipeIklanUtama = new \App\Models\TipeIklanUtama();
        $this->UserModel = new UserModel();
        $this->komisiIklanModel = new \App\Models\KomisiIklanModel();
        $this->komisiModel = new KomisiModel();
        $this->pemasukanKomisiModel = new \App\Models\PemasukanUserModel();
    }

    public function index()
    {
        // $all_data_iklan_utama = $this->iklanUtamaModel->findAll();
        $all_data_iklan_utama = $this->iklanUtamaModel->getAllWithUserAndTipe();

        $role = session()->get('role');
        $userId = session()->get('id_user');
        $startDate = $this->request->getGet('created_at');
        $endDate = $this->request->getGet('updated_at');
        $user['username'] = '';

        // Ambil data berdasarkan role
        if ($role == 'marketing') {
            $all_data_iklan_utama = $this->iklanUtamaModel->getArtikelIklanByMarketing($userId, $startDate, $endDate) ?? [];
        }

        // Ambil username dari tb_users
        $userData = $this->UserModel->find($userId);
        $username = $userData['username'] ?? 'Tidak ditemukan';
        foreach ($all_data_iklan_utama as &$iklan) {
            $iklan['username'] = $username;
        }
        $username = $userData['username'] ?? 'Tidak ditemukan';

        $validation = \Config\Services::validation();
        return view('marketing/iklan_utama/index', [
            'all_data_iklan_utama' => $all_data_iklan_utama,
            'username' => $username,
            'validation' => $validation
        ]);
    }

    public function index2()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $status = $this->request->getGet('status');

        $all_data_iklan_utama = $this->iklanUtamaModel->getArtikelByFilter($startDate, $endDate, $status);
        $validation = \Config\Services::validation();
        $komisiModel = new KomisiModel();
        // Ambil komisi admin (id 4)
        $komisiAdmin = $komisiModel->find(4);
        // Ambil komisi marketing (id 5)
        $komisiMarketing = $komisiModel->find(5);
        foreach ($all_data_iklan_utama as $iklan) {
            $harga = $this->TipeIklanUtama->find($iklan['id_tipe_iklan_utama']);
            $iklan['nama'] = $harga['nama'] ?? 'Tidak ditemukan';
        }

        // Ambil data user dari UserModel berdasarkan id_marketing
        $user = $this->UserModel->find($iklan['id_marketing'] ?? 0);

        // Isi nilai default jika user tidak ditemukan
        $infoUser['username'] = $user['username'] ?? 'Tidak ditemukan';
        $infoUser['kontak']   = $user['kontak'] ?? 'Tidak ditemukan';


        $nopengaju = $this->iklanUtamaModel->find($iklan['id_iklan_utama'] ?? 0);
        $infoUser['no_pengaju'] = $nopengaju['no_pengaju'] ?? 'Tidak ditemukan';

        return view('admin/iklan_utama/index', [
            'komisiMarketing' => (float)$komisiMarketing['komisi'],
            'komisiPenulis' => 0, // Diset 0 sesuai permintaan
            'komisiAdmin' => (float)$komisiAdmin['komisi'],
            'all_data_iklan_utama' => $all_data_iklan_utama,
            'validation' => $validation,
            'infoUser' => $infoUser,
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

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id_tipe_iklan_utama' => 'required',
            'rentang_bulan' => 'required|numeric|greater_than[0]',
            'link_iklan' => 'required|valid_url',
            'thumbnail_iklan' => 'uploaded[thumbnail_iklan]|max_size[thumbnail_iklan,2048]|is_image[thumbnail_iklan]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $idTipeIklanUtama = $this->request->getPost('id_tipe_iklan_utama');
        $idMarketing = $this->request->getPost('id_marketing');
        $linkIklan = $this->request->getPost('link_iklan');
        $jenis = $this->request->getPost('jenis');
        $rentangBulan = $this->request->getPost('rentang_bulan');

        // Bersihkan format total harga
        $totalHarga = $this->request->getPost('total_harga');
        $totalHargaFix = floatval(preg_replace('/[^\d]/', '', $totalHarga));

        // Handle upload gambar
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
            'total_harga'        => $totalHargaFix,
            'tanggal_pengajuan' => date('Y-m-d'),
            'link_iklan' => $linkIklan,
            'thumbnail_iklan' => $newName,
            'no_pengaju'        => $this->request->getPost('no_pengaju'),
        ];

        // Simpan ke database
        $this->iklanUtamaModel->insert($data);

        return redirect()->to(base_url('marketing/iklanutama'))->with('success', 'Pengajuan iklan berhasil disimpan.');
    }


    public function ubahStatus()
    {
        if (!$this->validate([
            'id_iklan_utama' => 'required|integer',
            'status' => 'required|in_list[diterima,ditolak]',
            'total_harga' => 'required|numeric',
            'id_tipe_iklan_utama' => 'required|integer'
        ])) {
            return redirect()->back()->with('error', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $idIklan = $this->request->getPost('id_iklan_utama');
            $status = $this->request->getPost('status');
            $tanggalMulai = $this->request->getPost('tanggal_mulai');
            $tanggalSelesai = $this->request->getPost('tanggal_selesai');
            $durasiBulan = (int)$this->request->getPost('durasi_bulan');
            $totalHarga = floatval($this->request->getPost('total_harga'));
            $idMarketing = $this->request->getPost('id_marketing');
            $idTipeIklan = $this->request->getPost('id_tipe_iklan_utama');
            $useCustomCommission = $this->request->getPost('use_custom_commission');

            // 1. Update status iklan dan tanggal
            $updateData = [
                'status' => $status,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                // 'diperbarui_pada' => date('Y-m-d H:i:s')
            ];

            if ($status == 'diterima') {
                // Hitung tanggal selesai
                $tanggalMulaiObj = new \DateTime($tanggalMulai);
                $tanggalSelesaiObj = clone $tanggalMulaiObj;
                $tanggalSelesaiObj->modify("+{$durasiBulan} months");

                $updateData['tanggal_mulai'] = $tanggalMulaiObj->format('Y-m-d');
                $updateData['tanggal_selesai'] = $tanggalSelesaiObj->format('Y-m-d');

                // Update status tipe iklan
                $this->tipeIklanUtamaModel->update($idTipeIklan, ['status' => 'tidak']);
            } else {
                $updateData['tanggal_mulai'] = null;
                $updateData['tanggal_selesai'] = null;
            }

            if (!$this->iklanUtamaModel->update($idIklan, $updateData)) {
                throw new \Exception('Gagal mengupdate status iklan');
            }

            // update status iklan di artikel
            $data = $this->iklanUtamaModel->getAllIklanUtamaWithTipe($idTipeIklan);

            foreach ($data as $row) {
                $sanitizedName = $row->nama_tipe; // langsung pakai nama di tb_tipe_iklan_utama
                $this->iklanUtamaModel->updateStatusTipeIklan($sanitizedName, 'tidak');
            }


            // 2. Handle komisi hanya jika status diterima
            if ($status == 'diterima') {
                // Handle komisi custom jika dipilih
                if ($useCustomCommission == '1') {
                    $komisiMarketing = floatval($this->request->getPost('komisi_marketing') ?? 0);
                    $komisiPenulis = 0; // Set komisi penulis ke 0
                    $komisiAdmin = floatval($this->request->getPost('komisi_admin') ?? 0); // Karena penulis 0, admin dapat sisanya

                    // Validasi total komisi tidak lebih dari 100%
                    $totalKomisiPersen = $komisiMarketing + $komisiPenulis + $komisiAdmin;
                    if ($totalKomisiPersen > 100) {
                        throw new \Exception('Total komisi tidak boleh melebihi 100%');
                    }

                    // Dapatkan admin ID
                    $adminId = $this->getAdminId();

                    // Simpan komisi custom ke tb_komisi_iklan
                    $komisiData = [
                        [
                            'id_iklan' => (int)$idIklan,
                            'id_user' => (int)$idMarketing,
                            'tipe_iklan' => 'utama',
                            'peran' => 'marketing',
                            'persen' => (int)$komisiMarketing,
                            'jumlah_komisi' => (int)round($totalHarga * $komisiMarketing / 100),
                            'created_at' => date('Y-m-d H:i:s')
                        ],
                        [
                            'id_iklan' => (int)$idIklan,
                            'id_user' => (int)$adminId,
                            'tipe_iklan' => 'utama',
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
                $this->prosesKomisiPemasukan($idIklan, $totalHarga, $idMarketing);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaksi database gagal');
            }

            return redirect()->back()->with('success', 'Status iklan berhasil diubah');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error in ubahStatus: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    private function prosesKomisiPemasukan($idIklan, $totalHarga, $idMarketing)
    {
        // Cek apakah ada komisi custom untuk iklan ini
        $komisiCustom = $this->komisiIklanModel->where('id_iklan', $idIklan)->findAll();

        if (!empty($komisiCustom)) {
            // Gunakan komisi custom
            foreach ($komisiCustom as $komisi) {
                // Skip penulis karena komisi 0
                if ($komisi['peran'] === 'penulis') continue;

                $userId = (int)$komisi['id_user'];
                if ($userId === 0) continue;

                $pemasukanData = [
                    'user_id' => $userId,
                    'jumlah' => (int)$komisi['jumlah_komisi'],
                    'status' => 'disetujui',
                    'tanggal_pemasukan' => date('Y-m-d H:i:s'),
                    'keterangan' => "Komisi {$komisi['peran']} untuk iklan utama ID: {$idIklan} ({$komisi['persen']}%)",
                    'id_iklan' => (int)$idIklan,
                    'jenis_komisi' => $komisi['peran'],
                    'tipe_iklan' => 'utama',

                ];

                if (!$this->pemasukanKomisiModel->insert($pemasukanData)) {
                    throw new \Exception("Gagal menyimpan komisi {$komisi['peran']} - user_id: {$userId}");
                }
            }
        } else {
            // Gunakan komisi default (marketing 30%, penulis 0%, admin 70%)
            // Ambil semua data komisi dari database
            $komisiDefault = $this->komisiModel->findAll();

            $komisiMap = [];
            foreach ($komisiDefault as $komisi) {
                $komisiMap[$komisi['id']] = $komisi['komisi'];
            }

            // Ambil persen komisi marketing dan admin, jika tidak ada set 0
            $komisiMarketing = isset($komisiMap['5']) ? $komisiMap['5'] : 0;
            $komisiAdmin = isset($komisiMap['4']) ? $komisiMap['4'] : 0;

            $komisiData = [
                'marketing' => [
                    'id_user' => (int)$idMarketing,
                    'persen' => (int)$komisiMarketing,
                    'jumlah' => (int)round($totalHarga * $komisiMarketing / 100)
                ],
                'admin' => [
                    'id_user' => (int)$this->getAdminId(),
                    'persen' => (int)$komisiAdmin,
                    'jumlah' => (int)round($totalHarga * $komisiAdmin / 100)
                ]
            ];

            foreach ($komisiData as $peran => $data) {
                if ($data['id_user']) {
                    $pemasukanData = [
                        'user_id' => $data['id_user'],
                        'jumlah' => $data['jumlah'],
                        'status' => 'disetujui',
                        'tanggal_pemasukan' => date('Y-m-d H:i:s'),
                        'keterangan' => "Komisi {$peran} untuk iklan utama ID: {$idIklan} ({$data['persen']}%)",
                        'id_iklan' => (int)$idIklan,
                        'tipe_iklan' => 'utama',
                    ];

                    if (!$this->pemasukanKomisiModel->insert($pemasukanData)) {
                        throw new \Exception("Gagal menyimpan komisi {$peran}");
                    }
                }
            }
        }
    }

    public function tolakIklan()
    {
        // Validasi input
        if (!$this->validate([
            'id_iklan_utama' => 'required|integer',
            'status' => 'required|in_list[ditolak]',
            'alasan_penolakan' => 'required|min_length[10]|max_length[500]'
        ])) {
            return redirect()->back()->with('error', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $idIklan = $this->request->getPost('id_iklan_utama');
            $alasanPenolakan = $this->request->getPost('alasan_penolakan');

            // 1. Update status iklan menjadi ditolak
            $updateData = [
                'status' => 'ditolak',
                'tanggal_mulai' => null,
                'tanggal_selesai' => null,
                'alasan_penolakan' => $alasanPenolakan,
                'diperbarui_pada' => date('Y-m-d H:i:s')
            ];

            if (!$this->iklanUtamaModel->update($idIklan, $updateData)) {
                throw new \Exception('Gagal mengupdate status iklan');
            }

            // 2. Hapus komisi yang terkait dengan iklan ini
            $this->komisiIklanModel->where('id_iklan', $idIklan)
                ->where('tipe_iklan', 'utama')
                ->delete();

            $this->pemasukanKomisiModel->where('id_iklan', $idIklan)
                ->where('tipe_iklan', 'utama')
                ->delete();

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

    private function getAdminId()
    {
        try {
            // Ambil ID user dari session yang sedang login
            $session = session();
            $adminId = $session->get('id_user');

            if (!$adminId) {
                log_message('warning', 'No admin ID found in session, using default ID 1');
                return 1; // Default admin ID
            }

            return (int)$adminId;
        } catch (\Exception $e) {
            log_message('error', 'Error getting admin ID from session: ' . $e->getMessage());
            return 1; // Default admin ID
        }
    }

    public function edit($id)
    {
        $iklanModel = new IklanUtamaModel();
        $tipeModel = new TipeIklanUtamaModel();

        $iklan = $iklanModel->find($id);
        if (!$iklan) {
            return redirect()->back()->with('error', 'Data iklan tidak ditemukan.');
        }

        $data = [
            'iklanUtama' => $iklan,
            'listJenisIklanUtama' => $tipeModel->findAll(),
        ];

        return view('marketing/iklan_utama/edit', $data);
    }

    public function proses_edit($id)
    {
        $iklanLama = $this->iklanUtamaModel->find($id);

        if (!$iklanLama) {
            return redirect()->back()->with('error', 'Data iklan tidak ditemukan.');
        }

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'id_tipe_iklan_utama' => 'required',
            'rentang_bulan'       => 'required|numeric|greater_than[0]',
            'link_iklan'          => 'required|valid_url',
            'thumbnail_iklan'     => 'if_exist|max_size[thumbnail_iklan,2048]|is_image[thumbnail_iklan]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $idTipeIklanUtama = $this->request->getPost('id_tipe_iklan_utama');
        $idMarketing      = session()->get('id_user');
        $linkIklan        = $this->request->getPost('link_iklan');
        $jenis            = $this->request->getPost('jenis');
        $rentangBulan     = $this->request->getPost('rentang_bulan');
        $noPengaju = $this->request->getPost('no_pengaju');

        // Bersihkan total harga
        $totalHarga       = $this->request->getPost('total_harga');
        $cleanTotalHarga  = floatval(str_replace([',', ' '], '', $totalHarga));

        // Siapkan data update
        $dataUpdate = [
            'id_tipe_iklan_utama' => $idTipeIklanUtama,
            'id_marketing'        => $idMarketing,
            'jenis'               => $jenis,
            'rentang_bulan'       => $rentangBulan,
            'total_harga'         => $cleanTotalHarga,
            'link_iklan'          => $linkIklan,
            'no_pengaju'        => $noPengaju,
        ];

        // Handle upload gambar baru (jika ada)
        $gambarBaru = $this->request->getFile('thumbnail_iklan');
        if ($gambarBaru && $gambarBaru->isValid() && !$gambarBaru->hasMoved()) {
            $newName = $gambarBaru->getRandomName();
            $gambarBaru->move('assets/images/iklan_utama', $newName);

            // Hapus gambar lama jika ada
            if (!empty($iklanLama['thumbnail_iklan']) && file_exists('assets/images/iklan_utama/' . $iklanLama['thumbnail_iklan'])) {
                unlink('assets/images/iklan_utama/' . $iklanLama['thumbnail_iklan']);
            }

            $dataUpdate['thumbnail_iklan'] = $newName;
        }

        // Simpan perubahan
        $this->iklanUtamaModel->update($id, $dataUpdate);

        return redirect()->to(base_url('marketing/iklanutama'))->with('success', 'Data iklan berhasil diperbarui.');
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

    public function delete($id = false)
    {
        // Cari data artikel berdasarkan ID
        $data = $this->iklanUtamaModel->find($id);

        if (!$data) {
            session()->setFlashdata('error', 'Data Popup tidak ditemukan');
            return redirect()->to(base_url('marketing/iklanutama'));
        }

        // Hapus data artikel dari database
        $this->iklanUtamaModel->delete($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('marketing/iklanutama'));
    }

    public function detail($id)
    {
        // Ambil detail iklan utama dengan join ke user dan tipe
        $iklan = $this->iklanUtamaModel->getDetailWithUserAndTipe($id);

        if (!$iklan) {
            return redirect()->back()->with('error', 'Data iklan tidak ditemukan.');
        }

        // Ambil data komisi terkait iklan ini
        $komisi = $this->komisiIklanModel
            ->where('id_iklan', $id)
            ->where('tipe_iklan', 'utama')
            ->findAll();

        return view('admin/iklan_utama/detail', [
            'iklan' => $iklan,
            'komisi' => $komisi
        ]);
    }
}
