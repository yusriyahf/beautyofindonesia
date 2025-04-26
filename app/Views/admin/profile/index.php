<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Profil Pengguna</h1>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('/admin/profile/edit'); ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Profil
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start p-4 border-0">
                    <div class="app-card-header p-0 mb-4 border-0 bg-transparent">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-user-circle me-2"></i>Informasi Akun
                        </h5>
                        <div class="border-bottom mt-2" style="width: 60px; border-color: var(--primary) !important;"></div>
                    </div>


                    <div class="app-card-body w-100 p-0">
                        <!-- Add var_dump here to inspect the $user data -->
                        <div class="row mb-3 py-2 align-items-center bg-light rounded">
                            <label class="col-sm-4 col-form-label fw-bold text-muted">Username</label>
                            <div class="col-sm-8">
                                <p><?= esc(isset($user['username']) ? $user['username'] : (isset($user[0]['username']) ? $user[0]['username'] : 'No username')); ?></p>
                            </div>
                        </div>

                        <div class="row mb-3 py-2 align-items-center bg-light rounded">
                            <label class="col-sm-4 col-form-label fw-bold text-muted">Full Name</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext fw-medium"><?= esc(isset($user->full_name) ? $user->full_name : (isset($user[0]['full_name']) ? $user[0]['full_name'] : 'Icha Dewi Putriana')); ?></p>
                            </div>
                        </div>

                        <div class="row mb-3 py-2 align-items-center">
                            <label class="col-sm-4 col-form-label fw-bold text-muted">Email</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">
                                    <?= esc(isset($user->email) ? $user->email : (isset($user[0]['email']) ? $user[0]['email'] : 'ichi@example.com')); ?>
                                    <span class="badge bg-success-soft ms-2">
                                        <i class="fas fa-check-circle text-success me-1"></i>Terverifikasi
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3 py-2 align-items-center bg-light rounded">
                            <label class="col-sm-4 col-form-label fw-bold text-muted">Password</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">********</p>
                                <a href="<?= base_url('/admin/profile/change-password'); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-key me-1"></i>Ubah Password
                                </a>
                            </div>
                        </div>

                        <div class="row mb-3 py-2 align-items-center">
                            <label class="col-sm-4 col-form-label fw-bold text-muted">Role</label>
                            <div class="col-sm-8">
                                <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 rounded-pill">
                                    <i class="fas fa-user-shield me-1"></i><?= esc(isset($user->role) ? $user->role : (isset($user[0]['role']) ? $user[0]['role'] : 'p')); ?>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3 py-2 align-items-center bg-light rounded">
                            <label class="col-sm-4 col-form-label fw-bold text-muted">Kontak</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">
                                    <i class="fas fa-phone-alt me-2 text-muted"></i><?= esc(isset($user->contact) ? $user->contact : (isset($user[0]['contact']) ? $user[0]['contact'] : '99999')); ?>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3 py-2 align-items-center">
                            <label class="col-sm-4 col-form-label fw-bold text-muted">No. Rekening</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">
                                    <i class="fas fa-credit-card me-2 text-muted"></i><?= esc(isset($user->bank_account_number) ? $user->bank_account_number : (isset($user[0]['bank_account_number']) ? $user[0]['bank_account_number'] : 'ppppp')); ?>
                                    <span class="badge bg-info-soft ms-2">
                                        <i class="fas fa-university text-info me-1"></i>BCA
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row py-2 align-items-center bg-light rounded">
                            <label class="col-sm-4 col-form-label fw-bold text-muted">Saldo</label>
                            <div class="col-sm-8">
                                <div class="d-flex align-items-center">
                                    <span class="bg-success bg-opacity-10 text-success p-2 rounded me-3">
                                        <i class="fas fa-wallet fs-5"></i>
                                    </span>
                                    <p class="form-control-plaintext text-success fw-bold mb-0 fs-5">
                                        Rp <?= number_format(isset($user->saldo) ? $user->saldo : (isset($user[0]['saldo']) ? $user[0]['saldo'] : 0), 0, ',', '.'); ?>
                                    </p>
                                    <button class="btn btn-sm btn-success ms-auto w-100">
                                        <i class="fas fa-plus me-1"></i>Lihat Saldo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!--//app-card-body-->
            </div><!--//app-card-->

            <!-- Additional Info Column -->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start p-4 border-0 h-100">
                    <div class="app-card-header p-0 mb-4 border-0 bg-transparent">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-image me-2"></i>Foto Profil
                        </h5>
                        <div class="border-bottom mt-2" style="width: 60px; border-color: var(--primary) !important;"></div>
                    </div>

                    <div class="app-card-body w-100 p-0 text-center">
                        <div class="position-relative mx-auto mb-3">
                            <?php
                            $photoUser = session()->get('photo_user');
                            $photoPath = !empty($photoUser)
                                ? $photoUser
                                : base_url('assets-baru/img/user/default_profil.jpg');
                            ?>

                            <img src="<?= esc($photoPath) ?>"
                                alt="Foto Profil"
                                class="img-fluid rounded-circle shadow-sm border border-3 border-white"
                                style="width: 180px; height: 180px; object-fit: cover;"
                                onerror="this.onerror=null; this.src='<?= base_url('assets-baru/img/user/default_profil.jpg') ?>';">

                        </div>
                    </div>



                    <div class="app-card-header p-0 mb-4 border-0 bg-transparent">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-info-circle me-2 mt-4"></i>Informasi Tambahan
                        </h5>
                        <div class="border-bottom mt-2" style="width: 60px; border-color: var(--primary) !important;"></div>
                    </div>

                    <div class="app-card-body w-100 p-0">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                                <i class="fas fa-calendar-alt fs-5"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small">Bergabung sejak</p>
                                <p class="mb-0 fw-bold">
                                    <?= esc(isset($user->created_at)
                                        ? date('d F Y', strtotime($user->created_at))
                                        : (isset($user[0]['created_at'])
                                            ? date('d F Y', strtotime($user[0]['created_at']))
                                            : 'Tanggal tidak tersedia')); ?>

                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle me-3">
                                <i class="fas fa-user-tag fs-5"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small">Hak Akses</p>
                                <p class="mb-0 fw-bold">
                                    <?php
                                    $user_role = isset($user->role) ? $user->role : (isset($user[0]['role']) ? $user[0]['role'] : 'Guest');

                                    switch (strtolower($user_role)) {
                                        case 'admin':
                                            $role_description = 'Akses penuh ke semua fitur sistem';
                                            break;
                                        case 'penulis':
                                            $role_description = 'Akses ke pembuatan dan manajemen artikel';
                                            break;
                                        case 'marketing':
                                            $role_description = 'Akses ke data promosi dan statistik penjualan';
                                            break;
                                        default:
                                            $role_description = 'Akses terbatas ke fitur dasar';
                                            break;
                                    }
                                    ?>
                                    <?= esc(ucfirst($role_description)) ?>
                                </p>

                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle me-3">
                                <i class="fas fa-shield-alt fs-5"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small">Status Akun</p>
                                <p class="mb-0 fw-bold">
                                    <?php
                                    $is_active = isset($user->is_active) ? $user->is_active : (isset($user[0]['is_active']) ? $user[0]['is_active'] : '0');
                                    ?>

                                    <span class="badge py-2 px-3 rounded-pill <?= $is_active == '1' ? 'bg-success' : 'bg-danger' ?>">
                                        <i class="fas <?= $is_active == '1' ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                                        <?= $is_active == '1' ? 'Aktif' : 'Tidak Aktif' ?>
                                    </span>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--//row-->

    </div><!--//container-xl-->
</div><!--//app-content-->

<style>
    /* Custom CSS Enhancements */
    .app-card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .app-card:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .form-control-plaintext {
        padding: 0.5rem 0;
    }

    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .bg-info-soft {
        background-color: rgba(13, 202, 240, 0.1);
        color: #0dcaf0;
    }

    .bg-primary-soft {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }

    .rounded-lg {
        border-radius: 1rem;
    }

    .border-light {
        border-color: #f8f9fa !important;
    }

    /* Default profile image styling */
    .default-profile-img {
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-weight: bold;
    }
</style>

<?= $this->endSection(); ?>