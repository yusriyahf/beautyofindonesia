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

    public function __construct()
    {
        $this->iklanUtamaModel = new IklanUtamaModel();
        $this->tipeIklanUtamaModel = new TipeIklanUtamaModel();
        $this->TipeIklanUtama = new \App\Models\TipeIklanUtama();
        $this->UserModel = new UserModel();
        $this->komisiIklanModel = new \App\Models\KomisiIklanModel();
        $this->pemasukanKomisiModel = new \App\Models\PemasukanUserModel();
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
        $komisiModel = new KomisiModel();
        // Ambil komisi admin (id 4)
        $komisiAdmin = $komisiModel->find(4);
        // Ambil komisi marketing (id 5)
        $komisiMarketing = $komisiModel->find(5);
        foreach ($all_data_iklan_utama as &$iklan) {
            $harga = $this->TipeIklanUtama->find($iklan['id_tipe_iklan_utama']);
            $iklan['nama'] = $harga['nama'] ?? 'Tidak ditemukan';

            // Ambil username dari tb_users
            $user = $this->UserModel->find($iklan['id_marketing']);
            $iklan['username'] = $user['username'] ?? 'Tidak ditemukan';
        }
        return view('admin/iklan_utama/index', [
            'komisiMarketing' => (float)$komisiMarketing['komisi'],
            'komisiPenulis' => 0, // Diset 0 sesuai permintaan
            'komisiAdmin' => (float)$komisiAdmin['komisi'],
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
        $cleanTotalHarga = floatval(str_replace([',', ' '], '', $totalHarga));

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
                    'jenis_komisi' => $komisi['peran']
                ];

                if (!$this->pemasukanKomisiModel->insert($pemasukanData)) {
                    throw new \Exception("Gagal menyimpan komisi {$komisi['peran']} - user_id: {$userId}");
                }
            }
        } else {
            // Gunakan komisi default (marketing 30%, penulis 0%, admin 70%)
            $komisiMarketing = 0;
            $komisiAdmin = 70;

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
                        'jenis_komisi' => $peran
                    ];

                    if (!$this->pemasukanKomisiModel->insert($pemasukanData)) {
                        throw new \Exception("Gagal menyimpan komisi {$peran}");
        }
                }
            }
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
