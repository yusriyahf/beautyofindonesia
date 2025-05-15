<?php 
    
namespace App\Controllers\marketing;
use App\Controllers\BaseController;
use App\Models\ArtikelIklanModel;
use App\Models\ArtikelModel;
use App\Models\IklanModel;
use App\Models\OlehOlehModel;
use App\Models\TempatWisataModel;
use App\Models\UsersModel;


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

        $userData = $usersModel->getUsernameById($id_user);

        $iklanDiterima = $artikelIklanModel->countIklanDiterimaByMarketing($id_user);
        $iklanDitolak = $artikelIklanModel->countIklanDitolakByMarketing($id_user);
        $iklanDiajukan = $artikelIklanModel->countIklanDiajukan($id_user);
        $username = $userData['username'] ?? 'Guest';
        
        $photo_user = $userData['photo_user'] ?? null;
        $profileImage = $photo_user ? base_url('uploads/user_photos/' . $photo_user) : base_url('assets-baru/img/user/default_profil.jpg');



        $data = [
            'total_iklan' => $iklanModel->countAllResults(),
            'total_artikel' => $artikelModel->countAllResults(),
            'total_oleh' => $olehModel->countAllResults(),
            'total_wisata' => $wisataModel->countAllResults(),
            'iklanDiterima' => $iklanDiterima,
            'iklanDitolak' => $iklanDitolak,
            'iklanDiajukan' => $iklanDiajukan,
            'username' => $username,
            'profileImage' => $profileImage
        ];
        return view('marketing/dashboard/index', $data);
    }
}
    ?>