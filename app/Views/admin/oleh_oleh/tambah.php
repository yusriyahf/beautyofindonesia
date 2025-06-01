<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="app-page-title mb-1">
                    <i class="fas fa-gift text-primary me-2"></i>Tambah Oleh-Oleh
                </h1>
                <p class="text-muted">Isi data oleh-oleh baru dengan lengkap</p>
            </div>
            <div>
                <?php $role = session()->get('role'); ?>
                <a href="<?= base_url($role . '/oleh_oleh/index') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="progress-steps">
                    <div class="step active" data-step="1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Informasi Dasar</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Lokasi</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-circle">3</div>
                        <div class="step-label">Media</div>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-circle">4</div>
                        <div class="step-label">Deskripsi</div>
                    </div>
                    <div class="step" data-step="5">
                        <div class="step-circle">5</div>
                        <div class="step-label">SEO</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                         <?php $role = session()->get('role');?>
                        <form action="<?= base_url($role . '/oleh_oleh/proses_tambah') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <!-- Informasi Dasar Section -->
                            <div class="mb-4 border-bottom pb-3 step-content" data-step="1">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_oleholeh" class="form-label">
                                            <i class="fas fa-tag me-1 text-muted"></i>Nama (Bahasa Indonesia) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nama_oleholeh" name="nama_oleholeh" required>
                                        <small class="text-muted">Nama produk dalam bahasa Indonesia</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_oleholeh_eng" class="form-label">
                                            <i class="fas fa-tag me-1 text-muted"></i>Nama (English) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nama_oleholeh_eng" name="nama_oleholeh_eng" required>
                                        <small class="text-muted">Nama produk dalam bahasa Inggris</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="id_kategori_oleholeh" class="form-label">
                                            <i class="fas fa-list me-1 text-muted"></i>Kategori <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="id_kategori_oleholeh" name="id_kategori_oleholeh" required>
                                            <option value="" selected disabled>Pilih kategori</option>
                                            <?php foreach ($kategori_oleh_oleh as $kategori) : ?>
                                                <option value="<?= $kategori->id_kategori_oleholeh ?>"><?= $kategori->nama_kategori_oleholeh ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nomor_tlp" class="form-label">
                                            <i class="fas fa-phone me-1 text-muted"></i>Nomor Telepon <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nomor_tlp" name="nomor_tlp" required>
                                        <small class="text-muted">Format: +62 atau 08xx</small>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-primary next-step" data-next="2">
                                        Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Lokasi Section -->
                            <div class="mb-4 border-bottom pb-3 step-content" data-step="2" style="display:none;">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-map-marker-alt me-2"></i>Lokasi
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="id_provinsi" class="form-label">
                                            <i class="fas fa-map me-1 text-muted"></i>Provinsi <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="id_provinsi" name="id_provinsi" required>
                                            <option value="">Pilih Provinsi</option>
                                            <?php foreach ($all_data_provinsi as $provinsi) : ?>
                                                <option value="<?= $provinsi->id_provinsi; ?>"><?= $provinsi->nama_provinsi; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- Formulir Dropdown Kabupaten -->
                                    <div class="col-md-6 mb-3">
                                        <label for="id_kotakabupaten" class="form-label">Kabupaten</label>
                                        <select class="form-select select2-basic" id="id_kotakabupaten" name="id_kotakabupaten" required>
                                            <option value="" selected disabled>Pilih kabupaten</option>
                                            <?php foreach ($kotakabupaten as $kabupaten) : ?>
                                                <option value="<?= $kabupaten['id_kotakabupaten'] ?>"><?= $kabupaten['nama_kotakabupaten'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih kabupaten.
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="oleholeh_latitude" class="form-label">
                                                <i class="fas fa-map-pin me-1 text-muted"></i>Latitude <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="oleholeh_latitude" name="oleholeh_latitude" required>
                                                <button class="btn btn-outline-secondary" type="button" id="get-location">
                                                    <i class="fas fa-location-arrow"></i> Lokasi Saat Ini
                                                </button>
                                            </div>
                                            <small class="text-muted">Koordinat latitude lokasi</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="oleholeh_longitude" class="form-label">
                                                <i class="fas fa-map-pin me-1 text-muted"></i>Longitude <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="oleholeh_longitude" name="oleholeh_longitude" required>
                                            <small class="text-muted">Koordinat longitude lokasi</small>
                                        </div>
                                    </div>
                                    <div class="alert alert-info mt-2">
                                        <i class="fas fa-info-circle me-2"></i>Anda dapat mencari lokasi di <a href="https://maps.google.com" target="_blank">Google Maps</a>, lalu klik kanan pada titik lokasi dan pilih "Koordinat"
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">
                                        <i class="fas fa-arrow-left me-1"></i> Sebelumnya
                                    </button>
                                    <button type="button" class="btn btn-primary next-step" data-next="3">
                                        Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Media Section -->
                            <div class="mb-4 border-bottom pb-3 step-content" data-step="3" style="display:none;">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-camera me-2"></i>Media
                                </h5>
                                <div class="mb-3">
                                    <label for="foto_oleholeh" class="form-label">
                                        <i class="fas fa-image me-1 text-muted"></i>Foto Utama <span class="text-danger">*</span>
                                    </label>
                                    <div class="border rounded p-3 text-center">
                                        <img id="image-preview" class="img-thumbnail mb-2" style="max-width: 200px; display: none;" />
                                        <div class="d-flex flex-column align-items-center">
                                            <input class="form-control <?= ($validation->hasError('foto_oleholeh')) ? 'is-invalid' : '' ?>"
                                                type="file" id="foto_oleholeh" name="foto_oleholeh" accept="image/jpeg,image/png" required>
                                            <small class="text-muted mt-2">Format: JPG/PNG (rasio 1:1, maksimal 2MB)</small>
                                        </div>
                                    </div>
                                    <?= $validation->getError('foto_oleholeh') ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sumber_foto" class="form-label">
                                            <i class="fas fa-user me-1 text-muted"></i>Sumber Foto
                                        </label>
                                        <input type="text" class="form-control" id="sumber_foto" name="sumber_foto">
                                        <small class="text-muted">Kredit fotografer jika ada</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="link_website" class="form-label">
                                            <i class="fas fa-link me-1 text-muted"></i>Link Website
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="link_website" name="link_website">
                                        </div>
                                        <small class="text-muted">Link website resmi jika ada</small>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">
                                        <i class="fas fa-arrow-left me-1"></i> Sebelumnya
                                    </button>
                                    <button type="button" class="btn btn-primary next-step" data-next="4">
                                        Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Deskripsi Section -->
                            <div class="mb-4 border-bottom pb-3 step-content" data-step="4" style="display:none;">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-align-left me-2"></i>Deskripsi
                                </h5>
                                <div class="mb-3">
                                    <label for="deskripsi_oleholeh" class="form-label">
                                        <i class="fas fa-font me-1 text-muted"></i>Deskripsi (Bahasa Indonesia) <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" id="deskripsi_oleholeh" name="deskripsi_oleholeh" rows="4" required></textarea>
                                    <small class="text-muted">Deskripsi lengkap produk dalam bahasa Indonesia</small>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi_oleholeh_eng" class="form-label">
                                        <i class="fas fa-font me-1 text-muted"></i>Deskripsi (English) <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" id="deskripsi_oleholeh_eng" name="deskripsi_oleholeh_eng" rows="4" required></textarea>
                                    <small class="text-muted">Deskripsi lengkap produk dalam bahasa Inggris</small>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="3">
                                        <i class="fas fa-arrow-left me-1"></i> Sebelumnya
                                    </button>
                                    <button type="button" class="btn btn-primary next-step" data-next="5">
                                        Selanjutnya <i class="fas fa-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- SEO Section -->
                            <div class="mb-4 step-content" data-step="5" style="display:none;">
                                <h5 class="section-title mb-3 text-primary">
                                    <i class="fas fa-search me-2"></i>Optimasi Mesin Pencari (SEO)
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_title_id" class="form-label">
                                            <i class="fas fa-heading me-1 text-muted"></i>Judul Meta (Bahasa Indonesia) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="meta_title_id" name="meta_title_id" required>
                                        <small class="text-muted">Judul yang akan muncul di hasil pencarian (maks. 60 karakter)</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_title_en" class="form-label">
                                            <i class="fas fa-heading me-1 text-muted"></i>Judul Meta (English) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" required>
                                        <small class="text-muted">Judul yang akan muncul di hasil pencarian (maks. 60 karakter)</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_description_id" class="form-label">
                                            <i class="fas fa-paragraph me-1 text-muted"></i>Deskripsi Meta (Bahasa Indonesia) <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" id="meta_description_id" name="meta_description_id" rows="3" maxlength="160" required></textarea>
                                        <small class="text-muted">Deskripsi singkat untuk hasil pencarian (maks. 160 karakter)</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_description_en" class="form-label">
                                            <i class="fas fa-paragraph me-1 text-muted"></i>Deskripsi Meta (English) <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" id="meta_description_en" name="meta_description_en" rows="3" maxlength="160" required></textarea>
                                        <small class="text-muted">Deskripsi singkat untuk hasil pencarian (maks. 160 karakter)</small>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center pt-3">
                                    <div class="form-text">
                                        <span class="text-danger">*</span> Menandakan field wajib diisi
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary prev-step me-2" data-prev="4">
                                            <i class="fas fa-arrow-left me-1"></i> Sebelumnya
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Simpan Data
                                        </button>
                                    </div>
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

<style>
    /* Progress Steps Styles */
    .progress-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        position: relative;
    }
    
    .progress-steps::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #e9ecef;
        z-index: 1;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    
    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 0.5rem;
        border: 3px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .step.active .step-circle {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    
    .step.completed .step-circle {
        background-color: #198754;
        color: white;
        border-color: #198754;
    }
    
    .step-label {
        font-size: 0.875rem;
        color: #6c757d;
        text-align: center;
    }
    
    .step.active .step-label {
        color: #0d6efd;
        font-weight: 500;
    }
    
    .step.completed .step-label {
        color: #198754;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .progress-steps {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .step {
            width: 20%;
            margin-bottom: 1rem;
        }
        
        .step-label {
            font-size: 0.75rem;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Step navigation functionality
        $('.next-step').click(function() {
            const currentStep = $(this).closest('.step-content').data('step');
            const nextStep = $(this).data('next');
            
            // Validate current step before proceeding
            if (validateStep(currentStep)) {
                // Update progress steps UI
                $('.step[data-step="' + currentStep + '"]').removeClass('active').addClass('completed');
                $('.step[data-step="' + nextStep + '"]').addClass('active');
                
                // Show next step content
                $('.step-content').hide();
                $('.step-content[data-step="' + nextStep + '"]').show();
                
                // Scroll to top of form
                $('html, body').animate({
                    scrollTop: $('.app-card').offset().top - 20
                }, 300);
            }
        });
        
        $('.prev-step').click(function() {
            const currentStep = $(this).closest('.step-content').data('step');
            const prevStep = $(this).data('prev');
            
            // Update progress steps UI
            $('.step[data-step="' + currentStep + '"]').removeClass('active');
            $('.step[data-step="' + prevStep + '"]').addClass('active').removeClass('completed');
            
            // Show previous step content
            $('.step-content').hide();
            $('.step-content[data-step="' + prevStep + '"]').show();
            
            // Scroll to top of form
            $('html, body').animate({
                scrollTop: $('.app-card').offset().top - 20
            }, 300);
        });
        
        // Function to validate current step before proceeding
        function validateStep(step) {
            let isValid = true;
            
            // Validate each required field in the current step
            $('.step-content[data-step="' + step + '"] [required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                // Scroll to first invalid field
                $('html, body').animate({
                    scrollTop: $('.step-content[data-step="' + step + '"] .is-invalid').first().offset().top - 100
                }, 300);
                
                // Show error message
                toastr.error('Harap isi semua field yang wajib diisi');
            }
            
            return isValid;
        }
        
        // Custom Select2 styling
        function applySelect2Styles() {
            $('.select2-container--default .select2-selection--single').css({
                'height': '38px',
                'border': '1px solidrgba(206, 212, 218, 0.84)',
                'border-radius': '0.25rem',
                'padding': '0.375rem 0.75rem'
            });
            
            $('.select2-container--default .select2-selection--single .select2-selection__rendered').css({
                'line-height': '1.5',
                'color': '#495057',
                'padding-left': '0'
            });
            
            $('.select2-container--default .select2-selection--single .select2-selection__arrow').css({
                'height': '36px'
            });
            
            $('.select2-container--default .select2-dropdown').css({
                'border': '1px solidrgba(212, 213, 214, 0.87)',
                'border-radius': '0.25rem',
                'box-shadow': '0 0.5rem 1rem rgba(0, 0, 0, 0.15)'
            });
            
            $('.select2-container--default .select2-results__option--highlighted').css({
                'background-color': '#0d6efd',
                'color': 'white'
            });
        }

        // Initialize Select2 with callback
        $('.select2-basic').select2({
            language: 'id',
            placeholder: "Pilih Kabupaten",
            allowClear: true,
            width: '100%'
        }).on('select2:open', function() {
            // Apply styles when dropdown opens
            applySelect2Styles();
        });

        // Apply initial styles
        applySelect2Styles();

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

        // Get current location
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
    });
</script>

<?= $this->endSection('content') ?>