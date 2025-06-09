<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-gift me-2 text-white"></i> Daftar Kategori Oleh-Oleh</h1>
                    <p class="mb-0 opacity-75">Kelola kategori untuk mengorganisir oleh-oleh Anda</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <?php $role = session()->get('role'); ?>
                    <?php if (in_array($role, ['admin', 'penulis'])): ?>
                        <button class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-info" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                            <i class="fas fa-plus me-1"></i>Tambah Kategori
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Category Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <?php if (empty($all_data_kategori_oleholeh)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-gift fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada kategori oleh-oleh</h5>
                        <p class="text-muted mb-3">Mulai dengan membuat kategori baru</p>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                            <i class="fas fa-plus me-1"></i>Tambah Kategori
                        </button>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="kategoriTable" class="table table-hover w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th width="60" class="text-center">No</th>
                                    <th>Kategori Oleh-Oleh (Indonesia)</th>
                                    <th>Kategori Oleh-Oleh (English)</th>
                                    <?php if (in_array($role, ['admin', 'penulis'])): ?>
                                        <th width="150" class="text-center">Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($all_data_kategori_oleholeh as $kategori) : ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $i++; ?></td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3 py-2">
                                                <?= esc($kategori->nama_kategori_oleholeh) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10 px-3 py-2">
                                                <?= esc($kategori->nama_kategori_oleholeh_en) ?>
                                            </span>
                                        </td>
                                        <?php if (in_array($role, ['admin', 'penulis'])): ?>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm btn-outline-secondary detail-btn"
                                                        data-id="<?= $kategori->id_kategori_oleholeh ?>"
                                                        data-nama="<?= esc($kategori->nama_kategori_oleholeh) ?>"
                                                        data-nama-en="<?= esc($kategori->nama_kategori_oleholeh_en) ?>"
                                                        data-slug="<?= esc($kategori->slug_kategori_oleholeh) ?>"
                                                        data-slug-en="<?= esc($kategori->slug_kategori_oleholeh_en) ?>"
                                                        data-meta-title-id="<?= esc($kategori->meta_title_id ?? '') ?>"
                                                        data-meta-title-en="<?= esc($kategori->meta_title_en ?? '') ?>"
                                                        data-meta-desc-id="<?= esc($kategori->meta_description_id ?? '') ?>"
                                                        data-meta-desc-en="<?= esc($kategori->meta_description_en ?? '') ?>"
                                                        title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-primary edit-btn"
                                                        data-id="<?= $kategori->id_kategori_oleholeh ?>"
                                                        data-nama="<?= esc($kategori->nama_kategori_oleholeh) ?>"
                                                        data-nama-en="<?= esc($kategori->nama_kategori_oleholeh_en) ?>"
                                                        data-meta-title-id="<?= esc($kategori->meta_title_id ?? '') ?>"
                                                        data-meta-title-en="<?= esc($kategori->meta_title_en ?? '') ?>"
                                                        data-meta-desc-id="<?= esc($kategori->meta_description_id ?? '') ?>"
                                                        data-meta-desc-en="<?= esc($kategori->meta_description_en ?? '') ?>"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger delete-btn"
                                                        data-id="<?= $kategori->id_kategori_oleholeh ?>"
                                                        data-nama="<?= esc($kategori->nama_kategori_oleholeh) ?>"
                                                        title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title" id="tambahKategoriModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kategori Oleh-Oleh Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url($role . '/kategori_oleholeh/proses_tambah') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <!-- Indonesian Section -->
                        <div class="col-md-6 border-end pe-3">
                            <h6 class="text-primary mb-3 d-flex align-items-center">
                                <i class="fas fa-flag me-2"></i> Bahasa Indonesia
                            </h6>
                            <div class="mb-3">
                                <label for="nama_kategori_oleholeh" class="form-label small text-muted mb-1">NAMA KATEGORI OLEH-OLEH</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-tag text-primary"></i></span>
                                    <input type="text" class="form-control py-2" id="nama_kategori_oleholeh" name="nama_kategori_oleholeh" required placeholder="Contoh: Makanan">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="meta_title_id" class="form-label small text-muted mb-1">META TITLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-heading text-primary"></i></span>
                                    <input type="text" class="form-control py-2" id="meta_title_id" name="meta_title_id" placeholder="Judul untuk SEO (max 60 karakter)" maxlength="60">
                                </div>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar" id="titleProgressId" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="meta_description_id" class="form-label small text-muted mb-1">META DESCRIPTION</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-align-left text-primary"></i></span>
                                    <textarea class="form-control py-2" id="meta_description_id" name="meta_description_id" rows="3" placeholder="Deskripsi untuk SEO (max 160 karakter)" maxlength="160"></textarea>
                                </div>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar" id="descProgressId" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- English Section -->
                        <div class="col-md-6 ps-3">
                            <h6 class="text-info mb-3 d-flex align-items-center">
                                <i class="fas fa-flag-usa me-2"></i> English
                            </h6>
                            <div class="mb-3">
                                <label for="nama_kategori_oleholeh_en" class="form-label small text-muted mb-1">SOUVENIR CATEGORY NAME</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-tag text-info"></i></span>
                                    <input type="text" class="form-control py-2" id="nama_kategori_oleholeh_en" name="nama_kategori_oleholeh_en" required placeholder="Example: Food">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="meta_title_en" class="form-label small text-muted mb-1">META TITLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-heading text-info"></i></span>
                                    <input type="text" class="form-control py-2" id="meta_title_en" name="meta_title_en" placeholder="SEO Title (max 60 chars)" maxlength="60">
                                </div>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-info" id="titleProgressEn" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="meta_description_en" class="form-label small text-muted mb-1">META DESCRIPTION</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-align-left text-info"></i></span>
                                    <textarea class="form-control py-2" id="meta_description_en" name="meta_description_en" rows="3" placeholder="SEO Description (max 160 chars)" maxlength="160"></textarea>
                                </div>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-info" id="descProgressEn" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title" id="editKategoriModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Kategori Oleh-Oleh
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <!-- Indonesian Section -->
                        <div class="col-md-6 border-end pe-3">
                            <h6 class="text-primary mb-3 d-flex align-items-center">
                                <i class="fas fa-flag me-2"></i> Bahasa Indonesia
                            </h6>
                            <div class="mb-3">
                                <label for="edit_nama_kategori_oleholeh" class="form-label small text-muted mb-1">NAMA KATEGORI OLEH-OLEH</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-tag text-primary"></i></span>
                                    <input type="text" class="form-control py-2" id="edit_nama_kategori_oleholeh" name="nama_kategori_oleholeh" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_meta_title_id" class="form-label small text-muted mb-1">META TITLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-heading text-primary"></i></span>
                                    <input type="text" class="form-control py-2" id="edit_meta_title_id" name="meta_title_id" maxlength="60">
                                </div>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar" id="editTitleProgressId" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_meta_description_id" class="form-label small text-muted mb-1">META DESCRIPTION</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-align-left text-primary"></i></span>
                                    <textarea class="form-control py-2" id="edit_meta_description_id" name="meta_description_id" rows="3" maxlength="160"></textarea>
                                </div>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar" id="editDescProgressId" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- English Section -->
                        <div class="col-md-6 ps-3">
                            <h6 class="text-info mb-3 d-flex align-items-center">
                                <i class="fas fa-flag-usa me-2"></i> English
                            </h6>
                            <div class="mb-3">
                                <label for="edit_nama_kategori_oleholeh_en" class="form-label small text-muted mb-1">SOUVENIR CATEGORY NAME</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-tag text-info"></i></span>
                                    <input type="text" class="form-control py-2" id="edit_nama_kategori_oleholeh_en" name="nama_kategori_oleholeh_en" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_meta_title_en" class="form-label small text-muted mb-1">META TITLE</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-heading text-info"></i></span>
                                    <input type="text" class="form-control py-2" id="edit_meta_title_en" name="meta_title_en" maxlength="60">
                                </div>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-info" id="editTitleProgressEn" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_meta_description_en" class="form-label small text-muted mb-1">META DESCRIPTION</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-align-left text-info"></i></span>
                                    <textarea class="form-control py-2" id="edit_meta_description_en" name="meta_description_en" rows="3" maxlength="160"></textarea>
                                </div>
                                <div class="progress mt-1" style="height: 3px;">
                                    <div class="progress-bar bg-info" id="editDescProgressEn" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detail Category Modal -->
<div class="modal fade" id="detailKategoriModal" tabindex="-1" aria-labelledby="detailKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-white border-0">
                <h5 class="modal-title" id="detailKategoriModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Detail Kategori Oleh-Oleh
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Indonesian Section -->
                    <div class="col-md-6 border-end pe-3">
                        <h6 class="text-primary mb-3 d-flex align-items-center">
                            <i class="fas fa-flag me-2"></i> Bahasa Indonesia
                        </h6>

                        <div class="detail-item mb-3">
                            <div class="detail-label text-muted small mb-1">NAMA KATEGORI OLEH-OLEH</div>
                            <div class="detail-content p-3 bg-light rounded-2" id="detail_nama_kategori_oleholeh"></div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label text-muted small mb-1">SLUG</div>
                            <div class="detail-content p-3 bg-light rounded-2" id="detail_slug_kategori"></div>
                        </div>

                        <div class="detail-item mb-3">
                            <div class="detail-label text-muted small mb-1">META TITLE</div>
                            <div class="detail-content p-3 bg-light rounded-2" id="detail_meta_title_id"></div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label text-muted small mb-1">META DESCRIPTION</div>
                            <div class="detail-content p-3 bg-light rounded-2" id="detail_meta_description_id"></div>
                        </div>
                    </div>

                    <!-- English Section -->
                    <div class="col-md-6 ps-3">
                        <h6 class="text-info mb-3 d-flex align-items-center">
                            <i class="fas fa-flag-usa me-2"></i> English
                        </h6>

                        <div class="detail-item mb-3">
                            <div class="detail-label text-muted small mb-1">SOUVENIR CATEGORY NAME</div>
                            <div class="detail-content p-3 bg-light rounded-2" id="detail_nama_kategori_oleholeh_en"></div>
                        </div>
                        <div class="detail-item mb-3">
                            <div class="detail-label text-muted small mb-1">SLUG</div>
                            <div class="detail-content p-3 bg-light rounded-2" id="detail_slug_kategori_en"></div>
                        </div>

                        <div class="detail-item mb-3">
                            <div class="detail-label text-muted small mb-1">META TITLE</div>
                            <div class="detail-content p-3 bg-light rounded-2" id="detail_meta_title_en"></div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label text-muted small mb-1">META DESCRIPTION</div>
                            <div class="detail-content p-3 bg-light rounded-2" id="detail_meta_description_en"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <div class="icon-circle bg-danger bg-opacity-10 text-danger mb-3 mx-auto">
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                    </div>
                    <h5 class="mb-2">Konfirmasi Hapus</h5>
                    <p class="text-muted mb-3">Anda akan menghapus kategori oleh-oleh berikut:</p>
                    <div class="alert alert-light py-2 mb-3">
                        <strong id="deleteCategoryName"></strong>
                    </div>
                    <p class="text-danger small mb-0">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Aksi ini tidak dapat dibatalkan. Semua oleh-oleh dalam kategori ini akan menjadi tidak terkategori.
                    </p>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <a href="#" id="confirmDelete" class="btn btn-danger rounded-pill px-4">
                    <i class="fas fa-trash-alt me-1"></i> Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, rgb(100, 181, 201) 100%);
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .table {
        font-size: 14px;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        color: #6c757d;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .table td {
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }

    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge {
        font-weight: 500;
        border-radius: 8px;
    }

    .form-control {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        border: 1px solid #e0e0e0;
    }

    .form-control:focus {
        border-color: #4d90fe;
        box-shadow: 0 0 0 2px rgba(77, 144, 254, 0.2);
    }

    .btn {
        border-radius: 8px;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 12px;
    }

    .btn-outline-primary,
    .btn-outline-danger {
        border-width: 1px;
    }

    .modal-content {
        border-radius: 12px;
    }

    .modal-header {
        border-radius: 12px 12px 0 0;
    }

    /* DataTables custom styling */
    .dataTables_wrapper .dataTables_length select {
        border-radius: 6px;
        padding: 4px 8px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 6px;
        padding: 4px 8px;
        border: 1px solid #dee2e6;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        margin: 0 2px;
        padding: 4px 10px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #0d6efd !important;
        color: white !important;
        border: none !important;
    }

    .dataTables_wrapper .dataTables_length select {
        width: auto !important;
        display: inline-block !important;
        margin: 0 0.5rem !important;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 14px;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }

    /* Detail Item Styling */
    .detail-item {
        margin-bottom: 1.25rem;
    }

    .detail-label {
        font-weight: 500;
        color: #6c757d;
    }

    .detail-content {
        background-color: #f8f9fa;
        border-radius: 8px;
        word-break: break-word;
    }

    .detail-content:empty::before {
        content: "-";
        color: #adb5bd;
    }

    /* Icon Circle */
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    /* Input Group Enhancements */
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }

    .form-control {
        border-left: none;
        padding: 0.5rem 0.75rem;
    }

    /* Progress Bar Colors */
    .progress-bar {
        transition: width 0.3s ease;
    }
    .progress-bar.bg-warning {
        background-color: #ffc107 !important;
    }
    .progress-bar.bg-danger {
        background-color: #dc3545 !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .dashboard-header {
            text-align: center;
        }

        .dashboard-header .text-md-end {
            text-align: center !important;
            margin-top: 1rem;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            text-align: left !important;
            margin-bottom: 1rem;
        }

        .modal-body .row>[class^="col-"] {
            border-right: none !important;
            border-bottom: 1px solid #eee;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .modal-body .row>[class^="col-"]:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#kategoriTable').DataTable({
            responsive: true,
            dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>><"clear">>',
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [
                {
                    orderable: false,
                    targets: [0] // Kolom No tidak bisa di-sort
                },
                {
                    className: "text-center",
                    targets: [0] // Kolom No di tengah
                },
                {
                    width: "60px",
                    targets: 0
                }
                <?php if (in_array($role, ['admin', 'penulis'])): ?>
                ,{
                    orderable: false,
                    targets: [3] // Kolom aksi tidak bisa di-sort
                },
                {
                    className: "text-center",
                    targets: [3] // Kolom aksi di tengah
                },
                {
                    width: "150px",
                    targets: 3 // Lebar kolom aksi
                }
                <?php endif; ?>
            ],
            initComplete: function() {
                $('.dataTables_length select').addClass('form-select-sm');
                $('.dataTables_filter input').addClass('form-control-sm');
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });

        // Handle detail button click
        $('#kategoriTable').on('click', '.detail-btn', function() {
            $('#detail_nama_kategori_oleholeh').text($(this).data('nama') || '-');
            $('#detail_nama_kategori_oleholeh_en').text($(this).data('nama-en') || '-');
            $('#detail_slug_kategori').text($(this).data('slug') || '-');
            $('#detail_slug_kategori_en').text($(this).data('slug-en') || '-');
            $('#detail_meta_title_id').text($(this).data('meta-title-id') || '-');
            $('#detail_meta_title_en').text($(this).data('meta-title-en') || '-');
            $('#detail_meta_description_id').text($(this).data('meta-desc-id') || '-');
            $('#detail_meta_description_en').text($(this).data('meta-desc-en') || '-');
            $('#detailKategoriModal').modal('show');
        });

        // Handle edit button click
        $('#kategoriTable').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var nama_en = $(this).data('nama-en');
            var meta_title_id = $(this).data('meta-title-id');
            var meta_title_en = $(this).data('meta-title-en');
            var meta_desc_id = $(this).data('meta-desc-id');
            var meta_desc_en = $(this).data('meta-desc-en');

            $('#edit_nama_kategori_oleholeh').val(nama);
            $('#edit_nama_kategori_oleholeh_en').val(nama_en);
            $('#edit_meta_title_id').val(meta_title_id);
            $('#edit_meta_title_en').val(meta_title_en);
            $('#edit_meta_description_id').val(meta_desc_id);
            $('#edit_meta_description_en').val(meta_desc_en);
            $('#editForm').attr('action', '<?= base_url($role . "/kategori_oleholeh/proses_edit") ?>/' + id);

            // Update progress bars for edit modal
            updateProgressBar('#edit_meta_title_id', '#editTitleProgressId');
            updateProgressBar('#edit_meta_title_en', '#editTitleProgressEn');
            updateProgressBar('#edit_meta_description_id', '#editDescProgressId');
            updateProgressBar('#edit_meta_description_en', '#editDescProgressEn');

            $('#editKategoriModal').modal('show');
        });

        // Handle delete button click
        $('#kategoriTable').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var url = '<?= base_url($role . "/kategori_oleholeh/delete") ?>/' + id;
            $('#confirmDelete').attr('href', url);
            $('#deleteCategoryName').text(nama);
            $('#deleteModal').modal('show');
        });

        // Function to update progress bars
        function updateProgressBar(inputSelector, progressBarSelector) {
            var length = $(inputSelector).val().length;
            var maxLength = $(inputSelector).attr('maxlength') || 160;
            var percent = (length / maxLength) * 100;
            
            $(progressBarSelector).css('width', percent + '%')
                .toggleClass('bg-warning', percent > 80)
                .toggleClass('bg-danger', percent > 95);
        }

        // Character count progress for meta fields in add modal
        $('#meta_title_id, #meta_title_en').on('input', function() {
            updateProgressBar(this, this.id === 'meta_title_id' ? '#titleProgressId' : '#titleProgressEn');
        });

        $('#meta_description_id, #meta_description_en').on('input', function() {
            updateProgressBar(this, this.id === 'meta_description_id' ? '#descProgressId' : '#descProgressEn');
        });

        // Character count progress for meta fields in edit modal
        $('#edit_meta_title_id, #edit_meta_title_en').on('input', function() {
            updateProgressBar(this, this.id === 'edit_meta_title_id' ? '#editTitleProgressId' : '#editTitleProgressEn');
        });

        $('#edit_meta_description_id, #edit_meta_description_en').on('input', function() {
            updateProgressBar(this, this.id === 'edit_meta_description_id' ? '#editDescProgressId' : '#editDescProgressEn');
        });

        // Reinitialize tooltips when DataTable redraws
        table.on('draw', function() {
            $('[title]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
        });

        // Auto-focus first input when modal opens
        $('#tambahKategoriModal, #editKategoriModal').on('shown.bs.modal', function() {
            $(this).find('input[type="text"]').first().focus();
        });
    });
</script>

<?= $this->endSection('content') ?>