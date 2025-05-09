<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Edit Tempat Wisata</h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <a href="<?= base_url('admin/tempat_wisata/index') ?>" class="btn app-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card app-card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">Form Edit Tempat Wisata</h5>
            </div>
            <div class="card-body pt-0">
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form action="<?= base_url('admin/tempat_wisata/proses_edit/' . $wisata['id_wisata']) ?>" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <?= csrf_field() ?>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="app-card app-card-settings shadow-sm p-4 h-100">
                                <div class="app-card-body">
                                    <!-- Nama Wisata -->
                                    <div class="mb-3">
                                        <label for="nama_wisata_ind" class="form-label">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>Nama Wisata (Indonesia)
                                        </label>
                                        <input type="text" class="form-control <?= ($validation->hasError('nama_wisata_ind')) ? 'is-invalid' : '' ?>" 
                                            id="nama_wisata_ind" name="nama_wisata_ind" 
                                            value="<?= old('nama_wisata_ind', $wisata['nama_wisata_ind']) ?>" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama_wisata_ind') ?: 'Nama wisata wajib diisi' ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Kategori Wisata -->
                                    <div class="mb-3">
                                        <label for="id_kategori_wisata" class="form-label">
                                            <i class="fas fa-tag text-primary me-2"></i>Kategori Wisata
                                        </label>
                                        <select class="form-select <?= ($validation->hasError('id_kategori_wisata')) ? 'is-invalid' : '' ?>" 
                                            id="id_kategori_wisata" name="id_kategori_wisata" required>
                                            <option value="" disabled>Pilih kategori wisata</option>
                                            <?php foreach ($kategori_wisata as $kategori) : ?>
                                                <option value="<?= $kategori->id_kategori_wisata ?>" 
                                                    <?= (old('id_kategori_wisata', $wisata['id_kategori_wisata']) == $kategori->id_kategori_wisata ? 'selected' : '' );?>>
                                                    <?= $kategori->nama_kategori_wisata ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('id_kategori_wisata') ?: 'Pilih kategori wisata' ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Sumber Foto -->
                                    <div class="mb-3">
                                        <label for="sumber_foto" class="form-label">
                                            <i class="fas fa-camera text-primary me-2"></i>Sumber Foto
                                        </label>
                                        <input type="text" class="form-control <?= ($validation->hasError('sumber_foto')) ? 'is-invalid' : '' ?>" 
                                            id="sumber_foto" name="sumber_foto" 
                                            value="<?= old('sumber_foto', $wisata['sumber_foto']) ?>" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('sumber_foto') ?: 'Sumber foto wajib diisi' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="app-card app-card-settings shadow-sm p-4 h-100">
                                <div class="app-card-body">
                                    <!-- Nama Wisata English -->
                                    <div class="mb-3">
                                        <label for="nama_wisata_eng" class="form-label">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>Nama Wisata (English)
                                        </label>
                                        <input type="text" class="form-control <?= ($validation->hasError('nama_wisata_eng')) ? 'is-invalid' : '' ?>" 
                                            id="nama_wisata_eng" name="nama_wisata_eng" 
                                            value="<?= old('nama_wisata_eng', $wisata['nama_wisata_eng']) ?>" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama_wisata_eng') ?: 'Nama wisata (English) wajib diisi' ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Foto Wisata -->
                                    <div class="mb-3">
                                        <label for="foto_wisata" class="form-label">
                                            <i class="fas fa-image text-primary me-2"></i>Foto Wisata
                                        </label>
                                        <input type="file" class="form-control <?= ($validation->hasError('foto_wisata')) ? 'is-invalid' : '' ?>" 
                                            id="foto_wisata" name="foto_wisata" 
                                            onchange="previewImage(this)">
                                        <div class="form-text text-muted small">Format: JPG/PNG/JPEG, Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</div>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('foto_wisata') ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Preview Foto -->
                                    <div class="mt-3">
                                        <label class="form-label">
                                            <i class="fas fa-eye text-primary me-2"></i>Preview Foto
                                        </label>
                                        <div class="border p-3 rounded text-center" style="background-color: #f8f9fa;">
                                            <img id="image-preview" src="<?= base_url('asset-user/uploads/foto_wisata/' . $wisata['foto_wisata']) ?>" 
                                                class="img-fluid rounded" style="max-height: 150px;" alt="Preview Foto Wisata">
                                            <div class="mt-2 small text-muted">Foto saat ini</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="app-card app-card-settings shadow-sm p-4 h-100">
                                <div class="app-card-body">
                                    <!-- Deskripsi Wisata Indonesia -->
                                    <div class="mb-3">
                                        <label for="deskripsi_wisata_ind" class="form-label">
                                            <i class="fas fa-align-left text-primary me-2"></i>Deskripsi Wisata (Indonesia)
                                        </label>
                                        <textarea class="form-control <?= ($validation->hasError('deskripsi_wisata_ind')) ? 'is-invalid' : '' ?>" 
                                            id="deskripsi_wisata_ind" name="deskripsi_wisata_ind" 
                                            rows="6" required><?= old('deskripsi_wisata_ind', $wisata['deskripsi_wisata_ind']) ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('deskripsi_wisata_ind') ?: 'Deskripsi wisata wajib diisi' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="app-card app-card-settings shadow-sm p-4 h-100">
                                <div class="app-card-body">
                                    <!-- Deskripsi Wisata English -->
                                    <div class="mb-3">
                                        <label for="deskripsi_wisata_eng" class="form-label">
                                            <i class="fas fa-align-left text-primary me-2"></i>Deskripsi Wisata (English)
                                        </label>
                                        <textarea class="form-control <?= ($validation->hasError('deskripsi_wisata_eng')) ? 'is-invalid' : '' ?>" 
                                            id="deskripsi_wisata_eng" name="deskripsi_wisata_eng" 
                                            rows="6" required><?= old('deskripsi_wisata_eng', $wisata['deskripsi_wisata_eng']) ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('deskripsi_wisata_eng') ?: 'Deskripsi wisata (English) wajib diisi' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="app-card app-card-settings shadow-sm p-4 h-100">
                                <div class="app-card-body">
                                    <h5 class="card-title mb-3 text-primary">
                                        <i class="fas fa-map-marked-alt me-2"></i>Koordinat Lokasi
                                    </h5>
                                    
                                    <!-- Latitude -->
                                    <div class="mb-3">
                                        <label for="wisata_latitude" class="form-label">Latitude</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                                            <input type="text" class="form-control <?= ($validation->hasError('wisata_latitude')) ? 'is-invalid' : '' ?>" 
                                                id="wisata_latitude" name="wisata_latitude" 
                                                value="<?= old('wisata_latitude', $wisata['wisata_latitude']) ?>" required>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('wisata_latitude') ?: 'Latitude wajib diisi' ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Longitude -->
                                    <div class="mb-3">
                                        <label for="wisata_longitude" class="form-label">Longitude</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                                            <input type="text" class="form-control <?= ($validation->hasError('wisata_longitude')) ? 'is-invalid' : '' ?>" 
                                                id="wisata_longitude" name="wisata_longitude" 
                                                value="<?= old('wisata_longitude', $wisata['wisata_longitude']) ?>" required>
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('wisata_longitude') ?: 'Longitude wajib diisi' ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info mt-3">
                                        <small>
                                            <i class="fas fa-info-circle me-2"></i>
                                            Gunakan Google Maps untuk mendapatkan koordinat yang akurat.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="app-card app-card-settings shadow-sm p-4 h-100">
                                <div class="app-card-body">
                                    <h5 class="card-title mb-3 text-primary">
                                        <i class="fas fa-search me-2"></i>SEO Settings
                                    </h5>
                                    
                                    <!-- Meta Title ID -->
                                    <div class="mb-3">
                                        <label for="meta_title_id" class="form-label">Meta Title (Indonesia)</label>
                                        <input type="text" class="form-control <?= ($validation->hasError('meta_title_id')) ? 'is-invalid' : '' ?>" 
                                            id="meta_title_id" name="meta_title_id" 
                                            value="<?= old('meta_title_id', $wisata['meta_title_id']) ?>" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('meta_title_id') ?: 'Meta title wajib diisi' ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Meta Description ID -->
                                    <div class="mb-3">
                                        <label for="meta_deskription_id" class="form-label">Meta Description (Indonesia)</label>
                                        <textarea class="form-control <?= ($validation->hasError('meta_deskription_id')) ? 'is-invalid' : '' ?>" 
                                            id="meta_deskription_id" name="meta_deskription_id" 
                                            rows="3" required><?= old('meta_deskription_id', $wisata['meta_deskription_id']) ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('meta_deskription_id') ?: 'Meta description wajib diisi' ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Meta Title EN -->
                                    <div class="mb-3">
                                        <label for="meta_title_en" class="form-label">Meta Title (English)</label>
                                        <input type="text" class="form-control <?= ($validation->hasError('meta_title_en')) ? 'is-invalid' : '' ?>" 
                                            id="meta_title_en" name="meta_title_en" 
                                            value="<?= old('meta_title_en', $wisata['meta_title_en']) ?>" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('meta_title_en') ?: 'Meta title (English) wajib diisi' ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Meta Description EN -->
                                    <div class="mb-3">
                                        <label for="meta_description_en" class="form-label">Meta Description (English)</label>
                                        <textarea class="form-control <?= ($validation->hasError('meta_description_en')) ? 'is-invalid' : '' ?>" 
                                            id="meta_description_en" name="meta_description_en" 
                                            rows="3" required><?= old('meta_description_en', $wisata['meta_description_en']) ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('meta_description_en') ?: 'Meta description (English) wajib diisi' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= base_url('admin/tempat_wisata/index') ?>" class="btn app-btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn app-btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
            document.getElementById('image-preview').style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Validasi form
(function () {
    'use strict'
    
    var forms = document.querySelectorAll('.needs-validation')
    
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>

<?= $this->endSection('content') ?>