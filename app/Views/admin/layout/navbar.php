<?php
// Ambil session dan model
$session = session();
$id_user = $session->get('id_user');

$defaultImage = base_url('assets-baru/img/user/default_profil.jpg');
$profileImage = $defaultImage;

$role = session()->get('role') ?? '';

if ($id_user) {
    $usersModel = new \App\Models\UsersModel();
    $userData = $usersModel->getUsernameById($id_user);

    if (!empty($userData['photo_user'])) {
        // Pastikan foto user ada dan bukan kosong
        $profileImage = base_url('uploads/user_photos/' . $userData['photo_user']);
    }
}
$uri = service('uri');
?>
<div id="app-sidepanel" class="app-sidepanel scroll-hidden">
    <div id="sidepanel-drop" class="sidepanel-drop"></div>
    <div class="sidepanel-inner d-flex flex-column">
        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>

        <!-- Branding Section -->
        <div class="app-branding">
            <a class="app-logo" href="<?= base_url('admin/dashboard') ?>">
                <img src="<?= base_url('assets/images/logoHeader.webp') ?>" alt="Beauty Of Indonesia" class="logo-img">
            </a>
            <div class="brand-text">
                <h1 class="brand-name">Beauty Of Indonesia</h1>
                <small class="brand-tagline">
                    <?= esc(
                        session()->get('role') === 'admin' ? 'Admin Dashboard' : (session()->get('role') === 'penulis' ? 'Penulis Dashboard' : (session()->get('role') === 'marketing' ? 'Marketing Dashboard' : 'Dashboard'))
                    ) ?>
                </small>

            </div>
        </div><!--//app-branding-->

        <!-- User Profile Section -->
        <hr>
        <div class="user-profile-sidebar">
            <div class="user-avatar">
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
                    onerror="this.onerror=null; this.src='<?= base_url('assets-baru/img/user/default_profil.jpg') ?>';">
            </div>
            <div class="user-info">
                <h5 class="user-name"><?= session()->get('username'); ?></h5>
                <span class="user-role"><?= session()->get('role'); ?></span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
            <ul class="app-menu list-unstyled accordion" id="menu-accordion">

                <!-- Dashboard -->
                <?php if (session()->get('role') === 'admin' || session()->get('role') === 'marketing' || session()->get('role') === 'penulis'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) === 'dashboard') ? 'active' : '' ?>" href="<?= base_url($role . '/dashboard') ?>">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z" />
                                    <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z" />
                                </svg>
                            </span>
                            <span class="nav-link-text">Dashboard <?= ucfirst($role) ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Section: Content Management -->
                <li class="nav-section">
                    <span class="nav-section-title">CONTENT MANAGEMENT</span>
                </li>

                <!-- Artikel Section -->
                <li class="nav-item has-submenu <?= ($uri->getSegment(2) == 'artikel' || $uri->getSegment(2) == 'kategori') ? 'active' : '' ?>">
                    <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#artikelMenu" aria-expanded="<?= ($uri->getSegment(2) == 'artikel' || $uri->getSegment(2) == 'kategori') ? 'true' : 'false' ?>">
                        <span class="nav-icon">
                            <i class="bi bi-journals"></i>
                        </span>
                        <span class="nav-link-text">Artikel</span>
                        <span class="submenu-arrow">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </a>
                    <div id="artikelMenu" class="collapse submenu <?= ($uri->getSegment(2) == 'artikel' || $uri->getSegment(2) == 'kategori') ? 'show' : '' ?>">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link <?= ($uri->getSegment(2) == 'artikel') ? 'active' : '' ?>" href="<?= base_url($role . '/artikel/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </span>
                                    <span class="nav-link-text">Semua Artikel</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($uri->getSegment(2) == 'kategori') ? 'active' : '' ?>" href="<?= base_url($role . '/kategori/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-tags"></i>
                                    </span>
                                    <span class="nav-link-text">Kategori Artikel</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Wisata Section -->
                <li class="nav-item has-submenu <?= ($uri->getSegment(2) == 'tempat_wisata' || $uri->getSegment(2) == 'kategori_wisata') ? 'active' : '' ?>">
                    <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#wisataMenu" aria-expanded="<?= ($uri->getSegment(2) == 'tempat_wisata' || $uri->getSegment(2) == 'kategori_wisata') ? 'true' : 'false' ?>">
                        <span class="nav-icon">
                            <i class="bi bi-journals"></i>
                        </span>
                        <span class="nav-link-text">Tempat Wisata</span>
                        <span class="submenu-arrow">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </a>
                    <div id="wisataMenu" class="collapse submenu <?= ($uri->getSegment(2) == 'tempat_wisata' || $uri->getSegment(2) == 'kategori_wisata') ? 'show' : '' ?>">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link <?= ($uri->getSegment(2) == 'tempat_wisata') ? 'active' : '' ?>" href="<?= base_url($role . '/tempat_wisata/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </span>
                                    <span class="nav-link-text">Semua Tempat Wisata</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($uri->getSegment(2) == 'kategori_wisata') ? 'active' : '' ?>" href="<?= base_url($role . '/kategori_wisata/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-tags"></i>
                                    </span>
                                    <span class="nav-link-text">Kategori Tempat Wisata</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Oleh-Oleh Section -->
                <li class="nav-item has-submenu <?= ($uri->getSegment(2) == 'oleh_oleh' || $uri->getSegment(2) == 'kategori_oleholeh') ? 'active' : '' ?>">
                    <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#olehMenu" aria-expanded="<?= ($uri->getSegment(2) == 'oleh_oleh' || $uri->getSegment(2) == 'kategori_oleholeh') ? 'true' : 'false' ?>">
                        <span class="nav-icon">
                            <i class="bi bi-journals"></i>
                        </span>
                        <span class="nav-link-text">Oleh Oleh</span>
                        <span class="submenu-arrow">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </a>
                    <div id="olehMenu" class="collapse submenu <?= ($uri->getSegment(2) == 'oleh_oleh' || $uri->getSegment(2) == 'kategori_oleholeh') ? 'show' : '' ?>">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link <?= ($uri->getSegment(2) == 'oleh_oleh') ? 'active' : '' ?>" href="<?= base_url($role . '/oleh_oleh/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </span>
                                    <span class="nav-link-text">Semua Oleh-Oleh</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($uri->getSegment(2) == 'kategori_oleholeh') ? 'active' : '' ?>" href="<?= base_url($role . '/kategori_oleholeh/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-tags"></i>
                                    </span>
                                    <span class="nav-link-text">Kategori Oleh-Oleh</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Section: Location Management -->
                <?php if (session()->get('role') === 'admin'): ?>
                    <li class="nav-section">
                        <span class="nav-section-title">LOCATION MANAGEMENT</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) == 'provinsi') ? 'active' : '' ?>" href="<?= base_url('admin/provinsi/index') ?>">
                            <span class="nav-icon">
                                <i class="bi bi-map"></i>
                            </span>
                            <span class="nav-link-text">Provinsi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) == 'kabupaten') ? 'active' : '' ?>" href="<?= base_url('admin/kabupaten/index') ?>">
                            <span class="nav-icon">
                                <i class="bi bi-geo"></i>
                            </span>
                            <span class="nav-link-text">Kabupaten</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Section: Advertising -->
                <li class="nav-section">
                    <span class="nav-section-title">ADVERTISING</span>
                </li>

                <?php if (session()->get('role') === 'admin' || session()->get('role') === 'marketing' || session()->get('role') === 'penulis'): ?>
                    <!-- Iklan Konten Menu -->
                    <li class="nav-item has-submenu <?= in_array($uri->getSegment(2), ['daftariklankonten', 'acciklankonten', 'tipeiklankonten']) ? 'active' : '' ?>">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#iklanKontenMenu" aria-expanded="<?= in_array($uri->getSegment(2), ['daftariklankonten', 'acciklankonten', 'tipeiklankonten']) ? 'true' : 'false' ?>">
                            <span class="nav-icon">
                                <i class="bi bi-window-stack"></i>
                            </span>
                            <span class="nav-link-text">Iklan Konten</span>
                            <span class="submenu-arrow">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </a>
                        <div id="iklanKontenMenu" class="collapse submenu <?= in_array($uri->getSegment(2), ['daftariklankonten', 'acciklankonten', 'tipeiklankonten']) ? 'show' : '' ?>">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?= ($uri->getSegment(2) == 'daftariklankonten') ? 'active' : '' ?>" href="<?= base_url($role . '/daftariklankonten') ?>">
                                        <span class="nav-icon">
                                            <i class="bi bi-window-plus"></i>
                                        </span>
                                        <span class="nav-link-text">Daftar Iklan Konten</span>
                                    </a>
                                </li>
                                <?php if (session()->get('role') === 'admin'): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($uri->getSegment(2) == 'acciklankonten') ? 'active' : '' ?>" href="<?= base_url('admin/acciklankonten') ?>">
                                            <span class="nav-icon">
                                                <i class="bi bi-window-plus"></i>
                                            </span>
                                            <span class="nav-link-text">Acc Iklan Konten</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($uri->getSegment(2) == 'tipeiklankonten') ? 'active' : '' ?>" href="<?= base_url('admin/tipeiklankonten') ?>">
                                            <span class="nav-icon">
                                                <i class="bi bi-window"></i>
                                            </span>
                                            <span class="nav-link-text">Tipe Iklan Konten</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (in_array(session()->get('role'), ['admin', 'marketing'])): ?>
                    <!-- Iklan Utama Menu -->
                    <li class="nav-item has-submenu <?= in_array($uri->getSegment(2), ['iklanutama', 'acciklanutama', 'tipeiklanutama']) ? 'active' : '' ?>">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#iklanUtamaMenu" aria-expanded="<?= in_array($uri->getSegment(2), ['iklanutama', 'acciklanutama', 'tipeiklanutama']) ? 'true' : 'false' ?>">
                            <span class="nav-icon">
                                <i class="bi bi-window-stack"></i>
                            </span>
                            <span class="nav-link-text">Iklan Utama</span>
                            <span class="submenu-arrow">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </a>
                        <div id="iklanUtamaMenu" class="collapse submenu <?= in_array($uri->getSegment(2), ['iklanutama', 'acciklanutama', 'tipeiklanutama']) ? 'show' : '' ?>">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?= ($uri->getSegment(2) == 'iklanutama') ? 'active' : '' ?>" href="<?= base_url($role . '/iklanutama') ?>">
                                        <span class="nav-icon">
                                            <i class="bi bi-window-plus"></i>
                                        </span>
                                        <span class="nav-link-text">Daftar Iklan Utama</span>
                                    </a>
                                </li>
                                <?php if (session()->get('role') === 'admin'): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($uri->getSegment(2) == 'acciklanutama') ? 'active' : '' ?>" href="<?= base_url('admin/acciklanutama') ?>">
                                            <span class="nav-icon">
                                                <i class="bi bi-window-plus"></i>
                                            </span>
                                            <span class="nav-link-text">Acc Iklan Utama</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($uri->getSegment(2) == 'tipeiklanutama') ? 'active' : '' ?>" href="<?= base_url('admin/tipeiklanutama') ?>">
                                            <span class="nav-icon">
                                                <i class="bi bi-window"></i>
                                            </span>
                                            <span class="nav-link-text">Tipe Iklan Utama</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('role') === 'admin'): ?>
                    <!-- Popup Management -->
                    <li class="nav-item has-submenu <?= in_array($uri->getSegment(2), ['popup', 'tampilpopup']) ? 'active' : '' ?>">
                        <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#popupMenu" aria-expanded="<?= in_array($uri->getSegment(2), ['popup', 'tampilpopup']) ? 'true' : 'false' ?>">
                            <span class="nav-icon">
                                <i class="bi bi-window-stack"></i>
                            </span>
                            <span class="nav-link-text">Kelola Popup</span>
                            <span class="submenu-arrow">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </a>
                        <div id="popupMenu" class="collapse submenu <?= in_array($uri->getSegment(2), ['popup', 'tampilpopup']) ? 'show' : '' ?>">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?= ($uri->getSegment(2) == 'popup') ? 'active' : '' ?>" href="<?= base_url('admin/popup') ?>">
                                        <span class="nav-icon">
                                            <i class="bi bi-window-plus"></i>
                                        </span>
                                        <span class="nav-link-text">Kelola Popup</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= ($uri->getSegment(2) == 'tampilpopup') ? 'active' : '' ?>" href="<?= base_url('admin/tampilpopup') ?>">
                                        <span class="nav-icon">
                                            <i class="bi bi-window-plus"></i>
                                        </span>
                                        <span class="nav-link-text">Aktif/Tidak Aktif</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <!-- Section: Financial -->
                <?php if (in_array(session()->get('role'), ['admin', 'marketing', 'penulis'])): ?>
                    <li class="nav-section">
                        <span class="nav-section-title">FINANCIAL</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= $uri->getSegment(2) == 'saldo' && !$uri->getSegment(3) ? 'active' : '' ?>" href="<?= base_url($role . '/saldo') ?>">
                            <span class="nav-icon">
                                <i class="bi bi-wallet2"></i>
                            </span>
                            <span class="nav-link-text">Saldo</span>
                        </a>
                    </li>
                    <?php if (session()->get('role') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == 'saldo' && $uri->getSegment(3) == 'permintaan') ? 'active' : '' ?>" href="<?= base_url('admin/saldo/permintaan') ?>">
                                <span class="nav-icon">
                                    <i class="bi bi-arrow-repeat"></i>
                                </span>
                                <span class="nav-link-text">Permintaan Saldo</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == 'riwayatkomisi') ? 'active' : '' ?>" href="<?= base_url('admin/riwayatkomisi') ?>">
                                <span class="nav-icon">
                                    <i class="bi bi-percent"></i>
                                </span>
                                <span class="nav-link-text">Riwayat Komisi</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Section: System -->
                <?php if (session()->get('role') === 'admin'): ?>
                    <li class="nav-section">
                        <span class="nav-section-title">SYSTEM</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) === 'meta') ? 'active' : '' ?>" href="<?= base_url('admin/meta/index') ?>">
                            <span class="nav-icon">
                                <i class="bi bi-card-checklist"></i>
                            </span>
                            <span class="nav-link-text">Meta Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) === 'tentang') ? 'active' : '' ?>" href="<?= base_url('admin/tentang/edit') ?>">
                            <span class="nav-icon">
                                <i class="bi bi-info-circle"></i>
                            </span>
                            <span class="nav-link-text">About Page</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) === 'users') ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
                            <span class="nav-icon">
                                <i class="bi bi-people-fill"></i>
                            </span>
                            <span class="nav-link-text">User Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(2) === 'userRequest') ? 'active' : '' ?>" href="<?= base_url('admin/userRequest') ?>">
                            <span class="nav-icon">
                                <i class="bi bi-people-fill"></i>
                            </span>
                            <span class="nav-link-text">ACC User Request</span>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
