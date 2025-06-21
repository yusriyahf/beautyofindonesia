<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="app-page-title mb-1">
                    <i class="fas fa-gift text-primary me-2"></i>Edit Oleh-Oleh
                </h1>
                <p class="text-muted">Perbarui data oleh-oleh dengan informasi terbaru</p>
            </div>
            <div>
                <?php $role = session()->get('role'); ?>
                <a href="<?= base_url($role . '/oleh_oleh/index') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        <?php $role = session()->get('role'); ?>
                        <form action="<?= base_url($role . '/oleh_oleh/proses_edit/' . $oleh_oleh['id_oleholeh']) ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <!-- Progress Steps Indicator -->
                            <div class="mb-4">
                                <div class="progress-steps">
                                    <div class="step active">
                                        <div class="step-number">1</div>
                                        <div class="step-label">Informasi Dasar</div>
                                    </div>
                                    <div class="step">
                                        <div class="step-number">2</div>
                                        <div class="step-label">Lokasi</div>
                                    </div>
                                    <div class="step">
                                        <div class="step-number">3</div>
                                        <div class="step-label">Media</div>
                                    </div>
                                    <div class="step">
                                        <div class="step-number">4</div>
                                        <div class="step-label">Deskripsi</div>
                                    </div>
                                    <div class="step">
                                        <div class="step-number">5</div>
                                        <div class="step-label">SEO</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Dasar Section -->
                            <div class="mb-4 border-bottom pb-3">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_oleholeh" class="form-label">
                                            <i class="fas fa-tag me-1 text-muted"></i>Nama (Bahasa Indonesia) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="nama_oleholeh" name="nama_oleholeh" value="<?= $oleh_oleh['nama_oleholeh'] ?>" required>
                                        <small class="text-muted">Nama produk dalam bahasa Indonesia</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_oleholeh_eng" class="form-label">
                                            <i class="fas fa-tag me-1 text-muted"></i>Nama (English) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="nama_oleholeh_eng" name="nama_oleholeh_eng" value="<?= $oleh_oleh['nama_oleholeh_eng'] ?>" required>
                                        <small class="text-muted">Nama produk dalam bahasa Inggris</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="id_kategori_oleholeh" class="form-label">
                                            <i class="fas fa-list me-1 text-muted"></i>Kategori <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select form-select-lg " id="id_kategori_oleholeh" name="id_kategori_oleholeh" required>
                                            <option value="" disabled>Pilih kategori oleh-oleh</option>
                                            <?php foreach ($kategori_oleh_oleh as $kategori) : ?>
                                                <option value="<?= $kategori->id_kategori_oleholeh ?>" <?= ($kategori->id_kategori_oleholeh == $oleh_oleh['id_kategori_oleholeh']) ? 'selected' : '' ?>>
                                                    <?= $kategori->nama_kategori_oleholeh ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nomor_tlp" class="form-label">
                                            <i class="fas fa-phone me-1 text-muted"></i>Nomor Telepon <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                            <input type="text" class="form-control form-control-lg" id="nomor_tlp" name="nomor_tlp" value="<?= $oleh_oleh['nomor_tlp'] ?>" required>
                                        </div>
                                        <small class="text-muted">Format: +62 atau 08xx</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Lokasi Section -->
                            <div class="mb-4 border-bottom pb-3">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-map-marker-alt me-2"></i>Lokasi
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="id_provinsi" class="form-label">
                                            <i class="fas fa-map me-1 text-muted"></i>Provinsi <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select form-select-lg" id="id_provinsi" name="id_provinsi" required>
                                            <option value="">Pilih Provinsi</option>
                                            <?php foreach ($all_data_provinsi as $provinsi) : ?>
                                                <option value="<?= $provinsi->id_provinsi ?>"
                                                    <?= (isset($oleh_oleh['id_provinsi']) && $provinsi->id_provinsi == $oleh_oleh['id_provinsi']) ? 'selected' : '' ?>>
                                                    <?= $provinsi->nama_provinsi ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="id_kotakabupaten" class="form-label">
                                            <i class="fas fa-city me-1 text-muted"></i>Kabupaten/Kota <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select form-select-lg select2-enhanced" id="id_kotakabupaten" name="id_kotakabupaten" required>
                                            <option value="">Pilih Kabupaten/Kota</option>
                                            <?php foreach ($kotakabupaten as $kabupaten) : ?>
                                                <option value="<?= $kabupaten['id_kotakabupaten'] ?>" <?= ($kabupaten['id_kotakabupaten'] == $oleh_oleh['id_kotakabupaten']) ? 'selected' : '' ?>>
                                                    <?= $kabupaten['nama_kotakabupaten'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="oleholeh_latitude" class="form-label">
                                            <i class="fas fa-map-pin me-1 text-muted"></i>Latitude <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                            <input type="text" class="form-control form-control-lg" id="oleholeh_latitude" name="oleholeh_latitude" value="<?= $oleh_oleh['oleholeh_latitude'] ?>" required>
                                            <button class="btn btn-outline-primary" type="button" id="get-location">
                                                <i class="fas fa-location-arrow me-1"></i> Lokasi Saat Ini
                                            </button>
                                        </div>
                                        <small class="text-muted">Koordinat latitude lokasi</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="oleholeh_longitude" class="form-label">
                                            <i class="fas fa-map-pin me-1 text-muted"></i>Longitude <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe-asia"></i></span>
                                            <input type="text" class="form-control form-control-lg" id="oleholeh_longitude" name="oleholeh_longitude" value="<?= $oleh_oleh['oleholeh_longitude'] ?>" required>
                                        </div>
                                        <small class="text-muted">Koordinat longitude lokasi</small>
                                    </div>
                                </div>
                                <div class="alert alert-info mt-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle me-2 fs-4"></i>
                                        <div>
                                            Anda dapat mencari lokasi di <a href="https://maps.google.com" target="_blank" class="alert-link">Google Maps</a>, lalu klik kanan pada titik lokasi dan pilih "Koordinat"
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Media Section -->
                            <div class="mb-4 border-bottom pb-3">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-camera me-2"></i>Media
                                </h5>
                                <div class="mb-4">
                                    <label for="foto_oleholeh" class="form-label">
                                        <i class="fas fa-image me-1 text-muted"></i>Foto Utama
                                    </label>
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <div class="position-relative d-inline-block">
                                                <img id="image-preview" src="<?= base_url('assets-baru/img/foto_oleholeh/' . $oleh_oleh['foto_oleholeh']) ?>" class="img-thumbnail mb-3" style="max-width: 250px; height: 250px; object-fit: cover;" alt="Preview Foto">
                                                <div class="position-absolute top-0 end-0 bg-white rounded-circle p-1 shadow-sm">
                                                    <span class="badge bg-primary">Current</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="file-upload-wrapper mb-2">
                                                    <input class="form-control form-control-lg" type="file" id="foto_oleholeh" name="foto_oleholeh" accept="image/jpeg,image/png">
                                                </div>
                                                <small class="text-muted">Format: JPG/PNG (rasio 1:1, maksimal 2MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sumber_foto" class="form-label">
                                            <i class="fas fa-user me-1 text-muted"></i>Sumber Foto
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-camera-retro"></i></span>
                                            <input type="text" class="form-control form-control-lg" id="sumber_foto" name="sumber_foto" value="<?= $oleh_oleh['sumber_foto'] ?>">
                                        </div>
                                        <small class="text-muted">Kredit fotografer jika ada</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="link_website" class="form-label">
                                            <i class="fas fa-link me-1 text-muted"></i>Link Website
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                            <input type="text" class="form-control form-control-lg" id="link_website" name="link_website" value="<?= $oleh_oleh['link_website'] ?>" placeholder="example.com">
                                        </div>
                                        <small class="text-muted">Link website resmi jika ada</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi Section -->
                            <div class="mb-4 border-bottom pb-3">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-align-left me-2"></i>Deskripsi
                                </h5>
                                <div class="mb-3">
                                    <label for="deskripsi_oleholeh" class="form-label">
                                        <i class="fas fa-font me-1 text-muted"></i>Deskripsi (Bahasa Indonesia) <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control form-control-lg" id="deskripsi_oleholeh" name="deskripsi_oleholeh" rows="5" required><?= $oleh_oleh['deskripsi_oleholeh'] ?></textarea>
                                    <small class="text-muted">Deskripsi lengkap produk dalam bahasa Indonesia</small>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi_oleholeh_eng" class="form-label">
                                        <i class="fas fa-font me-1 text-muted"></i>Deskripsi (English) <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control form-control-lg" id="deskripsi_oleholeh_eng" name="deskripsi_oleholeh_eng" rows="5" required><?= $oleh_oleh['deskripsi_oleholeh_eng'] ?></textarea>
                                    <small class="text-muted">Deskripsi lengkap produk dalam bahasa Inggris</small>
                                </div>
                            </div>

                            <!-- SEO Section -->
                            <div class="mb-4">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-search me-2"></i>Optimasi Mesin Pencari (SEO)
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_title_id" class="form-label">
                                            <i class="fas fa-heading me-1 text-muted"></i>Judul Meta (Bahasa Indonesia) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            <input type="text" class="form-control form-control-lg" id="meta_title_id" name="meta_title_id" value="<?= $oleh_oleh['meta_title_id'] ?>" required>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">Judul untuk hasil pencarian</small>
                                            <small class="text-muted"><span id="meta_title_id_counter">0</span>/60 karakter</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_title_en" class="form-label">
                                            <i class="fas fa-heading me-1 text-muted"></i>Judul Meta (English) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            <input type="text" class="form-control form-control-lg" id="meta_title_en" name="meta_title_en" value="<?= $oleh_oleh['meta_title_en'] ?>" required>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">Judul untuk hasil pencarian</small>
                                            <small class="text-muted"><span id="meta_title_en_counter">0</span>/60 karakter</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_description_id" class="form-label">
                                            <i class="fas fa-paragraph me-1 text-muted"></i>Deskripsi Meta (Bahasa Indonesia) <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control form-control-lg" id="meta_description_id" name="meta_description_id" rows="3" maxlength="160" required><?= $oleh_oleh['meta_description_id'] ?></textarea>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">Deskripsi singkat untuk hasil pencarian</small>
                                            <small class="text-muted"><span id="meta_description_id_counter">0</span>/160 karakter</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_description_en" class="form-label">
                                            <i class="fas fa-paragraph me-1 text-muted"></i>Deskripsi Meta (English) <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control form-control-lg" id="meta_description_en" name="meta_description_en" rows="3" maxlength="160" required><?= $oleh_oleh['meta_description_en'] ?></textarea>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">Deskripsi singkat untuk hasil pencarian</small>
                                            <small class="text-muted"><span id="meta_description_en_counter">0</span>/160 karakter</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                                <div class="form-text">
                                    <span class="text-danger">*</span> Menandakan field wajib diisi
                                </div>
                                <div>
                                    <button type="reset" class="btn btn-outline-secondary me-2 px-4">
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>

                            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <?php echo session()->getFlashdata('success') ?>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize enhanced Select2
        $('.select2-enhanced').select2({
            language: 'id',
            placeholder: "Pilih opsi",
            allowClear: true,
            width: '100%',
            dropdownParent: $('.app-card-settings')
        });

        // Image preview functionality
        $('#foto_oleholeh').change(function(e) {
            const preview = $('#image-preview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.attr('src', e.target.result).show();
                }

                reader.readAsDataURL(file);
            }
        });

        // Get current location button
        $('#get-location').click(function() {
            if (navigator.geolocation) {
                $('#get-location').html('<i class="fas fa-spinner fa-spin me-1"></i> Mendapatkan lokasi...');

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        $('#oleholeh_latitude').val(position.coords.latitude.toFixed(6));
                        $('#oleholeh_longitude').val(position.coords.longitude.toFixed(6));
                        $('#get-location').html('<i class="fas fa-location-arrow me-1"></i> Lokasi Saat Ini');

                        // Show success toast
                        toastr.success('Lokasi berhasil didapatkan!');
                    },
                    function(error) {
                        $('#get-location').html('<i class="fas fa-location-arrow me-1"></i> Lokasi Saat Ini');
                        toastr.error('Gagal mendapatkan lokasi: ' + error.message);
                    }, {
                        timeout: 10000
                    }
                );
            } else {
                toastr.error('Browser tidak mendukung geolocation');
            }
        });

        // Character counters for SEO fields
        $('#meta_title_id').on('input', function() {
            $('#meta_title_id_counter').text($(this).val().length);
        }).trigger('input');

        $('#meta_title_en').on('input', function() {
            $('#meta_title_en_counter').text($(this).val().length);
        }).trigger('input');

        $('#meta_description_id').on('input', function() {
            $('#meta_description_id_counter').text($(this).val().length);
        }).trigger('input');

        $('#meta_description_en').on('input', function() {
            $('#meta_description_en_counter').text($(this).val().length);
        }).trigger('input');

    });
