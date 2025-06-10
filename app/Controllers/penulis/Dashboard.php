<?php 

namespace App\Controllers\penulis;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\OlehOlehModel;
use App\Models\PemasukanUserModel;
use App\Models\PenulisModel;
use App\Models\TempatWisataModel;
use App\Models\UsersModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Ambil id_user dari session
        $id_user = session()->get('id_user');

        $artikelModel = new ArtikelModel();
        $wisataModel = new TempatWisataModel();
        $olehModel = new OlehOlehModel();
        $pemasukanModel = new PemasukanUserModel();
        $penulisModel = new PenulisModel();
        $usersModel = new UsersModel();
        $penarikanModel = new \App\Models\PenarikanUserModel();
        $iklanModel = new \App\Models\ArtikelIklanModel();

        $userData = $usersModel->getUsernameById($id_user);

        $total_artikel = $artikelModel->getTotalArtikelByPenulis($id_user);
        $total_wisata = $wisataModel->getTotalWisataByPenulis($id_user);
        $total_oleh = $olehModel-> getTotalOlehByPenulis($id_user);
        $total_komisi = $pemasukanModel-> getTotalKomisi($id_user);
        $namaPenulis = $penulisModel->getNamaPenulisByUserId($id_user);
        $username = $userData['username'] ?? 'Guest';
        
        $photo_user = $userData['photo_user'] ?? null;
        $profileImage = $photo_user ? base_url('uploads/user_photos/' . $photo_user) : base_url('assets-baru/img/user/default_profil.jpg');

        // Ambil nilai 'jumlah' dari array yang pertama
        $total_komisi = $total_komisi[0]['jumlah'] ?? 0;

         // Debug untuk mengecek hasil
        // var_dump($total_komisi);  // Cek apakah hasilnya ada dan sesuai

        $data_komisi = $pemasukanModel->getTotalKomisi($id_user);
        $total_komisi = isset($data_komisi['jumlah']) ? (float)$data_komisi['jumlah'] : 0;
        $data_komisi_bulanan = $pemasukanModel->getKomisiPerBulan($id_user);
        $komisi_bulanan = array_fill(1, 12, 0);
        foreach ($data_komisi_bulanan as $row) {
            $komisi_bulanan[(int)$row['bulan']] = (float)$row['total'];
        }

        $last3Jumlah = $pemasukanModel->getLast3Jumlah($id_user);
        $tanggal_terakhir = $pemasukanModel->getLast3Tanggal($id_user);
        $jam_terakhir = $pemasukanModel->getLast3JamPemasukan($id_user);
        $status_terakhir = $pemasukanModel->getLast3Status($id_user);

        // aktivitas terakhir
        $data_pemasukan = $pemasukanModel->getAktivitasPemasukan($id_user);
        $data_penarikan = $penarikanModel->getAktivitasPenarikan($id_user);
        $data_iklan = $iklanModel->getAktivitasIklan($id_user);
        // Gabungkan
        $semua_aktivitas = array_merge($data_pemasukan, $data_penarikan, $data_iklan);
        // dd($semua_aktivitas);
        // Urutkan berdasarkan tanggal DESC
        usort($semua_aktivitas, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });
        // Ambil 3 aktivitas terbaru (opsional)
        $aktivitas_terbaru = array_slice($semua_aktivitas, 0, 3);

        //  AMBIL INFO IKLAN 
        // ambil aktivitas iklan aja buat dapat id_iklan (biar bisa lanjut cari info iklan)
        $aktivitas_iklan_saja = array_filter($aktivitas_terbaru, function ($aktivitas) {
            return isset($aktivitas['jenis_aktivitas']) && $aktivitas['jenis_aktivitas'] === 'iklan';
        });

        // Reindex array-nya kalau mau pakai sebagai list (opsional)
        $aktivitas_iklan_saja = array_values($aktivitas_iklan_saja);

        $judulKontenIklan = [];

        // ambil judul iklan    
        foreach ($aktivitas_iklan_saja as $itemIklan) {
            $id_iklan = $itemIklan['id_iklan'];

            // Ambil data iklan dari tabel artikel_iklan
            $dataIklan = $iklanModel->find($id_iklan);

            if ($dataIklan) {
                $tipe = $dataIklan['tipe_content'];
                $idKonten = $dataIklan['id_content'];
                $judul = null;

                // Ambil judul berdasarkan tipe konten
                switch ($tipe) {
                    case 'artikel':
                        $konten = $artikelModel->find($idKonten);
                        $judul = $konten['judul_artikel'] ?? '(judul tidak ditemukan)';
                        break;

                    case 'wisata':
                        $konten = $wisataModel->find($idKonten);
                        $judul = $konten['nama_wisata'] ?? '(judul tidak ditemukan)';
                        break;

                    case 'oleh':
                        $konten = $olehModel->find($idKonten);
                        $judul = $konten['nama_oleh'] ?? '(judul tidak ditemukan)';
                        break;

                    default:
                        $judul = '(tipe konten tidak diketahui)';
                        break;
                }

                // Simpan hasil, cuma ambil judul, tp dah dicariin banyak sm gpt hehe
                $judulKontenIklan[] = [
                    'id_iklan' => $id_iklan,
                    'judul' => $judul,
                    'tipe_content' => $tipe, 
                    'tanggal' => $itemIklan['tanggal'],
                    'jam' => $itemIklan['jam'] ?? null,
                    'status' => $itemIklan['status'] ?? null
                ];
            }
        }



        $data = [
            'total_artikel' => $total_artikel,
            'total_wisata' => $total_wisata,
            'total_oleh' => $total_oleh,
            'total_komisi' => $total_komisi,
            'namaPenulis' => $namaPenulis,
            'username' => $username,
            'profileImage' => $profileImage,
            'komisi_chart'    => array_values($komisi_bulanan),
            'semua_jumlah'    => $last3Jumlah,
            'tanggal_terakhir' => $tanggal_terakhir,
            'jam_terakhir'     => $jam_terakhir,
            'status_terakhir'  => $status_terakhir,
            'aktivitas' => $aktivitas_terbaru,
            'judulKontenIklan' =>  $judulKontenIklan,       
        ];

        return view('penulis/dashboard/index', $data);
    }
}
