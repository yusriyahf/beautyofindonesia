<?php 
    
namespace App\Controllers\Marketing;
use App\Controllers\BaseController;
use App\Models\ArtikelIklanModel;
use App\Models\ArtikelModel;
use App\Models\IklanModel;
use App\Models\OlehOlehModel;
use App\Models\TempatWisataModel;
use App\Models\UsersModel;
use App\Models\PemasukanUserModel;


class Dashboard extends BaseController
{
    public function index()
    {   
        $id_user = session()->get('id_user');

        $iklanModel = new IklanModel();
        $artikelModel = new ArtikelModel();
        $olehModel = new OlehOlehModel();
        $wisataModel = new TempatWisataModel();
        $artikelIklanModel = new ArtikelIklanModel();
        $usersModel = new UsersModel();

        $ArtikelIklanModel = new \App\Models\ArtikelIklanModel();
        $ArtikelIklanModel->updateStatusIklan();
        $IklanUtamaModel = new \App\Models\IklanUtamaModel();
        $IklanUtamaModel->updateStatusIklan();

        $pemasukanModel = new PemasukanUserModel();
        $penarikanModel = new \App\Models\PenarikanUserModel();

        $userData = $usersModel->getUsernameById($id_user);

        $iklanDiterima = $artikelIklanModel->countIklanDiterimaByMarketing($id_user);
        $iklanDitolak = $artikelIklanModel->countIklanDitolakByMarketing($id_user);
        $iklanDiajukan = $artikelIklanModel->countIklanDiajukan($id_user);
        $username = $userData['username'] ?? 'Guest';
        
        $photo_user = $userData['photo_user'] ?? null;
        $profileImage = $photo_user ? base_url('uploads/user_photos/' . $photo_user) : base_url('assets-baru/img/user/default_profil.jpg');

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
        $data_iklan = $artikelIklanModel->getAktivitasIklan($id_user);
        // Gabungkan
        $semua_aktivitas = array_merge($data_pemasukan, $data_penarikan, $data_iklan);
        // dd($semua_aktivitas);
        // Urutkan berdasarkan tanggal DESC
        usort($semua_aktivitas, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });
        // Ambil 3 aktivitas terbaru (opsional)
        $aktivitas_terbaru = array_slice($semua_aktivitas, 0, 3);

        $data = [
            'total_iklan' => $iklanModel->countAllResults(),
            'total_artikel' => $artikelModel->countAllResults(),
            'total_oleh' => $olehModel->countAllResults(),
            'total_wisata' => $wisataModel->countAllResults(),
            'iklanDiterima' => $iklanDiterima,
            'iklanDitolak' => $iklanDitolak,
            'iklanDiajukan' => $iklanDiajukan,
            'username' => $username,
            'profileImage' => $profileImage,
            'komisi_chart'    => array_values($komisi_bulanan),
            'semua_jumlah'    => $last3Jumlah,
            'tanggal_terakhir' => $tanggal_terakhir,
            'jam_terakhir'     => $jam_terakhir,
            'status_terakhir'  => $status_terakhir,
            'total_komisi' => $total_komisi,
            'aktivitas' => $aktivitas_terbaru,
        ];
        return view('marketing/dashboard/index', $data);
    }
}
    ?>