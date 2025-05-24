<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-ad me-2 text-white"></i>Manajemen Tipe Iklan Konten</h1>
                    <p class="mb-0 opacity-75">Kelola semua tipe iklan konten di sini</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button type="button" class="btn btn-light text-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Tipe Iklan
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications -->
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

        <!-- Data Table Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($tipeiklankonten)) : ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-ad fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada tipe iklan</h5>
                        <p class="text-muted mb-3">Tidak ada tipe iklan konten yang tersedia</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Tipe Iklan
                        </button>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table id="tipeIklanTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Tipe Iklan</th>
                                    <th width="150" class="text-end">Harga</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($tipeiklankonten as $tipe) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
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
                                        <td class="text-end fw-bold">
                                            Rp<?= number_format($tipe['harga'], 0, ',', '.') ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal<?= $tipe['id_harga_iklan'] ?>"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal<?= $tipe['id_harga_iklan'] ?>"
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Tipe Iklan Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/tipeiklankonten/proses_tambah') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Tipe Iklan</label>
                        <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>" 
                            name="nama" value="<?= old('nama') ?>" required>
                        <?php if (session('errors.nama')) : ?>
                            <div class="invalid-feedback">
                                <?= session('errors.nama') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control <?= session('errors.harga') ? 'is-invalid' : '' ?>" 
                                name="harga" value="<?= old('harga') ?>" required
                                oninput="formatCurrency(this)">
                            <?php if (session('errors.harga')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.harga') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modals -->
<?php foreach ($tipeiklankonten as $tipe) : ?>
    <div class="modal fade" id="editModal<?= $tipe['id_harga_iklan'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Tipe Iklan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/tipeiklankonten/update/' . $tipe['id_harga_iklan']) ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Tipe Iklan</label>
                            <input type="text" class="form-control" name="nama" 
                                value="<?= old('nama', esc($tipe['nama'])) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" name="harga" 
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update
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
            <div class="modal-content">
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
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <form action="<?= base_url('admin/tipeiklankonten/delete/' . $tipe['id_harga_iklan']) ?>" method="POST" class="d-inline">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fas fa-trash-alt me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<style>
    /* Dashboard Header */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, rgb(100, 181, 201) 100%);
    }

    /* Icon Container */
    .icon-container {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-primary-soft {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1);
    }

    /* Table Styling */
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
        padding: 12px 16px;
        border-bottom: 1px solid #e9ecef;
    }

    .table td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }

    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Button Styling */
    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 6px;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    /* Modal Styling */
    .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
    }

    /* Form Styling */
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }

    .input-group-text {
        background-color: #f8f9fa;
    }

    /* Enhanced DataTables Styling dengan Spacing yang Lebih Baik */
    .dataTables_wrapper {
        padding: 1.5rem;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 0.75rem 0;
        margin: 0.5rem 0;
    }

    /* Search box styling */
    .dataTables_wrapper .dataTables_filter {
        text-align: right;
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_filter label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 250px !important;
        margin-left: 0.5rem !important;
        margin-top: 0 !important;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Length menu styling */
    .dataTables_wrapper .dataTables_length {
        text-align: left;
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_length label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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

    /* Info text styling */
    .dataTables_wrapper .dataTables_info {
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        display: inline-block;
        margin: 0 2px;
        font-size: 14px;
        line-height: 1.25;
        color: #495057;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        transition: all 0.2s ease;
        min-width: 40px;
        text-align: center;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #0056b3;
        background-color: #e9ecef;
        border-color: #adb5bd;
        text-decoration: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        color: #fff !important;
        background-color: #007bff !important;
        border-color: #007bff !important;
        font-weight: 600;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        color: #6c757d !important;
        background-color: #fff !important;
        border-color: #dee2e6 !important;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Table container dengan spacing yang lebih baik */
    .dataTables_wrapper .dataTables_scroll {
        margin: 1rem 0;
    }

    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        .dataTables_wrapper {
            padding: 1rem;
        }

        .dataTables_wrapper .row {
            margin: 0;
        }

        .dataTables_wrapper .col-sm-12 {
            padding: 0;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            float: none !important;
            text-align: center !important;
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_filter label {
            justify-content: center;
            flex-direction: column;
            gap: 0.5rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 100% !important;
            max-width: 300px;
            margin-left: 0 !important;
        }

        .dataTables_wrapper .dataTables_length label {
            justify-content: center;
            flex-direction: column;
            gap: 0.5rem;
        }

        .dataTables_wrapper .dataTables_info {
            float: none !important;
            text-align: center !important;
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: none !important;
            text-align: center !important;
            margin-top: 1rem !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.5rem;
            font-size: 13px;
            margin: 0 1px;
            min-width: 35px;
        }
    }

    @media (max-width: 576px) {
        .dataTables_wrapper {
            padding: 0.75rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin: 0 1px;
            padding: 0.25rem 0.4rem;
            font-size: 12px;
            min-width: 30px;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 100% !important;
            max-width: 250px !important;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#tipeIklanTable').DataTable({
            responsive: true,
            searching: true,
            ordering: true,
            paging: true,
            info: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                orderable: false,
                targets: [3] // Disable sorting for action column
            }],
            initComplete: function() {
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });

        // Initialize tooltips
        $('[title]').tooltip({
            trigger: 'hover',
            placement: 'top'
        });

        <?php if (isset($validation)) : ?>
            <?php if ($validation->hasError('nama') || $validation->hasError('harga')) : ?>
                var addModal = new bootstrap.Modal(document.getElementById('addModal'));
                addModal.show();
            <?php endif; ?>
        <?php endif; ?>
    });

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