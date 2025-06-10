<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\IklanModel;
use App\Models\OlehOlehModel;
use App\Models\TempatWisataModel;
use App\Models\UsersModel;

class Dashboardctrl extends BaseController
{
    public function index()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
            // Ubah 'login' sesuai dengan halaman login Anda

        }
        $id_user = session()->get('id_user');

        $iklanModel = new IklanModel();
        $artikelModel = new ArtikelModel();
        $olehModel = new OlehOlehModel();
        $wisataModel = new TempatWisataModel();
        $usersModel = new UsersModel();
        $ArtikelIklanModel = new \App\Models\ArtikelIklanModel();
        $ArtikelIklanModel->updateStatusIklan();
            $pemasukanModel = new PemasukanUserModel();
            $pengajuanUserModel = new PengajuanModel();
            $iklanModel = new ArtikelIklanModel();


        $userData = $usersModel->getUsernameById($id_user);

        $username = $userData['username'] ?? 'Guest';

        $photo_user = $userData['photo_user'] ?? null;
        $profileImage = $photo_user ? base_url('assets-baru/img/user/' . $photo_user) : base_url('assets-baru/img/user/default_profil.jpg');

            $data_komisi = $pemasukanModel->getTotalKomisi($id_user);
            $total_komisi = isset($data_komisi['jumlah']) ? (float)$data_komisi['jumlah'] : 0;

            $data_komisi_bulanan = $pemasukanModel->getKomisiPerBulan($id_user);
            $komisi_bulanan = array_fill(1, 12, 0);
            foreach ($data_komisi_bulanan as $row) {
            $komisi_bulanan[(int)$row['bulan']] = (float)$row['total'];
            }

            // Ambil aktivitas dari dua model
            $aktivitasPengajuan = $pengajuanUserModel->getPendingAktivitas();
            $aktivitasIklan = $iklanModel->getDiajukanAktivitas();
            
            // Tambahkan jenis aktivitas ke masing-masing item
            foreach ($aktivitasPengajuan as &$item) {
                $item['jenis'] = 'pengajuan user';
            }

            foreach ($aktivitasIklan as &$item) {
                $item['jenis'] = 'iklan';
            }

            // Gabungkan dan urutkan berdasarkan tanggal terbaru
            $allAktivitas = array_merge($aktivitasPengajuan, $aktivitasIklan);

            usort($allAktivitas, function ($a, $b) {
                return strtotime($b['tanggal']) - strtotime($a['tanggal']);
            });

            // Ambil 3 terbaru
            $aktivitas_terakhir = array_slice($allAktivitas, 0, 3);

            // buat tabel riwayat komisi terakhir
            $last3Jumlah = $pemasukanModel->getLast3Jumlah($id_user);
            $tanggal_terakhir = $pemasukanModel->getLast3Tanggal($id_user);
            $jam_terakhir = $pemasukanModel->getLast3JamPemasukan($id_user);
            $status_terakhir = $pemasukanModel->getLast3Status($id_user);

            $data = [
                'total_iklan' => $iklanModel->countAllResults(),
                'total_artikel' => $artikelModel->countAllResults(),
                'total_oleh' => $olehModel->countAllResults(),
                'total_wisata' => $wisataModel->countAllResults(),
                'username' => $username,
                'profileImage' => $profileImage,
                'total_komisi' => $total_komisi,
                'komisi_chart'    => array_values($komisi_bulanan),
                'aktivitas' => $aktivitas_terakhir,
                'semua_jumlah'    => $last3Jumlah,
                'tanggal_terakhir' => $tanggal_terakhir,
                'jam_terakhir'     => $jam_terakhir,
                'status_terakhir'  => $status_terakhir,


            ];
            return view('admin/dashboard/index', $data);

        }

    }
}
