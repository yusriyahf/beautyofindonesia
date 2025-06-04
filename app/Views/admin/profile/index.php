<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>
<?php $role = session()->get('role'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header Section -->
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-gift me-2 text-white"></i> Kelola Profil Pengguna</h1>
                    <p class="mb-0 opacity-75">Kelola Informasi Akun dan Preferensi Anda</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Profile Photo & Quick Info -->
            <div class="col-12 col-lg-4">
                <div class="app-card modern-card h-100 p-4">
                    <!-- Profile Photo Section -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <?php
                            $photoPath = $user['photo_user']
                                ? base_url('uploads/profile/' . $user['photo_user'])
                                : base_url('assets-baru/img/user/default_profil.jpg');
                            ?>

                            <div class="profile-photo-container">
                                <img src="<?= esc($photoPath) ?>"
                                    alt="Foto Profil"
                                    class="profile-photo"
                                    onerror="this.onerror=null; this.src='<?= base_url('assets-baru/img/user/default_profil.jpg') ?>';">

                                <div class="profile-photo-overlay">
                                    <button class="btn btn-primary btn-sm rounded-circle photo-edit-btn"
                                        data-bs-toggle="modal" data-bs-target="#changePhotoModal">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-1 mt-3"><?= esc($user['full_name']); ?></h4>
                        <p class="text-muted mb-3">@<?= esc($user['username']); ?></p>

                        <!-- Role Badge -->
                        <span class="badge badge-role bg-primary bg-gradient px-3 py-2 rounded-pill">
                            <i class="fas fa-user-tag me-1"></i>
                            <?= esc(ucfirst($user['role'])); ?>
                        </span>
                    </div>

                    <!-- Quick Stats -->
                    <div class="quick-stats">
                        <div class="stat-item">
                            <div class="stat-icon bg-success bg-gradient">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-label">Saldo</div>
                                <div class="stat-value text-success">Rp <?= number_format($user['saldo'] ?? 0, 0, ',', '.'); ?></div>
                            </div>
                            <a href="<?= base_url($role . '/saldo'); ?>" class="btn btn-sm btn-outline-success rounded-pill ms-auto">
                                <i class="fas fa-history me-1"></i>Riwayat
                            </a>

                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-<?= $user['is_active'] ? 'success' : 'danger' ?> bg-gradient">
                                <i class="fas <?= $user['is_active'] ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-label">Status Akun</div>
                                <div class="stat-value text-<?= $user['is_active'] ? 'success' : 'danger' ?>">
                                    <?= $user['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                                </div>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-info bg-gradient">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-label">Bergabung sejak</div>
                                <div class="stat-value"><?= date('M Y', strtotime($user['created_at'])); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Profile Information -->
            <div class="col-12 col-lg-8">
                <div class="app-card modern-card p-4">
                    <div class="card-header-modern mb-4">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-circle me-2"></i>Informasi Akun
                        </h5>
                        <div class="card-subtitle">Detail lengkap informasi akun Anda</div>
                    </div>

                    <div class="profile-info-grid">
                        <!-- Username -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Username</label>
                                <div class="info-value"><?= esc($user['username']); ?></div>
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-id-card text-primary"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Nama Lengkap</label>
                                <div class="info-value fw-medium"><?= esc($user['full_name']); ?></div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-envelope text-primary"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Email</label>
                                <div class="info-value d-flex align-items-center">
                                    <?= esc($user['email']); ?>
                                    <span class="badge bg-success bg-opacity-10 text-success ms-2 verified-badge">
                                        <i class="fas fa-check-circle me-1"></i>Terverifikasi
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-phone-alt text-primary"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Kontak</label>
                                <div class="info-value"><?= esc($user['kontak'] ?? 'Belum diisi'); ?></div>
                            </div>
                        </div>

                        <!-- Role Description -->
                        <div class="info-item full-width">
                            <div class="info-icon">
                                <i class="fas fa-user-shield text-primary"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Deskripsi Role</label>
                                <div class="info-value">
                                    <?php
                                    $role_description = '';
                                    switch (strtolower($user['role'])) {
                                        case 'admin':
                                            $role_description = 'Administrator Sistem - Memiliki akses penuh untuk mengelola sistem dan pengguna';
                                            break;
                                        case 'penulis':
                                            $role_description = 'Penulis Konten - Bertanggung jawab untuk membuat dan mengelola konten';
                                            break;
                                        case 'marketing':
                                            $role_description = 'Tim Marketing - Mengelola strategi pemasaran dan promosi';
                                            break;
                                        default:
                                            $role_description = 'Pengguna Biasa - Akses terbatas sesuai dengan kebutuhan';
                                            break;
                                    }
                                    ?>
                                    <?= esc($role_description) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 pt-4 border-top">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="<?= base_url($role . '/profile/edit/' . session()->get('id_user')); ?>" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Edit Profil
                            </a>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fas fa-key me-2"></i>Ubah Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('error') || session()->getFlashdata('success')): ?>
    <div id="flashdata" data-error="<?= session()->getFlashdata('error') ?>" data-success="<?= session()->getFlashdata('success') ?>"></div>
<?php endif; ?>


<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="changePasswordModalLabel">
                    <i class="fas fa-key me-2"></i>Ganti Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= base_url($role . '/profile/update-password') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">

                    <!-- Tampilkan error atau success -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php elseif (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Password Saat Ini -->
                    <div class="mb-4">
                        <label for="current_password" class="form-label fw-medium">Password Saat Ini</label>
                        <div class="input-group input-group-modern">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4">
                        <label for="new_password" class="form-label fw-medium">Password Baru</label>
                        <div class="input-group input-group-modern">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Minimal 8 karakter, mengandung huruf dan angka
                        </div>
                        <div class="mt-2">
                            <div id="password-strength-bar" class="progress" style="height: 6px;">
                                <div id="password-strength-fill" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                            </div>
                            <small id="password-strength-text" class="text-muted">Kekuatan password: -</small>
                        </div>

                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label fw-medium">Konfirmasi Password Baru</label>
                        <div class="input-group input-group-modern">
                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Ganti Foto Profil -->
<div class="modal fade" id="changePhotoModal" tabindex="-1" aria-labelledby="changePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="changePhotoModalLabel">
                    <i class="fas fa-camera me-2"></i>Ganti Foto Profil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin/profile/update-photo') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body p-4 text-center">
                    <div class="photo-upload-area mb-4">
                        <img id="photoPreview" src="<?= esc($photoPath) ?>"
                            class="preview-image mb-3">

                        <div class="upload-zone" id="uploadZone">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <p class="upload-text mb-2">Klik untuk memilih foto atau seret ke sini</p>
                            <p class="upload-hint">Format: JPG, PNG, GIF (Max: 2MB)</p>
                            <input type="file" class="form-control d-none" id="photo_user" name="photo_user" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-upload me-2"></i>Unggah Foto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
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

    /* Badge Styles */
    .badge-role {
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .verified-badge {
        font-size: 0.75rem;
        border-radius: 20px;
        padding: 0.25rem 0.75rem;
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

    /* Profile Info Grid */
    .profile-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 15px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .info-item.full-width {
        grid-column: 1 / -1;
    }

    .info-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.1), rgba(13, 110, 253, 0.05));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
        min-width: 0;
    }

    .info-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem;
        color: #2c3e50;
        font-weight: 500;
        word-wrap: break-word;
    }

    /* Avatar */
    .avatar-lg {
        width: 60px;
        height: 60px;
    }

    /* Modal Styles */
    .modern-modal .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-info)) !important;
    }

    .input-group-modern {
        border-radius: 12px;
        overflow: hidden;
    }

    .input-group-modern .input-group-text {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border: none;
        color: var(--bs-primary);
        font-weight: 600;
    }

    .input-group-modern .form-control {
        border: 2px solid #e9ecef;
        border-left: none;
        transition: all 0.3s ease;
    }

    .input-group-modern .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    /* Photo Upload Area */
    .photo-upload-area {
        position: relative;
    }

    .preview-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .upload-zone {
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
    }

    .upload-zone:hover {
        border-color: var(--bs-primary);
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.05), rgba(13, 110, 253, 0.02));
    }

    .upload-icon {
        font-size: 3rem;
        color: var(--bs-primary);
        margin-bottom: 1rem;
    }

    .upload-text {
        font-weight: 600;
        color: #2c3e50;
    }

    .upload-hint {
        font-size: 0.85rem;
        color: #6c757d;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-info-grid {
            grid-template-columns: 1fr;
        }

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

        .info-item {
            padding: 1rem;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modern-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .info-item:nth-child(even) {
        animation-delay: 0.1s;
    }

    .info-item:nth-child(odd) {
        animation-delay: 0.2s;
    }
</style>

<script>
    // Toggle show/hide password
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Upload zone interaction
    document.getElementById('uploadZone').addEventListener('click', function() {
        document.getElementById('photo_user').click();
    });

    // Preview photo before upload
    document.getElementById('photo_user').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                this.value = '';
                return;
            }

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('photoPreview').src = event.target.result;
            }
            reader.readAsDataURL(file);

            // Hide upload zone, show preview
            document.getElementById('uploadZone').style.display = 'none';
        }
    });

    // Drag and drop functionality
    const uploadZone = document.getElementById('uploadZone');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        uploadZone.classList.add('border-primary');
    }

    function unhighlight(e) {
        uploadZone.classList.remove('border-primary');
    }

    uploadZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            document.getElementById('photo_user').files = files;
            document.getElementById('photo_user').dispatchEvent(new Event('change', {
                bubbles: true
            }));
        }
    }

    // Password strength indicator
    document.getElementById('new_password').addEventListener('input', function() {
        const password = this.value;
        const strength = getPasswordStrength(password);
        // You can add visual indicator here
    });

    function getPasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        return strength;
    }

    // Form validation
    document.querySelector('#changePasswordModal form').addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Password baru dan konfirmasi password tidak cocok.');
            return false;
        }

        if (newPassword.length < 8) {
            e.preventDefault();
            alert('Password minimal 8 karakter.');
            return false;
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const flashdata = document.getElementById('flashdata');
        if (flashdata) {
            const error = flashdata.dataset.error;
            const success = flashdata.dataset.success;
            if (error || success) {
                const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                modal.show();
            }
        }
    });

    document.getElementById('new_password').addEventListener('input', function() {
        const password = this.value;
        const strength = getPasswordStrength(password);
        updatePasswordStrengthUI(strength);
    });

    function getPasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        return strength;
    }

    function updatePasswordStrengthUI(strength) {
        const bar = document.getElementById('password-strength-fill');
        const text = document.getElementById('password-strength-text');

        const levels = [{
                width: '0%',
                color: '',
                label: 'Terlalu Lemah'
            },
            {
                width: '20%',
                color: 'bg-danger',
                label: 'Lemah'
            },
            {
                width: '40%',
                color: 'bg-warning',
                label: 'Cukup'
            },
            {
                width: '60%',
                color: 'bg-info',
                label: 'Sedang'
            },
            {
                width: '80%',
                color: 'bg-primary',
                label: 'Kuat'
            },
            {
                width: '100%',
                color: 'bg-success',
                label: 'Sangat Kuat'
            }
        ];

        const level = levels[strength];
        bar.className = `progress-bar ${level.color}`;
        bar.style.width = level.width;
        text.textContent = `Kekuatan password: ${level.label}`;
    }
</script>

<?= $this->endSection(); ?>