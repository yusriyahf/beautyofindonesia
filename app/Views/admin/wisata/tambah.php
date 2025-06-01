<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="app-page-title mb-1">Add New Tourism Destination</h1>
                <p class="text-muted mb-0">Fill in the details below to add a new tourism spot to your system</p>
            </div>
            <div>
                <?php $role = session()->get('role'); ?>
                <?php if (in_array($role, ['admin', 'penulis'])): ?>
                    <a href="<?= base_url($role . '/tempat_wisata/index') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to List
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="card mb-4">
            <div class="card-body py-3">
                <div class="steps">
                    <div class="step active">
                        <div class="step-number">1</div>
                        <div class="step-label">Basic Information</div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-label">Location Details</div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-label">Content & Media</div>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-label">SEO Optimization</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <?php $role = session()->get('role'); ?>
        <?php if (in_array($role, ['admin', 'penulis'])): ?>
            <form action="<?= base_url($role . '/tempat_wisata/proses_tambah') ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <?php endif; ?>
            <?= csrf_field() ?>

            <!-- Section 1: Basic Information -->
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Basic Information
                    </h5>
                    <span class="badge bg-primary">Step 1 of 4</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_wisata_ind" class="form-label">
                                Destination Name (Indonesian)
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?= ($validation->hasError('nama_wisata_ind')) ? 'is-invalid' : '' ?>"
                                id="nama_wisata_ind" name="nama_wisata_ind" value="<?= old('nama_wisata_ind') ?>"
                                placeholder="e.g. Pantai Kuta" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_wisata_ind') ?: 'Please enter the destination name in Indonesian' ?>
                            </div>
                            <small class="text-muted">The official name of the destination in Indonesian</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_wisata_eng" class="form-label">
                                Destination Name (English)
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?= ($validation->hasError('nama_wisata_eng')) ? 'is-invalid' : '' ?>"
                                id="nama_wisata_eng" name="nama_wisata_eng" value="<?= old('nama_wisata_eng') ?>"
                                placeholder="e.g. Kuta Beach" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_wisata_eng') ?: 'Please enter the destination name in English' ?>
                            </div>
                            <small class="text-muted">The official name of the destination in English</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_kategori_wisata" class="form-label">
                                Destination Category
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= ($validation->hasError('id_kategori_wisata')) ? 'is-invalid' : '' ?>"
                                id="id_kategori_wisata" name="id_kategori_wisata" required>
                                <option value="" selected disabled>Select a category</option>
                                <?php foreach ($kategori_wisata as $kategori) : ?>
                                    <option value="<?= $kategori->id_kategori_wisata ?>" <?= old('id_kategori_wisata') == $kategori->id_kategori_wisata ? 'selected' : '' ?>>
                                        <?= $kategori->nama_kategori_wisata ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('id_kategori_wisata') ?: 'Please select a category' ?>
                            </div>
                            <small class="text-muted">What type of destination is this?</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="id_kotakabupaten" class="form-label">
                                Regency/City
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= ($validation->hasError('id_kotakabupaten')) ? 'is-invalid' : '' ?>"
                                id="id_kotakabupaten" name="id_kotakabupaten" required>
                                <option value="" selected disabled>Select regency/city</option>
                                <?php foreach ($kotakabupaten as $kabupaten) : ?>
                                    <option value="<?= $kabupaten['id_kotakabupaten'] ?>" <?= old('id_kotakabupaten') == $kabupaten['id_kotakabupaten'] ? 'selected' : '' ?>>
                                        <?= $kabupaten['nama_kotakabupaten'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('id_kotakabupaten') ?: 'Please select a regency/city' ?>
                            </div>
                            <small class="text-muted">Where is this destination located?</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Location Details -->
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marked-alt text-danger me-2"></i>
                        Location Details
                    </h5>
                    <span class="badge bg-primary">Step 2 of 4</span>
                </div>
                <div class="card-body">
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="fas fa-info-circle me-3 fs-4"></i>
                        <div>
                            <strong>Need help with coordinates?</strong> Open <a href="https://maps.google.com" target="_blank" class="alert-link">Google Maps</a>,
                            right-click on your destination, and copy the coordinates. Make sure to use decimal format (e.g., -8.723455, 115.172927).
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="wisata_latitude" class="form-label">
                                Latitude
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                <input type="text" class="form-control <?= ($validation->hasError('wisata_latitude')) ? 'is-invalid' : '' ?>"
                                    id="wisata_latitude" name="wisata_latitude" value="<?= old('wisata_latitude') ?>"
                                    placeholder="e.g. -8.723455" required>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('wisata_latitude') ?: 'Please enter valid latitude coordinates' ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="wisata_longitude" class="form-label">
                                Longitude
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                <input type="text" class="form-control <?= ($validation->hasError('wisata_longitude')) ? 'is-invalid' : '' ?>"
                                    id="wisata_longitude" name="wisata_longitude" value="<?= old('wisata_longitude') ?>"
                                    placeholder="e.g. 115.172927" required>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('wisata_longitude') ?: 'Please enter valid longitude coordinates' ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="map-preview bg-light p-3 rounded text-center">
                        <div id="static-map" style="height: 200px; background-color: #eee; display: flex; align-items: center; justify-content: center;">
                            <div class="text-muted">
                                <i class="fas fa-map-marked-alt fa-3x mb-2"></i>
                                <p>Map preview will appear here</p>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="update-map-preview">
                            <i class="fas fa-sync-alt me-1"></i> Update Map Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Section 3: Content & Media -->
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-images text-success me-2"></i>
                        Content & Media
                    </h5>
                    <span class="badge bg-primary">Step 3 of 4</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="deskripsi_wisata_ind" class="form-label">
                                    Description (Indonesian)
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control <?= ($validation->hasError('deskripsi_wisata_ind')) ? 'is-invalid' : '' ?>"
                                    id="deskripsi_wisata_ind" name="deskripsi_wisata_ind" rows="6"
                                    placeholder="Describe the destination in Indonesian..." required><?= old('deskripsi_wisata_ind') ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('deskripsi_wisata_ind') ?: 'Please enter a description in Indonesian' ?>
                                </div>
                                <div class="text-end mt-1">
                                    <small class="text-muted">Supports basic HTML formatting</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="deskripsi_wisata_eng" class="form-label">
                                    Description (English)
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control <?= ($validation->hasError('deskripsi_wisata_eng')) ? 'is-invalid' : '' ?>"
                                    id="deskripsi_wisata_eng" name="deskripsi_wisata_eng" rows="6"
                                    placeholder="Describe the destination in English..." required><?= old('deskripsi_wisata_eng') ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('deskripsi_wisata_eng') ?: 'Please enter a description in English' ?>
                                </div>
                                <div class="text-end mt-1">
                                    <small class="text-muted">Supports basic HTML formatting</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="foto_wisata" class="form-label">
                                    Featured Image
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="file-upload-container border rounded p-3 text-center">
                                    <input type="file" class="d-none" id="foto_wisata" name="foto_wisata" accept="image/*" onchange="previewImage(this)">
                                    <label for="foto_wisata" class="cursor-pointer">
                                        <div id="image-upload-placeholder" class="py-4">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                            <h5 class="mb-1">Upload Featured Image</h5>
                                            <p class="text-muted small mb-2">Drag & drop or click to browse</p>
                                            <span class="badge bg-light text-dark">JPG, PNG (Max 2MB)</span>
                                        </div>
                                        <img id="image-preview" class="img-fluid rounded d-none" style="max-height: 200px;" />
                                    </label>
                                </div>
                                <div class="invalid-feedback d-block">
                                    <?= $validation->getError('foto_wisata') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sumber_foto" class="form-label">
                                    Image Source/Credit
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control <?= ($validation->hasError('sumber_foto')) ? 'is-invalid' : '' ?>"
                                    id="sumber_foto" name="sumber_foto" value="<?= old('sumber_foto') ?>"
                                    placeholder="e.g. © Tourism Bali, John Doe Photography" required>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('sumber_foto') ?: 'Please credit the image source' ?>
                                </div>
                                <small class="text-muted">Give proper attribution for the image</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: SEO Optimization -->
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-search text-info me-2"></i>
                        SEO Optimization
                    </h5>
                    <span class="badge bg-primary">Step 4 of 4</span>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div>
                            <strong>Important for search visibility!</strong> These fields help search engines understand your content.
                            Keep meta titles under 60 characters and descriptions under 160 characters.
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="meta_title_id" class="form-label">
                                Meta Title (Indonesian)
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?= ($validation->hasError('meta_title_id')) ? 'is-invalid' : '' ?>"
                                id="meta_title_id" name="meta_title_id" value="<?= old('meta_title_id') ?>"
                                placeholder="e.g. Pantai Kuta Bali - Wisata Pantai Terkenal" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('meta_title_id') ?: 'Please enter a meta title in Indonesian' ?>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" id="meta-title-id-progress"></div>
                            </div>
                            <small class="text-muted"><span id="meta-title-id-count">0</span>/60 characters</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="meta_title_en" class="form-label">
                                Meta Title (English)
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?= ($validation->hasError('meta_title_en')) ? 'is-invalid' : '' ?>"
                                id="meta_title_en" name="meta_title_en" value="<?= old('meta_title_en') ?>"
                                placeholder="e.g. Kuta Beach Bali - Famous Beach Destination" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('meta_title_en') ?: 'Please enter a meta title in English' ?>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" id="meta-title-en-progress"></div>
                            </div>
                            <small class="text-muted"><span id="meta-title-en-count">0</span>/60 characters</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="meta_deskription_id" class="form-label">
                                Meta Description (Indonesian)
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control <?= ($validation->hasError('meta_deskription_id')) ? 'is-invalid' : '' ?>"
                                id="meta_deskription_id" name="meta_deskription_id" rows="3"
                                placeholder="e.g. Pantai Kuta adalah salah satu pantai paling terkenal di Bali dengan pasir putih dan ombak yang cocok untuk berselancar." required><?= old('meta_deskription_id') ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('meta_deskription_id') ?: 'Please enter a meta description in Indonesian' ?>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 0%;" id="meta-desc-id-progress"></div>
                            </div>
                            <small class="text-muted"><span id="meta-desc-id-count">0</span>/160 characters</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="meta_description_en" class="form-label">
                                Meta Description (English)
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control <?= ($validation->hasError('meta_description_en')) ? 'is-invalid' : '' ?>"
                                id="meta_description_en" name="meta_description_en" rows="3"
                                placeholder="e.g. Kuta Beach is one of Bali's most famous beaches with white sand and waves perfect for surfing." required><?= old('meta_description_en') ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('meta_description_en') ?: 'Please enter a meta description in English' ?>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 0%;" id="meta-desc-en-progress"></div>
                            </div>
                            <small class="text-muted"><span id="meta-desc-en-count">0</span>/160 characters</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-between border-top pt-4">
                <button type="reset" class="btn btn-outline-danger">
                    <i class="fas fa-eraser me-2"></i>
                    Clear Form
                </button>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Save Destination
                    </button>
                </div>
            </div>
            </form>
    </div>
</div>

<!-- Image Preview Script -->
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-upload-placeholder');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }

            reader.readAsDataURL(file);
        }
    }

    // Character counters for SEO fields
    document.addEventListener('DOMContentLoaded', function() {
        // Meta title counters
        const metaTitleId = document.getElementById('meta_title_id');
        const metaTitleEn = document.getElementById('meta_title_en');

        // Meta description counters
        const metaDescId = document.getElementById('meta_deskription_id');
        const metaDescEn = document.getElementById('meta_description_en');

        // Update counters
        function updateCounters() {
            // Indonesian title
            const titleIdLength = metaTitleId.value.length;
            document.getElementById('meta-title-id-count').textContent = titleIdLength;
            document.getElementById('meta-title-id-progress').style.width = Math.min((titleIdLength / 60) * 100, 100) + '%';

            // English title
            const titleEnLength = metaTitleEn.value.length;
            document.getElementById('meta-title-en-count').textContent = titleEnLength;
            document.getElementById('meta-title-en-progress').style.width = Math.min((titleEnLength / 60) * 100, 100) + '%';

            // Indonesian description
            const descIdLength = metaDescId.value.length;
            document.getElementById('meta-desc-id-count').textContent = descIdLength;
            document.getElementById('meta-desc-id-progress').style.width = Math.min((descIdLength / 160) * 100, 100) + '%';

            // English description
            const descEnLength = metaDescEn.value.length;
            document.getElementById('meta-desc-en-count').textContent = descEnLength;
            document.getElementById('meta-desc-en-progress').style.width = Math.min((descEnLength / 160) * 100, 100) + '%';
        }

        // Add event listeners
        metaTitleId.addEventListener('input', updateCounters);
        metaTitleEn.addEventListener('input', updateCounters);
        metaDescId.addEventListener('input', updateCounters);
        metaDescEn.addEventListener('input', updateCounters);

        // Initialize counters
        updateCounters();

        // Map preview button
        document.getElementById('update-map-preview').addEventListener('click', function() {
            const lat = document.getElementById('wisata_latitude').value;
            const lng = document.getElementById('wisata_longitude').value;

            if (lat && lng) {
                const staticMap = document.getElementById('static-map');
                staticMap.innerHTML = `<img src="https://maps.googleapis.com/maps/api/staticmap?center=${lat},${lng}&zoom=14&size=600x200&maptype=roadmap&markers=color:red%7C${lat},${lng}&key=YOUR_API_KEY" class="img-fluid" alt="Map Preview">`;
            } else {
                alert('Please enter both latitude and longitude coordinates first.');
            }
        });
    });

    // Form validation
    (function() {
        'use strict';

        // Fetch all forms with validation
        var forms = document.querySelectorAll('.needs-validation');

        // Validate each form
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();

                        // Scroll to first invalid field
                        const firstInvalid = form.querySelector('.is-invalid');
                        if (firstInvalid) {
                            firstInvalid.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }

                    form.classList.add('was-validated');
                }, false);
            });
    })();
</script>

<style>
    /* Custom styles for the form */
    .steps {
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
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
        z-index: 1;
    }

    .step.active:not(:last-child):after {
        background-color: #0d6efd;
    }

    .step-number {
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 50%;
        background-color: #dee2e6;
        color: #6c757d;
        display: inline-block;
        margin-bottom: 5px;
        position: relative;
        z-index: 2;
    }

    .step.active .step-number {
        background-color: #0d6efd;
        color: white;
    }

    .step-label {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .step.active .step-label {
        color: #0d6efd;
        font-weight: 500;
    }

    .file-upload-container {
        border: 2px dashed #dee2e6;
        transition: all 0.3s;
    }

    .file-upload-container:hover {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .progress-bar {
        transition: width 0.3s ease;
    }
</style>

<?= $this->endSection('content') ?>