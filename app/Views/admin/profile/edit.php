<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Edit Profil Pengguna</h1>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('/admin/profile'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Profile Picture Card (Left Side) -->
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
                            <!-- Menampilkan foto profil yang sedang dipakai -->
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

                        <div class="mb-3">
                            <!-- Input file untuk mengunggah foto -->
                            <label for="profilePictureInput" class="btn btn-primary btn-sm">
                                <i class="fas fa-upload me-1"></i>Unggah Foto
                            </label>
                            <!-- Tombol untuk menghapus foto -->
                            <button class="btn btn-outline-danger btn-sm" id="removePictureBtn">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>

                            <script>
                                document.getElementById("removePictureBtn").addEventListener("click", function() {
                                    // Set nilai hidden input menjadi 1 untuk menandai penghapusan
                                    document.getElementById("photoUserRemoved").value = "1";

                                    // Kosongkan preview dan input file
                                    document.getElementById("profilePreview").src = "<?= base_url('assets-baru/img/user/default_profil.jpg') ?>";
                                    document.getElementById("profilePictureInput").value = null;
                                });
                            </script>
                        </div>

                        <div class="text-muted small">
                            <p class="mb-1">Format: JPG, PNG</p>
                            <p class="mb-0">Ukuran maks: 2MB</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Edit Form Card (Right Side) -->
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start p-4 border-0">
                    <div class="app-card-header p-0 mb-4 border-0 bg-transparent">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-edit me-2"></i>Edit Informasi Akun
                        </h5>
                        <div class="border-bottom mt-2" style="width: 60px; border-color: var(--primary) !important;"></div>
                    </div>

                    <div class="app-card-body w-100 p-0">
                        <?php if (session()->has('errors')) : ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session('errors') as $error) : ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>
                        <form action="<?= base_url('admin/profile/update'); ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <input type="file" name="photo_user" id="profilePictureInput" class="form-control-file d-none" accept="image/*">

                            <!-- Hidden field for profile picture -->
                            <input type="hidden" name="photo_user_removed" id="photoUserRemoved" value="0">

                            <!-- Username -->
                            <div class="row mb-3 py-2 align-items-center bg-light rounded">
                                <label class="col-sm-4 col-form-label fw-bold text-muted">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" name="username" class="form-control" value="<?= esc($user[0]['username']); ?>" placeholder="<?= esc($user[0]['username']); ?>" required>
                                </div>
                            </div>

                            <!-- Full Name -->
                            <div class="row mb-3 py-2 align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold text-muted">Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text" name="full_name" class="form-control" value="<?= esc($user[0]['full_name']); ?>" placeholder="<?= esc($user[0]['full_name']); ?>" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="row mb-3 py-2 align-items-center bg-light rounded">
                                <label class="col-sm-4 col-form-label fw-bold text-muted">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" name="email" class="form-control" value="<?= esc($user[0]['email']); ?>" placeholder="<?= esc($user[0]['email']); ?>" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="row mb-3 py-2 align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold text-muted">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password Baru">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                                </div>
                            </div>

                            <!-- Kontak -->
                            <div class="row mb-3 py-2 align-items-center bg-light rounded">
                                <label class="col-sm-4 col-form-label fw-bold text-muted">Kontak</label>
                                <div class="col-sm-8">
                                    <input type="text" name="kontak" class="form-control" value="<?= esc($user[0]['kontak']); ?>" placeholder="<?= esc($user[0]['kontak']); ?>" required>
                                </div>
                            </div>

                            <!-- No Rekening -->
                            <div class="row mb-3 py-2 align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold text-muted">No. Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" name="rekening" class="form-control" value="<?= esc($user[0]['bank_account_number']); ?>" placeholder="<?= esc($user[0]['bank_account_number']); ?>" required>
                                </div>
                            </div>



                            <div class="row mb-4 mt-4">
                                <div class="col-sm-8 offset-sm-4">
                                    <button type="submit" class="btn btn-primary w-100 py-2">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//col-->
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

    /* Profile picture card specific styling */
    #profilePictureInput+label {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    #profilePictureInput+label:hover {
        transform: translateY(-1px);
    }

    #removePictureBtn {
        transition: all 0.2s ease;
    }

    #removePictureBtn:hover {
        transform: translateY(-1px);
    }

    /* Form styling */
    .form-control {
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    /* Alternate row background */
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>

<script>
    // Preview uploaded image
    document.getElementById('profilePictureInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.querySelector('.app-card img').src = event.target.result;
                document.getElementById('photoUserRemoved').value = "0";
            }
            reader.readAsDataURL(file);
        }
    });

    // Remove picture functionality
    document.getElementById('removePictureBtn').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('.app-card img').src = '<?= base_url('assets/img/default-profile.png') ?>';
        document.getElementById('profilePictureInput').value = '';
        document.getElementById('photoUserRemoved').value = "1";
    });
</script>

<?= $this->endSection(); ?>