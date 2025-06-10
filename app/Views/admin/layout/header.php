<?php
// Ambil session dan model
$session = session();
$id_user = $session->get('id_user');

$defaultImage = base_url('assets-baru/img/user/default_profil.jpg');
$profileImage = $defaultImage;

if ($id_user) {
    $usersModel = new \App\Models\UsersModel();
    $userData = $usersModel->getUsernameById($id_user);

    if (!empty($userData['photo_user'])) {
        // Pastikan foto user ada dan bukan kosong
        $profileImage = base_url('uploads/user_photos/' . $userData['photo_user']);
    }
}
?>
<?php $role = session()->get('role'); ?>

<header class="app-header fixed-top">
    <div class="app-header-inner">
        <div class="container-fluid py-2">
            <div class="app-header-content">
                <div class="row justify-content-between align-items-center">

                    <div class="col-auto">
                        <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                            <svg xmlns="" width="30" height="30" viewBox="0 0 30 30" role="img">
                                <title>Menu</title>
                                <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                            </svg>
                        </a>
                    </div><!--//col-->
                    <div class="search-mobile-trigger d-sm-none col">
                        <i class="search-mobile-trigger-icon fa-solid fa-magnifying-glass"></i>
                    </div><!--//col-->
                    <div class="app-utilities col-auto">
                    <div class="app-utility-item app-user-dropdown dropdown">
                        <a class="dropdown-toggle d-flex align-items-center gap-2" id="user-dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                            <?php
                            $profileImage = session()->get('photo_user');
                            $photoPath = !empty($profileImage)
                                ? $profileImage
                                : base_url('assets-baru/img/user/default_profil.jpg');
                            ?>
                            <img 
                                src="<?= esc($profileImage) ?>" 
                                alt="Admin Profile" 
                                class="rounded-circle" 
                                style="width: 40px; height: 40px; object-fit: cover;"
                                onerror="this.onerror=null; this.src='<?= base_url('assets-baru/img/user/default_profil.jpg') ?>';"
                            >
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">

                            <li><a href="<?= base_url($role . '/profile/index') ?>" class="dropdown-item"><i class="fa-solid fa-user"></i> Detail Profile</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('logout') ?>" style="color: red;"><i class="fa-solid fa-right-from-bracket" style="color: #ff0000;"></i> Log Out</a></li>
                        </ul>
                    </div><!--//app-user-dropdown-->
                </div>

                    <!--//app-utilities-->

                </div><!--//row-->
            </div><!--//app-header-content-->
        </div><!--//container-fluid-->
    </div><!--//app-header-inner-->

    <?= $this->include('admin/layout/navbar'); ?>
</header><!--//app-header-->