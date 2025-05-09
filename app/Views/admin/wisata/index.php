<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Kelola Tempat Wisata</h1>
                <p class="text-muted mb-0">Kelola semua tujuan wisata di website Anda</p>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('admin/tempat_wisata/tambah') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Destination
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">List Tempat Wisata</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-actions">
                            <span class="badge bg-success me-2">Total: <?= count($wisata) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-card-body px-4">
                <div class="table-responsive">
                    <table class="table app-table-hover table-striped table-borderless align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="20%">Destination Name</th>
                                <th width="15%">Category</th>
                                <th width="15%">Location</th>
                                <th class="text-center" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($wisata) > 0): ?>
                                <?php
                                $page = $pager->getCurrentPage('tempatwisata');
                                $offset = ($page - 1) * 10;

                                $i = $offset + 1;
                                foreach ($wisata as $index => $w): ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <img src="<?= base_url('asset-user/uploads/foto_wisata/' . ($w['foto_wisata'] ?? 'default.jpg')) ?>"
                                                        class="img-fluid rounded"
                                                        width="60"
                                                        alt="<?= $w['nama_wisata_ind'] ?>">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1"><?= $w['nama_wisata_ind'] ?></h6>
                                                    <small class="text-muted"><?= $w['nama_wisata_eng'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary me-1"><?= $w['nama_kategori_wisata'] ?></span>
                                            <span class="badge bg-secondary"><?= $w['nama_kategori_wisata_en'] ?></span>
                                        </td>
                                        <td>
                                            <span class="d-block"><?= $w['nama_kotakabupaten'] ?></span>
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?= $w['wisata_latitude'] ?>, <?= $w['wisata_longitude'] ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/tempat_wisata/detail/' . $w['id_wisata']) ?>"
                                                    class="btn btn-outline-primary btn-sm rounded-pill me-2">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                                <a href="<?= base_url('admin/tempat_wisata/edit/' . $w['id_wisata']) ?>"
                                                    class="btn btn-outline-success btn-sm rounded-pill me-2">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                <a href="<?= base_url('admin/tempat_wisata/delete/' . $w['id_wisata']) ?>"
                                                    class="btn btn-outline-danger btn-sm rounded-pill"
                                                    onclick="return confirm('Delete this item?')">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                            <h5>No Tourism Places Found</h5>
                                            <p class="text-muted">Add your first tourism destination to get started</p>
                                            <a href="<?= base_url('admin/tempat_wisata/tambah') ?>" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Add New Destination
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if (count($wisata) > 0): ?>
                <div class="app-card-footer px-4 py-3">
                    <div class="mt-3">
                        <?= $pager->links('tempatwisata', 'bootstrap_full') ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<style>
    .app-card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
    }

    .app-card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, .05);
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .empty-state {
        padding: 2rem;
        text-align: center;
    }

    .img-fluid.rounded {
        object-fit: cover;
        height: 60px;
        width: 60px;
    }
</style>

<script>
    // Enable tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>