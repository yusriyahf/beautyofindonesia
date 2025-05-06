<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">
                    <i class="bi bi-person-gear me-2 text-primary"></i>Edit User
                </h1>
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Manajemen User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-header bg-primary bg-opacity-10 p-3 rounded mb-4">
                        <h4 class="mb-0 text-primary">
                            <i class="bi bi-pencil-square me-2"></i>Form Edit User
                        </h4>
                    </div>
                    
                    <div class="app-card-body">
                        <form action="<?= base_url('admin/users/proses_edit/' . $users->id_user) ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            
                            <div class="row g-3">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                                id="username" name="username" value="<?= old('username', $users->username) ?>" required>
                                        </div>
                                        <?php if(session('errors.username')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= session('errors.username') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                                                id="email" name="email" value="<?= old('email', $users->email) ?>" required>
                                        </div>
                                        <?php if(session('errors.email')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= session('errors.email') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-card-heading"></i></span>
                                            <input type="text" class="form-control <?= session('errors.full_name') ? 'is-invalid' : '' ?>" 
                                                id="full_name" name="full_name" value="<?= old('full_name', $users->full_name) ?>" required>
                                        </div>
                                        <?php if(session('errors.full_name')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= session('errors.full_name') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
                                            <select class="form-select <?= session('errors.role') ? 'is-invalid' : '' ?>" 
                                                id="role" name="role" required>
                                                <option value="">-- Pilih Role --</option>
                                                <option value="admin" <?= old('role', $users->role) == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="penulis" <?= old('role', $users->role) == 'penulis' ? 'selected' : '' ?>>Penulis</option>
                                                <option value="marketing" <?= old('role', $users->role) == 'marketing' ? 'selected' : '' ?>>Marketing</option>
                                            </select>
                                        </div>
                                        <?php if(session('errors.role')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= session('errors.role') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="bank_account_number" class="form-label">Nomor Rekening</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-credit-card"></i></span>
                                            <input type="text" class="form-control <?= session('errors.bank_account_number') ? 'is-invalid' : '' ?>" 
                                                id="bank_account_number" name="bank_account_number" 
                                                value="<?= old('bank_account_number', $users->bank_account_number) ?>">
                                        </div>
                                        <?php if(session('errors.bank_account_number')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= session('errors.bank_account_number') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Foto Profil</label>
                                        <input type="file" class="form-control <?= session('errors.foto') ? 'is-invalid' : '' ?>" 
                                            id="foto" name="foto" accept="image/*">
                                        <?php if(session('errors.foto')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= session('errors.foto') ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($users->photo_user) : ?>
                                            <small class="text-muted d-block mt-1">Foto saat ini: <?= $users->foto ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Success Message -->
                            <?php if(session()->getFlashdata('success')) : ?>
                                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between pt-4 mt-3 border-top">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- User Photo Preview -->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-settings shadow-sm p-4 h-100">
                    <div class="app-card-header bg-primary bg-opacity-10 p-3 rounded mb-4">
                        <h4 class="mb-0 text-primary">
                            <i class="bi bi-image me-2"></i>Foto Profil
                        </h4>
                    </div>
                    <div class="app-card-body d-flex flex-column align-items-center">
                        <div class="avatar-upload-preview mb-3">
                            <?php if($users->photo_user) : ?>
                                <img src="<?= base_url('uploads/users/' . $users->photo_user) ?>" class="img-thumbnail rounded-circle" style="width: 200px; height: 200px; object-fit: cover;" alt="Current Photo">
                            <?php else : ?>
                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 200px; height: 200px;">
                                    <i class="bi bi-person text-muted" style="font-size: 5rem;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted text-center">Upload foto baru akan mengganti foto yang ada</small>
                    </div>
                </div>
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
    .avatar-upload-preview {
        border: 3px solid #f3f6f9;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .avatar-placeholder {
        border: 3px dashed #dee2e6;
    }
</style>

<script>
    // Image preview for new photo upload
    document.getElementById('foto').addEventListener('change', function(e) {
        const preview = document.querySelector('.avatar-upload-preview');
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail rounded-circle" style="width: 200px; height: 200px; object-fit: cover;" alt="Preview">`;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?= $this->endSection('content') ?>