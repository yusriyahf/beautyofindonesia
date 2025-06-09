<?php 

namespace App\Controllers\Penulis;

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
        $ArtikelIklanModel = new \App\Models\ArtikelIklanModel();
        $ArtikelIklanModel->updateStatusIklan();

        $userData = $usersModel->getUsernameById($id_user);

        $total_artikel = $artikelModel->getTotalArtikelByPenulis($id_user);
        $total_wisata = $wisataModel->getTotalWisataByPenulis($id_user);
        $total_oleh = $olehModel-> getTotalOlehByPenulis($id_user);
        $total_komisi = $pemasukanModel-> getTotalKomisiPenulis($id_user);
        $namaPenulis = $penulisModel->getNamaPenulisByUserId($id_user);
        $username = $userData['username'] ?? 'Guest';
        
        $photo_user = $userData['photo_user'] ?? null;
        $profileImage = $photo_user ? base_url('uploads/user_photos/' . $photo_user) : base_url('assets-baru/img/user/default_profil.jpg');

        // Ambil nilai 'jumlah' dari array yang pertama
        $total_komisi = $total_komisi[0]['jumlah'] ?? 0;

         // Debug untuk mengecek hasil
        // var_dump($total_komisi);  // Cek apakah hasilnya ada dan sesuai




        $data = [
            'total_artikel' => $total_artikel,
            'total_wisata' => $total_wisata,
            'total_oleh' => $total_oleh,
            'total_komisi' => $total_komisi,
            'namaPenulis' => $namaPenulis,
            'username' => $username,
            'profileImage' => $profileImage,
        ];

        return view('penulis/dashboard/index', $data);
    }
}
