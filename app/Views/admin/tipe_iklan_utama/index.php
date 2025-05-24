<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-ad me-2 text-white"></i>Manajemen Tipe Iklan Utama</h1>
                    <p class="mb-0 opacity-75">Kelola semua tipe iklan utama di sini</p>
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

        <!-- Data Table Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($tipeiklanutama)) : ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-ad fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada tipe iklan</h5>
                        <p class="text-muted mb-3">Tidak ada tipe iklan utama yang tersedia</p>
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
                                    <th width="120" class="text-center">Status</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($tipeiklanutama as $tipe) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-container bg-primary-soft text-primary me-3">
                                                    <i class="fas fa-ad"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= esc($tipe['nama']) ?></h6>
                                                    <small class="text-muted">ID: TI-<?= str_pad($tipe['id_tipe_iklan_utama'], 4, '0', STR_PAD_LEFT) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold">
                                            Rp<?= number_format($tipe['harga'], 0, ',', '.') ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($tipe['status'] == 'ada') : ?>
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10">
                                                    <i class="fas fa-check-circle me-1"></i> Aktif
                                                </span>
                                            <?php else : ?>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10">
                                                    <i class="fas fa-times-circle me-1"></i> Nonaktif
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal<?= $tipe['id_tipe_iklan_utama'] ?>"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal<?= $tipe['id_tipe_iklan_utama'] ?>"
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

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Menampilkan <span class="fw-bold"><?= count($tipeiklanutama) ?></span> dari <span class="fw-bold"><?= $totalItems ?? count($tipeiklanutama) ?></span> entri
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Selanjutnya</a>
                    </li>
                </ul>
            </nav>
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
            <form action="<?= base_url('admin/tipeiklanutama/proses_tambah') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Tipe Iklan</label>
                        <input type="text" class="form-control" name="nama" value="<?= old('nama') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="harga" value="<?= old('harga') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="" disabled selected>Pilih status</option>
                            <option value="ada" <?= old('status') == 'ada' ? 'selected' : '' ?>>Aktif</option>
                            <option value="tidak" <?= old('status') == 'tidak' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
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
<?php foreach ($tipeiklanutama as $tipe) : ?>
    <div class="modal fade" id="editModal<?= $tipe['id_tipe_iklan_utama'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Tipe Iklan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/tipeiklanutama/update/' . $tipe['id_tipe_iklan_utama']) ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Tipe Iklan</label>
                            <input type="text" class="form-control" name="nama" value="<?= old('nama', esc($tipe['nama'])) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="harga" value="<?= old('harga', esc($tipe['harga'])) ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="ada" <?= ($tipe['status'] == 'ada') ? 'selected' : '' ?>>Aktif</option>
                                <option value="tidak" <?= ($tipe['status'] == 'tidak') ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
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
<?php foreach ($tipeiklanutama as $tipe) : ?>
    <div class="modal fade" id="deleteModal<?= $tipe['id_tipe_iklan_utama'] ?>" tabindex="-1" aria-hidden="true">
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
                    <a href="<?= base_url('admin/tipeiklanutama/delete/' . $tipe['id_tipe_iklan_utama']) ?>" class="btn btn-danger px-4">
                        <i class="fas fa-trash-alt me-2"></i>Hapus
                    </a>
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

    /* Badge Styling */
    .badge {
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 20px;
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
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#tipeIklanTable').DataTable({
            responsive: true,
            searching: true,
            ordering: true,
            paging: false,
            info: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                orderable: false,
                targets: [4] // Disable sorting for action column
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
            <?php if ($validation->hasError('nama') || $validation->hasError('harga') || $validation->hasError('status')) : ?>
                var addModal = new bootstrap.Modal(document.getElementById('addModal'));
                addModal.show();
            <?php endif; ?>
        <?php endif; ?>
    });
</script>

<?= $this->endSection('content'); ?>