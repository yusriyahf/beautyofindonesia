<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>
<?php $role = session()->get('role'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-user-edit me-2 text-white"></i> Edit Profil Pengguna</h1>
                    <p class="mb-0 opacity-75">Perbarui informasi akun dan preferensi Anda</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= base_url('/admin/profile'); ?>" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Profile Photo Card -->
            <div class="col-12 col-lg-4">
                <div class="app-card modern-card h-100 p-4">
                    <!-- Profile Photo Section -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <?php
                            $photoPath = !empty($user['photo_user'])
                                ? base_url($user['photo_user'])
                                : base_url('assets-baru/img/user/default_profil.jpg');
                            ?>

                            <div class="profile-photo-container">
                                <img src="<?= esc($photoPath) ?>"
                                    alt="Foto Profil"
                                    class="profile-photo"
                                    id="profilePreview"
                                    onerror="this.onerror=null; this.src='<?= base_url('assets-baru/img/user/default_profil.jpg') ?>';">

                                <div class="profile-photo-overlay">
                                    <button class="btn btn-primary btn-sm rounded-circle photo-edit-btn"
                                        onclick="document.getElementById('profilePictureInput').click()">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-1 mt-3"><?= esc($user['username']); ?></h4>
                        <p class="text-muted mb-3">@<?= esc($user['username']); ?></p>
                    </div>

                    <!-- Quick Info -->
                    <div class="quick-stats">
                        <div class="stat-item">
                            <div class="stat-icon bg-info bg-gradient">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-label">Role</div>
                                <div class="stat-value"><?= esc($user['role']); ?></div>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-success bg-gradient">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-label">Terakhir Diupdate</div>
                                <div class="stat-value"><?= date('d M Y'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="col-12 col-lg-8">
                <div class="app-card modern-card p-4">
                    <div class="card-header-modern mb-4">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-edit me-2"></i>Form Edit Profil
                        </h5>
                        <div class="card-subtitle">Lengkapi form berikut untuk memperbarui profil</div>
                    </div>

                    <?php if (session()->has('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <form action="<?= base_url($role.'/profile/update/' . session()->get('id_user')); ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <input type="file" name="photo_user" id="profilePictureInput" class="form-control-file d-none" accept="image/*" onchange="previewImage(this)">
                        <input type="hidden" name="photo_user_removed" id="photoUserRemoved" value="0">

                        <div class="row g-3">
                            <!-- Username -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="username" name="username" 
                                        value="<?= esc($user['username']); ?>" placeholder="Username" required>
                                    <label for="username">Username</label>
                                </div>
                            </div>

                            <!-- Full Name -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="full_name" name="full_name" 
                                        value="<?= esc($user['full_name']); ?>" placeholder="Nama Lengkap" required>
                                    <label for="full_name">Nama Lengkap</label>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" 
                                        value="<?= esc($user['email'] ?? ''); ?>" placeholder="Email">
                                    <label for="email">Email</label>
                                </div>
                            </div>

                            <!-- Kontak -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="kontak" name="kontak" 
                                        value="<?= esc($user['kontak'] ?? ''); ?>" placeholder="Nomor Kontak">
                                    <label for="kontak">Nomor Kontak</label>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" 
                                        placeholder="Password">
                                    <label for="password">Password Baru</label>
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                                </div>
                            </div>

                            <!-- Bank Account -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="rekening" name="rekening" 
                                        value="<?= esc($user['bank_account_number'] ?? ''); ?>" placeholder="Nomor Rekening">
                                    <label for="rekening">Nomor Rekening</label>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="deskripsi" name="deskripsi_profile" 
                                        placeholder="Deskripsi" style="height: 100px"><?= esc($user['deskripsi_profile"'] ?? ''); ?></textarea>
                                    <label for="deskripsi">Deskripsi Profil</label>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 w-100">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-info)) !important;
    }

    /* Modern Card Styles */
    .modern-card {
        background: #fff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-info));
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    /* Profile Photo Styles */
    .profile-photo-container {
        position: relative;
        display: inline-block;
    }

    .profile-photo {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
        border: 6px solid #fff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .profile-photo-overlay {
        position: absolute;
        bottom: 10px;
        right: 10px;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .profile-photo-container:hover .profile-photo-overlay {
        opacity: 1;
    }

    .profile-photo-container:hover .profile-photo {
        transform: scale(1.05);
    }

    .photo-edit-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Quick Stats */
    .quick-stats {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 15px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.2rem;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
    }

    /* Card Header Modern */
    .card-header-modern {
        border-bottom: 2px solid #f1f3f4;
        padding-bottom: 1rem;
    }

    .card-title {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.3rem;
    }

    .card-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    /* Form Styles */
    .form-floating label {
        color: #6c757d;
    }

    .form-control {
        border-radius: 12px;
        padding: 1rem 1rem;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modern-card {
            border-radius: 15px;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
        }

        .stat-item {
            padding: 1rem;
        }

        .dashboard-header .btn {
            margin-top: 1rem;
            width: 100%;
        }
    }
</style>

<script>
    // Preview uploaded image
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
                document.getElementById('photoUserRemoved').value = "0";
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove picture functionality
    function removePicture() {
        document.getElementById('profilePreview').src = '<?= base_url('assets-baru/img/user/default_profil.jpg') ?>';
        document.getElementById('profilePictureInput').value = '';
        document.getElementById('photoUserRemoved').value = "1";
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<?= $this->endSection(); ?>