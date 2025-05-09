<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-title">
                        <i class="fas fa-ad me-2 text-primary"></i>Manajemen Tipe Iklan Utama
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tipe Iklan Utama</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Tipe Iklan Utama
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

        <!-- Data Table -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="5%">No</th>
                                <th width="30%">Tipe Iklan</th>
                                <th class="text-end" width="20%">Harga</th>
                                <th class="text-center" width="15%">Status</th>
                                <th class="text-center pe-4" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tipeiklanutama)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
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
                            <?php foreach ($tipeiklanutama as $tipe) : ?>
                                <tr>
                                    <td class="ps-4"><?= $no++ ?></td>
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
                                    <td class="text-end">
                                        Rp<?= number_format($tipe['harga'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($tipe['status'] == 'ada') : ?>
                                            <span class="badge bg-success-soft text-success rounded-pill px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i> Aktif
                                            </span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary-soft text-secondary rounded-pill px-3 py-2">
                                                <i class="fas fa-times-circle me-1"></i> Nonaktif
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal<?= $tipe['id_tipe_iklan_utama'] ?>"
                                                data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?= $tipe['id_tipe_iklan_utama'] ?>"
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

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center">
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

        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Tipe Iklan Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('admin/tipeiklanutama/proses_tambah') ?>" method="POST">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Tipe Iklan</label>
                                    <input type="text" class="form-control" name="nama" value="<?= old('nama') ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="harga" value="<?= old('harga') ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status" required>
                                        <option value="" disabled selected>Pilih status</option>
                                        <option value="ada" <?= old('status') == 'ada' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="tidak" <?= old('status') == 'tidak' ? 'selected' : '' ?>>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modals -->
        <?php foreach ($tipeiklanutama as $tipe) : ?>
            <div class="modal fade" id="editModal<?= $tipe['id_tipe_iklan_utama'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-edit me-2 text-primary"></i>Edit Tipe Iklan
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('admin/tipeiklanutama/update/' . $tipe['id_tipe_iklan_utama']) ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Tipe Iklan</label>
                                        <input type="text" class="form-control" name="nama" value="<?= old('nama', esc($tipe['nama'])) ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" name="harga" value="<?= old('harga', esc($tipe['harga'])) ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status" required>
                                            <option value="ada" <?= ($tipe['status'] == 'ada') ? 'selected' : '' ?>>Aktif</option>
                                            <option value="tidak" <?= ($tipe['status'] == 'tidak') ? 'selected' : '' ?>>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
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
                                <i class="fas fa-trash-alt me-2"></i>Hapus Permanen
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .page-header {
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

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

    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-secondary-soft {
        background-color: rgba(108, 117, 125, 0.1);
    }

    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .empty-state {
        max-width: 360px;
        margin: 0 auto;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }

    .btn-sm {
        padding: 0.35rem 0.5rem;
        border-radius: 6px;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
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