</div>

<!-- Sidebar CSS -->
<style>
    /* Branding Section */
    .app-branding {
        padding: 1.5rem 1rem;
        margin-bottom: 5rem;
        text-align: center;
    }

    .logo-img {
        max-width: 50%;
        margin-bottom: 0.5rem;
    }

    .brand-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 0.25rem;
    }

    .brand-tagline {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.6);
    }

    /* User Profile */
    .user-profile-sidebar {
        margin-bottom: 1.5rem;
        padding: 0rem 1rem 1rem 1rem;
        display: flex;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 0.75rem;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #fff;
        margin-bottom: 0.1rem;
    }

    .user-role {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.6);
    }

    /* Navigation Menu */
    .app-menu {
        padding: 0.5rem 0;
    }

    .nav-item {
        margin-bottom: 0.25rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .nav-link:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.05);
        border-left-color: var(--primary);
    }

    .nav-link.active {
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        border-left-color: var(--primary);
    }

    .nav-icon {
        margin-right: 0.75rem;
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }

    .nav-link-text {
        font-size: 0.875rem;
        font-weight: 400;
        padding-top: 10%;
        text-align: center;
    }

    /* Submenu */
    .has-submenu .submenu-toggle {
        position: relative;
    }

    .submenu-arrow {
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    .submenu-toggle[aria-expanded="true"] .submenu-arrow {
        transform: rotate(180deg);
    }

    .submenu {
        padding-left: 1.5rem;
        background: rgba(0, 0, 0, 0.1);
    }

    .submenu .nav-link {
        /* padding: 0.5rem 1rem; */
        font-size: 0.8125rem;
    }

    .submenu .nav-icon {
        margin-right: 2%;
        font-size: 0.9rem;
    }

    /* Nested submenu */
    .submenu .has-submenu .submenu {
        padding-left: 1rem;
    }

    .nav-section {
        padding: 0.75rem 1.5rem;
        margin-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .nav-section-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    #app-sidepanel {
        height: 100vh;
        overflow: hidden !important;
        scrollbar-width: none !important;
        /* Firefox */
        -ms-overflow-style: none !important;
        /* IE/Edge */
    }

    #app-sidepanel::-webkit-scrollbar {
        display: none !important;
        /* Chrome/Safari */
    }


    /* Jika ingin memungkinkan scroll, tapi tetap sembunyikan scrollbar */
    #app-sidepanel.scroll-hidden {
        overflow: auto !important;
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* Internet Explorer 10+ */
    }
</style>

<!-- JavaScript for Submenu Toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap Collapse
        const collapses = document.querySelectorAll('.collapse');
        collapses.forEach(collapse => {
            collapse.addEventListener('show.bs.collapse', function() {
                this.closest('.has-submenu').classList.add('active');
            });

            collapse.addEventListener('hide.bs.collapse', function() {
                this.closest('.has-submenu').classList.remove('active');
            });
        });
    });
</script>