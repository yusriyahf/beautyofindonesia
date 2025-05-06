<div id="app-sidepanel" class="app-sidepanel">
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
                <small class="brand-tagline">Admin Dashboard</small>
            </div>
        </div><!--//app-branding-->

        <!-- User Profile Section -->
         <hr>
        <div class="user-profile-sidebar">
            <div class="user-avatar">
                <img src="<?= base_url('assets-baru/img/user/default_profil.jpg') ?>" alt="Admin Profile">
            </div>
            <div class="user-info">
                <h5 class="user-name">Icha</h5>
                <span class="user-role">Administrator</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
            <ul class="app-menu list-unstyled accordion" id="menu-accordion">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                        <span class="nav-icon">
                            <i class="bi bi-speedometer2"></i>
                        </span>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>

                <!-- Content Management -->
                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#contentMenu">
                        <span class="nav-icon">
                            <i class="bi bi-collection"></i>
                        </span>
                        <span class="nav-link-text">Content Management</span>
                        <span class="submenu-arrow">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </a>
                    <div id="contentMenu" class="collapse submenu">
                        <ul class="nav flex-column">
                            <!-- Artikel Section -->
                            <li class="nav-item has-submenu">
                                <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#artikelMenu">
                                    <span class="nav-icon">
                                        <i class="bi bi-journals"></i>
                                    </span>
                                    <span class="nav-link-text">Artikel</span>
                                    <span class="submenu-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </a>
                                <div id="artikelMenu" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('admin/artikel/index') ?>">
                                                <span class="nav-icon">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </span>
                                                <span class="nav-link-text">Semua Artikel</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('admin/artikel/artikel_beriklan') ?>">
                                                <span class="nav-icon">
                                                    <i class="bi bi-megaphone"></i>
                                                </span>
                                                <span class="nav-link-text">Artikel Beriklan</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('admin/kategori/index') ?>">
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
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/tempat_wisata/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-map"></i>
                                    </span>
                                    <span class="nav-link-text">Tempat Wisata</span>
                                </a>
                            </li>

                            <!-- Oleh-Oleh Section -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/oleh_oleh/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-gift"></i>
                                    </span>
                                    <span class="nav-link-text">Oleh-Oleh</span>
                                </a>
                            </li>

                            <!-- Kategori Section -->
                            <li class="nav-item has-submenu">
                                <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#kategoriMenu">
                                    <span class="nav-icon">
                                        <i class="bi bi-bookmarks"></i>
                                    </span>
                                    <span class="nav-link-text">Kategori</span>
                                    <span class="submenu-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </a>
                                <div id="kategoriMenu" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('admin/kategori_wisata/index') ?>">
                                                <span class="nav-icon">
                                                    <i class="bi bi-signpost-split"></i>
                                                </span>
                                                <span class="nav-link-text">Kategori Wisata</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('admin/kategori_oleholeh/index') ?>">
                                                <span class="nav-icon">
                                                    <i class="bi bi-basket"></i>
                                                </span>
                                                <span class="nav-link-text">Kategori Oleh-Oleh</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Location Management -->
                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#locationMenu">
                        <span class="nav-icon">
                            <i class="bi bi-geo-alt"></i>
                        </span>
                        <span class="nav-link-text">Location Management</span>
                        <span class="submenu-arrow">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </a>
                    <div id="locationMenu" class="collapse submenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/provinsi/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-map"></i>
                                    </span>
                                    <span class="nav-link-text">Provinsi</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/kabupaten/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-geo"></i>
                                    </span>
                                    <span class="nav-link-text">Kabupaten</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Advertising & Monetization -->
                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#adsMenu">
                        <span class="nav-icon">
                            <i class="bi bi-megaphone"></i>
                        </span>
                        <span class="nav-link-text">Advertising</span>
                        <span class="submenu-arrow">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </a>
                    <div id="adsMenu" class="collapse submenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/artikeliklan') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-aspect-ratio"></i>
                                    </span>
                                    <span class="nav-link-text">Permintaan Iklan</span>
                                </a>
                            </li>
                            <li class="nav-item has-submenu">
                                <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#popupMenu">
                                    <span class="nav-icon">
                                        <i class="bi bi-window-stack"></i>
                                    </span>
                                    <span class="nav-link-text">Popup Management</span>
                                    <span class="submenu-arrow">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </a>
                                <div id="popupMenu" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('admin/popup') ?>">
                                                <span class="nav-icon">
                                                    <i class="bi bi-window-plus"></i>
                                                </span>
                                                <span class="nav-link-text">Kelola Popup</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('admin/tampilpopup') ?>">
                                                <span class="nav-icon">
                                                    <i class="bi bi-window"></i>
                                                </span>
                                                <span class="nav-link-text">Aktif/Tidak Aktif</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Financial Management -->
                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#financeMenu">
                        <span class="nav-icon">
                            <i class="bi bi-cash-stack"></i>
                        </span>
                        <span class="nav-link-text">Financial</span>
                        <span class="submenu-arrow">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </a>
                    <div id="financeMenu" class="collapse submenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/saldo') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-wallet2"></i>
                                    </span>
                                    <span class="nav-link-text">Saldo</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/saldo/permintaan') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </span>
                                    <span class="nav-link-text">Permintaan Saldo</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- System Management -->
                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#systemMenu">
                        <span class="nav-icon">
                            <i class="bi bi-gear"></i>
                        </span>
                        <span class="nav-link-text">System</span>
                        <span class="submenu-arrow">
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </a>
                    <div id="systemMenu" class="collapse submenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/meta/index') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-card-checklist"></i>
                                    </span>
                                    <span class="nav-link-text">Meta Settings</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/tentang/edit') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-info-circle"></i>
                                    </span>
                                    <span class="nav-link-text">About Page</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/users') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-people-fill"></i>
                                    </span>
                                    <span class="nav-link-text">User Management</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/userRequest') ?>">
                                    <span class="nav-icon">
                                        <i class="bi bi-people-fill"></i>
                                    </span>
                                    <span class="nav-link-text">ACC User Request</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

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