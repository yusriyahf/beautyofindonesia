<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">
                    <i class="bi bi-person-plus me-2 text-primary"></i>Tambah User Baru
                </h1>
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Manajemen User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Baru</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto ms-auto">
                <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="app-card app-card-settings shadow-sm p-4">
            
            <div class="app-card-body">
                <form action="<?= base_url('admin/users/proses_tambah') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?= csrf_field(); ?>

                    <div class="row g-4">
                        <!-- Left Column -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-none mb-4">
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold mb-3">
                                        <i class="bi bi-person-badge me-2"></i>Informasi Dasar
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                                name="username" value="<?= old('username') ?>" placeholder="contoh: johndoe" required>
                                            <?php if(session('errors.username')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.username') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                                                name="email" value="<?= old('email') ?>" placeholder="contoh: email@domain.com" required>
                                            <?php if(session('errors.email')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.email') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-card-heading"></i></span>
                                            <input type="text" class="form-control <?= session('errors.full_name') ? 'is-invalid' : '' ?>" 
                                                name="full_name" value="<?= old('full_name') ?>" placeholder="Nama lengkap user" required>
                                            <?php if(session('errors.full_name')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.full_name') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-none mb-4">
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold mb-3">
                                        <i class="bi bi-shield-lock me-2"></i>Hak Akses & Keamanan
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person-gear"></i></span>
                                            <select class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>" name="role" required>
                                                <option value="">-- Pilih Role --</option>
                                                <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="penulis" <?= old('role') == 'penulis' ? 'selected' : '' ?>>Penulis</option>
                                                <option value="marketing" <?= old('role') == 'marketing' ? 'selected' : '' ?>>Marketing</option>
                                            </select>
                                            <?php if(session('errors.role')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.role') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                            <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                                                name="password" id="password" placeholder="Minimal 8 karakter" required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <?php if(session('errors.password')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.password') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small id="passwordHelp" class="text-muted"></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Row -->
                        <div class="col-12">
                            <div class="card border-0 shadow-none">
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold mb-3">
                                        <i class="bi bi-image me-2"></i>Foto Profil & Informasi Tambahan
                                    </h5>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Foto Profil</label>
                                                <div class="d-flex align-items-start gap-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type="file" id="fotoInput" name="foto" accept="image/*" class="d-none" style="margin-right: 4%;">
                                                                <label for="fotoInput" class="btn btn-sm btn-primary rounded-circle">
                                                                    <i class="bi bi-camera"></i>
                                                                </label>
                                                            </div>
                                                            <div class="avatar-preview">
                                                                <div id="imagePreview" style="background-image: url('<?= base_url('assets/admin/img/default-avatar.png') ?>');"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted d-block">Ukuran maksimal 2MB. Format: JPG, PNG, JPEG</small>
                                                        <?php if(session('errors.foto')) : ?>
                                                            <div class="text-danger small mt-1">
                                                                <?= session('errors.foto') ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="bank_account_number" class="form-label">Nomor Rekening</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i class="bi bi-credit-card"></i></span>
                                                    <input type="text" class="form-control <?= session('errors.bank_account_number') ? 'is-invalid' : '' ?>" 
                                                        name="bank_account_number" value="<?= old('bank_account_number') ?>" placeholder="Opsional">
                                                    <?php if(session('errors.bank_account_number')) : ?>
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.bank_account_number') ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-4 mt-3">
                        <button type="reset" class="btn btn-outline-danger">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .app-card-settings {
        border-radius: 0.75rem;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    .app-card-header {
        border-bottom: 2px solid rgba(78, 115, 223, 0.3);
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .input-group-text {
        transition: all 0.3s;
    }
    .card-title {
        font-size: 1.1rem;
        color: #4e73df;
    }
    .avatar-upload {
        position: relative;
        max-width: 120px;
    }
    .avatar-edit {
        position: absolute;
        right: 10px;
        bottom: 10px;
        z-index: 1;
    }
    .avatar-edit label {
        height: 42px;
        margin-bottom: 0;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        text-align: center;
        line-height: 34px;
    }
    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 3px solid #f3f6f9;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .avatar-preview div {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    .progress {
        background-color: #f0f3f7;
    }
    .progress-bar {
        transition: width 0.5s ease;
    }
</style>

<script>
    // Password toggle
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    // Password strength indicator
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('passwordHelp');
        
        // Reset
        strengthBar.style.width = '0%';
        strengthBar.className = 'progress-bar';
        strengthText.className = 'text-muted';
        
        if (password.length === 0) {
            strengthText.textContent = '';
            return;
        }
        
        // Calculate strength
        let strength = 0;
        if (password.length > 7) strength += 1;
        if (password.match(/[a-z]/)) strength += 1;
        if (password.match(/[A-Z]/)) strength += 1;
        if (password.match(/[0-9]/)) strength += 1;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
        
        // Update UI
        const width = (strength / 5) * 100;
        strengthBar.style.width = `${width}%`;
        
        if (strength < 2) {
            strengthBar.classList.add('bg-danger');
            strengthText.textContent = 'Lemah';
            strengthText.className = 'text-danger';
        } else if (strength < 4) {
            strengthBar.classList.add('bg-warning');
            strengthText.textContent = 'Sedang';
            strengthText.className = 'text-warning';
        } else {
            strengthBar.classList.add('bg-success');
            strengthText.textContent = 'Kuat';
            strengthText.className = 'text-success';
        }
    });

    // Image preview
    document.getElementById('fotoInput').addEventListener('change', function() {
        const preview = document.getElementById('imagePreview');
        const file = this.files[0];
        if (file) {
            if (file.size > 2000000) { // 2MB
                alert('Ukuran file terlalu besar. Maksimal 2MB');
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.style.backgroundImage = `url(${e.target.result})`;
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.backgroundImage = `url('<?= base_url('assets/admin/img/default-avatar.png') ?>')`;
        }
    });

    // Form validation
    (function() {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
    })();
</script>

<?= $this->endSection(); ?>