</script>

<style>
    /* Custom Select2 Styles */
    .select2-container--default .select2-selection--single {
        height: 46px;
        border: 1px solid #ced4da !important;
        border-radius: 0.375rem !important;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
        color: #495057 !important;
        padding-left: 0 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px !important;
    }

    .select2-container--default .select2-dropdown {
        border: 1px solid #ced4da !important;
        border-radius: 0.375rem !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .select2-container--default .select2-results__option--highlighted {
        background-color: #0d6efd !important;
        color: white !important;
    }

    .select2-container--default .select2-results__option--selected {
        background-color: #e9ecef !important;
        color: #495057 !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da !important;
        border-radius: 0.375rem !important;
    }

    /* Progress Steps */
    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .step {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .step:not(:last-child):after {
        content: '';
        position: absolute;
        top: 15px;
        left: 50%;
        right: -50%;
        height: 2px;
        background-color: #dee2e6;
        z-index: 0;
    }

    .step.active .step-number {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .step.active .step-label {
        color: #0d6efd;
        font-weight: 500;
    }

    .step.active:after {
        background-color: #0d6efd;
    }

    .step-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: white;
        border: 2px solid #dee2e6;
        color: #6c757d;
        font-weight: bold;
        position: relative;
        z-index: 1;
    }

    .step-label {
        display: block;
        margin-top: 0.5rem;
        color: #6c757d;
        font-size: 0.875rem;
    }

    /* Form Controls */
    .form-control-lg,
    .form-select-lg {
        padding: 0.5rem 1rem;
        font-size: 1rem;
        border-radius: 0.375rem;
    }

    /* Card Styling */
    .app-card-settings {
        border-radius: 0.5rem;
    }

    /* Image Preview */
    .img-thumbnail {
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    /* Alert Styling */
    .alert {
        border-radius: 0.375rem;
    }
</style>

<?= $this->endSection('content') ?>