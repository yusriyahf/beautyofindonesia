<?php

    namespace App\Controllers\admin;
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
        
            $userData = $usersModel->getUsernameById($id_user);

            $username = $userData['username'] ?? 'Guest';

            $photo_user = $userData['photo_user'] ?? null;
            $profileImage = $photo_user ? base_url('assets-baru/img/user/' . $photo_user) : base_url('assets-baru/img/user/default_profil.jpg');


            $data = [
                'total_iklan' => $iklanModel->countAllResults(),
                'total_artikel' => $artikelModel->countAllResults(),
                'total_oleh' => $olehModel->countAllResults(),
                'total_wisata' => $wisataModel->countAllResults(),
                'username' => $username,
                'profileImage' => $profileImage
            ];
            return view('admin/dashboard/index', $data);

        }

    }