<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-info-circle me-2 text-white"></i> Pengaturan Tentang</h1>
                    <p class="mb-0 opacity-75">Kelola informasi tentang perusahaan/organisasi Anda</p>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>
                        <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>
                        <strong>Sukses!</strong> <?= session()->getFlashdata('success') ?>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <div class="row gy-4">
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-settings shadow-sm p-4 rounded-4">
                    <div class="app-card-body">
                        <form action="<?= base_url('admin/tentang/edit'); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="mb-4">
                                <h5 class="mb-3 text-primary"><i class="fas fa-building me-2"></i> Informasi Dasar</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_tentang" class="form-label">Nama Tentang</label>
                                        <input type="text" class="form-control rounded-pill" id="nama_tentang" name="nama_tentang" value="<?= esc($tentang->nama_tentang) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="slogan" class="form-label">Slogan</label>
                                        <input type="text" class="form-control rounded-pill" id="slogan" name="slogan" value="<?= esc($tentang->slogan) ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi_tentang" class="form-label">Deskripsi (ID)</label>
                                    <textarea class="form-control tiny" id="deskripsi_tentang" name="deskripsi_tentang" rows="5"><?= esc($tentang->deskripsi_tentang) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi_tentang_en" class="form-label">Deskripsi (EN)</label>
                                    <textarea class="form-control tiny" id="deskripsi_tentang_en" name="deskripsi_tentang_en" rows="5"><?= esc($tentang->deskripsi_tentang_en) ?></textarea>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3 text-primary"><i class="fas fa-address-card me-2"></i> Kontak</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control rounded-pill" id="alamat" name="alamat" value="<?= esc($tentang->alamat) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="no_telp" class="form-label">No Telp/HP</label>
                                        <input type="text" class="form-control rounded-pill" id="no_telp" name="no_telp" value="<?= esc($tentang->no_telp) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control rounded-pill" id="email" name="email" value="<?= esc($tentang->email) ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3 text-primary"><i class="fas fa-share-alt me-2"></i> Media Sosial</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <div class="input-group">
                                            <span class="input-group-text rounded-start-pill"><i class="fab fa-instagram"></i></span>
                                            <input type="url" class="form-control rounded-end-pill" id="instagram" name="instagram" value="<?= esc($tentang->instagram) ?>" placeholder="https://instagram.com/username">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tiktok" class="form-label">TikTok</label>
                                        <div class="input-group">
                                            <span class="input-group-text rounded-start-pill"><i class="fab fa-tiktok"></i></span>
                                            <input type="url" class="form-control rounded-end-pill" id="tiktok" name="tiktok" value="<?= esc($tentang->tiktok) ?>" placeholder="https://tiktok.com/@username">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="youtube" class="form-label">YouTube</label>
                                        <div class="input-group">
                                            <span class="input-group-text rounded-start-pill"><i class="fab fa-youtube"></i></span>
                                            <input type="url" class="form-control rounded-end-pill" id="youtube" name="youtube" value="<?= esc($tentang->youtube) ?>" placeholder="https://youtube.com/channel/...">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3 text-primary"><i class="fas fa-image me-2"></i> Gambar & Footer</h5>
                                <div class="mb-3">
                                    <label for="foto_tentang" class="form-label">Foto Tentang</label>
                                    <input type="hidden" name="old_foto_tentang" value="<?= esc($tentang->foto_tentang) ?>">
                                    <input type="file" class="form-control" id="foto_tentang" name="foto_tentang" accept="image/*">
                                    <?php if (!empty($tentang_pengguna[0]['foto_tentang'])): ?>
                                        <div class="mt-2">
                                            <img width="150px" class="img-thumbnail rounded-3" src="<?= base_url('assets-baru/img/' . $tentang->foto_tentang); ?>">
                                            <small class="d-block text-muted mt-1">Gambar saat ini</small>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="footer" class="form-label">Footer</label>
                                    <input type="text" class="form-control rounded-pill" id="footer" name="footer" value="<?= esc($tentang->footer) ?>">
                                    <small class="text-muted">*Template ini gratis selama Anda tetap menyimpan credit link/attribution link/backlink penulis footernya...</small>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//col-->

            <!-- Preview Section -->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-settings shadow-sm p-4 rounded-4 h-100">
                    <div class="app-card-body">
                        <h5 class="mb-3 text-primary"><i class="fas fa-eye me-2"></i> Preview</h5>
                        
                        <?php if (!empty($tentang_pengguna[0]['foto_tentang'])): ?>
                            <div class="text-center mb-3">
                                <img src="<?= base_url('assets-baru/img/' . $tentang->foto_tentang); ?>" class="img-fluid rounded-3 shadow-sm" alt="Preview Foto">
                            </div>
                        <?php endif; ?>
                        
                        <h4 class="mb-2"><?= esc($tentang->nama_tentang) ?></h4>
                        <p class="text-muted mb-3"><?= esc($tentang->slogan) ?></p>
                        
                        <div class="mb-3">
                            <h6 class="text-primary">Deskripsi:</h6>
                            <div class="border p-3 rounded-3 bg-light">
                                <?= $tentang->deskripsi_tentang ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-primary">Kontak:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <?= esc($tentang->alamat) ?>
                                </li>
                                <li class="list-group-item px-0">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <?= esc($tentang->no_telp) ?>
                                </li>
                                <li class="list-group-item px-0">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <?= esc($tentang->email) ?>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-primary">Media Sosial:</h6>
                            <div class="d-flex gap-2">
                                <?php if ($tentang->instagram): ?>
                                    <a href="<?= esc($tentang->instagram) ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">
                                        <i class="fab fa-instagram me-1"></i> Instagram
                                    </a>
                                <?php endif; ?>
                                <?php if ($tentang->tiktok): ?>
                                    <a href="<?= esc($tentang->tiktok) ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill">
                                        <i class="fab fa-tiktok me-1"></i> TikTok
                                    </a>
                                <?php endif; ?>
                                <?php if ($tentang->youtube): ?>
                                    <a href="<?= esc($tentang->youtube) ?>" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill">
                                        <i class="fab fa-youtube me-1"></i> YouTube
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--//row-->
    </div><!--//container-xl-->
</div><!--//app-content-->

<style>
    /* Gradient Header */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Card Styling */
    .app-card-settings {
        border: none;
        background-color: #fff;
    }

    /* Form Styling */
    .form-control.rounded-pill {
        border-radius: 50px !important;
    }

    /* Preview Section */
    .preview-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .dashboard-header {
            text-align: center;
        }
    }

    /* TinyMCE Editor */
    .tox-tinymce {
        border-radius: 10px !important;
    }
</style>

<script>
    $(document).ready(function() {
        // Auto close alerts after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);

        // Preview image before upload
        $('#foto_tentang').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('.app-card-settings img').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<?= $this->endSection('content') ?>