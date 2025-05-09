<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-title">
                        <i class="fas fa-ad me-2 text-primary"></i>Manajemen Tipe Iklan Konten
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tipe Iklan Konten</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Tipe Iklan
                    </button>
                </div>
            </div>
        </div>

        <!-- Notification Alert -->
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div><?= session()->getFlashdata('success') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Data Table -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="5%">No</th>
                                <th width="10%">Tipe Iklan</th>
                                <th class="text-end" width="10%">Harga</th>
                                <th class="text-center pe-4" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tipeiklankonten)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-ad fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted mb-3">Belum ada data tipe iklan</h5>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                                <i class="fas fa-plus-circle me-2"></i>Tambah Tipe Iklan
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php $no = 1; ?>
                            <?php foreach ($tipeiklankonten as $tipe) : ?>
                                <tr>
                                    <td class="ps-4"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-container bg-primary-soft text-primary me-3">
                                                <i class="fas fa-ad"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?= esc($tipe['nama']) ?></h6>
                                                <small class="text-muted">ID: TI-<?= str_pad($tipe['id_harga_iklan'], 4, '0', STR_PAD_LEFT) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        Rp<?= number_format($tipe['harga'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-outline-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal<?= $tipe['id_harga_iklan'] ?>"
                                                data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?= $tipe['id_harga_iklan'] ?>"
                                                data-bs-toggle="tooltip"
                                                title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Modal - Yellow/Warning Style -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header bg-gradient-success text-white">
                        <div class="modal-icon rounded-circle bg-white text-warning d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-plus fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-1">Tambah Tipe Iklan Baru</h5>
                            <p class="small mb-0">Isi formulir berikut untuk menambahkan tipe iklan baru</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('admin/tipeiklankonten/proses_tambah') ?>" method="POST">
                        <?= csrf_field(); ?>
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <label for="namaInput" class="form-label fw-semibold">Nama Tipe Iklan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>"
                                    id="namaInput" name="nama" placeholder="Contoh: Iklan Premium"
                                    value="<?= old('nama') ?>" required>
                                <?php if (session('errors.nama')) : ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.nama') ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-text">Contoh: Iklan Banner, Iklan Featured, dll.</div>
                            </div>

                            <div class="mb-3">
                                <label for="hargaInput" class="form-label fw-semibold">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="text" class="form-control <?= session('errors.harga') ? 'is-invalid' : '' ?>"
                                        id="hargaInput" name="harga" placeholder="1.000.000"
                                        value="<?= old('harga') ?>" required
                                        oninput="formatCurrency(this)">
                                    <?php if (session('errors.harga')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.harga') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-text">Masukkan harga tanpa titik atau koma</div>
                            </div>

                            <div class="alert alert-info mt-4">
                                <div class="d-flex">
                                    <i class="fas fa-info-circle me-2 mt-1"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Tips</h6>
                                        <p class="small mb-0">Pastikan nama tipe iklan deskriptif dan mudah dipahami oleh pengiklan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-check me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modals - Green/Success Style -->
        <?php foreach ($tipeiklankonten as $tipe) : ?>
            <div class="modal fade" id="editModal<?= $tipe['id_harga_iklan'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">
                        <div class="modal-header  bg-gradient-warning text-dark">
                            <div class="modal-icon rounded-circle bg-white text-warning d-flex align-items-center justify-content-center me-3">
                                <i class="fas fa-edit fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="modal-title mb-1">Edit Tipe Iklan</h5>
                                <p class="small mb-0">Perbarui informasi tipe iklan</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('admin/tipeiklankonten/update/' . $tipe['id_harga_iklan']) ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="modal-body p-4">
                                <div class="mb-4">
                                    <label for="editNama<?= $tipe['id_harga_iklan'] ?>" class="form-label fw-semibold">Nama Tipe Iklan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="editNama<?= $tipe['id_harga_iklan'] ?>"
                                        name="nama" placeholder="Nama Tipe Iklan"
                                        value="<?= old('nama', esc($tipe['nama'])) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="editHarga<?= $tipe['id_harga_iklan'] ?>" class="form-label fw-semibold">Harga <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">Rp</span>
                                        <input type="text" class="form-control" id="editHarga<?= $tipe['id_harga_iklan'] ?>"
                                            name="harga" placeholder="Harga"
                                            value="<?= old('harga', number_format($tipe['harga'], 0, ',', '.')) ?>" required
                                            oninput="formatCurrency(this)">
                                    </div>
                                </div>

                                <div class="card border-0 bg-light mt-4">
                                    <div class="card-body p-3">
                                        <h6 class="card-title mb-3 fw-semibold">Informasi Sistem</h6>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-id-card text-muted me-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">ID</small>
                                                        <span class="fw-semibold">TI-<?= str_pad($tipe['id_harga_iklan'], 4, '0', STR_PAD_LEFT) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-plus text-muted me-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Dibuat</small>
                                                        <span class="fw-semibold"><?= date('d M Y', strtotime($tipe['created_at'])) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-check text-muted me-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Terakhir Update</small>
                                                        <span class="fw-semibold"><?= date('d M Y', strtotime($tipe['updated_at'])) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top">
                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Delete Modals -->
        <?php foreach ($tipeiklankonten as $tipe) : ?>
            <div class="modal fade" id="deleteModal<?= $tipe['id_harga_iklan'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header border-0 pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center px-4">
                            <div class="icon-container bg-danger-soft text-danger mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                            <h5 class="modal-title mb-3">Konfirmasi Penghapusan</h5>
                            <p class="mb-0">Anda akan menghapus tipe iklan:</p>
                            <h6 class="mb-3">"<?= esc($tipe['nama']) ?>"</h6>
                            <p class="text-muted small">Tindakan ini tidak dapat dibatalkan. Pastikan data yang dihapus benar.</p>
                        </div>
                        <div class="modal-footer border-0 justify-content-center">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                            <form action="<?= base_url('admin/tipeiklankonten/delete/' . $tipe['id_harga_iklan']) ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger px-4">
                                    <i class="fas fa-trash-alt me-2"></i>Hapus Permanen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>


        <style>
            /* Color Gradients */
            .bg-gradient-warning {
                background: linear-gradient(135deg, #ffc107 0%, #ffab00 100%);
            }

            .bg-gradient-success {
                background: linear-gradient(135deg, #198754 0%, #157347 100%);
            }

            .bg-gradient-danger {
                background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%);
            }

            .bg-gradient-info {
                background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
            }

            /* Text Colors for Headers */
            .bg-gradient-warning.text-dark {
                color: #212529 !important;
            }

            .bg-gradient-warning .btn-close {
                filter: brightness(0) saturate(100%);
            }

            /* Icon Colors */
            .text-warning {
                color: #ffc107 !important;
            }

            .text-success {
                color: #198754 !important;
            }

            .text-danger {
                color: #dc3545 !important;
            }

            .text-info {
                color: #0dcaf0 !important;
            }

            /* Responsive adjustments */
            @media (max-width: 576px) {
                .modal-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .modal-icon {
                    margin-bottom: 1rem;
                }
            }

            /* Modal Header Enhancements */
            .modal-header.bg-gradient-primary {
                background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
                padding: 1.5rem;
            }

            .modal-icon {
                width: 40px;
                height: 40px;
                flex-shrink: 0;
            }

            /* Form Enhancements */
            .form-label {
                font-weight: 500;
                margin-bottom: 0.5rem;
            }

            .form-control {
                padding: 0.75rem 1rem;
                border-radius: 8px;
            }

            .input-group-text {
                border-radius: 8px 0 0 8px;
                background-color: #f8f9fa;
            }

            /* Alert Box */
            .alert-info {
                background-color: #f0f7ff;
                border-color: #d0e3ff;
                color: #084298;
            }

            /* Info Card */
            .card.bg-light {
                background-color: #f8f9fa !important;
                border-radius: 10px;
            }

            /* Responsive adjustments */
            @media (max-width: 576px) {
                .modal-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .modal-icon {
                    margin-bottom: 1rem;
                }
            }
        </style>

        <script>
            // Enhanced currency formatting with validation
            function formatCurrency(input) {
                // Remove all non-digit characters
                let value = input.value.replace(/\D/g, '');

                // Format with thousand separators
                if (value.length > 0) {
                    value = parseInt(value, 10).toLocaleString('id-ID');
                }

                // Update the input value
                input.value = value;

                // Store the raw numeric value in a data attribute for form submission
                input.dataset.numericValue = value.replace(/\D/g, '');
            }

            // Before form submission, replace the formatted value with the numeric value
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    this.querySelectorAll('[oninput="formatCurrency(this)"]').forEach(input => {
                        input.value = input.dataset.numericValue || input.value.replace(/\D/g, '');
                    });
                });
            });

            // Initialize all currency inputs on page load
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[oninput="formatCurrency(this)"]').forEach(input => {
                    if (input.value) {
                        formatCurrency(input);
                    }
                });
            });
        </script>

        <?= $this->endSection('content'); ?>