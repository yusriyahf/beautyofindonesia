<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Kelola Oleh-Oleh</h1>
                <p class="text-muted mb-0">Kelola semua produk oleh-oleh di website Anda</p>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('admin/oleh_oleh/tambah') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Oleh-Oleh Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Daftar Oleh-Oleh</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-actions">
                            <span class="badge bg-success me-2">Total: <?= count($data_oleh_oleh) ?></span>
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
                                <th width="20%">Nama Oleh-Oleh</th>
                                <th width="15%">Kategori</th>
                                <th width="15%">Lokasi</th>
                                <th class="text-center" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data_oleh_oleh) && is_array($data_oleh_oleh)): ?>
                                <?php foreach ($data_oleh_oleh as $index => $item): ?>
                                    <tr>
                                        <td class="text-center"><?= $index + 1 ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <img src="<?= base_url('assets-baru/img/foto_oleholeh/' . ($item['foto_oleholeh'] ?? 'default.jpg')) ?>"
                                                        class="img-fluid rounded"
                                                        width="60"
                                                        alt="<?= $item['nama_oleholeh'] ?>">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1"><?= esc($item['nama_oleholeh']) ?></h6>
                                                    <small class="text-muted"><?= esc($item['nama_oleholeh_eng']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= esc($item['nama_kategori_oleholeh']) ?></span>
                                        </td>
                                        <td>
                                            <span class="d-block"><?= esc($item['nama_kotakabupaten']) ?></span>
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?= $item['oleholeh_latitude'] ?>, <?= $item['oleholeh_longitude'] ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/oleh_oleh/edit/' . $item['id_oleholeh']) ?>"
                                                    class="btn btn-outline-success btn-sm rounded-pill me-2">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                <a href="<?= base_url('admin/oleh_oleh/delete/' . $item['id_oleholeh']) ?>"
                                                    class="btn btn-outline-danger btn-sm rounded-pill"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                    <i class="fas fa-trash me-1"></i>Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                                            <h5>Belum Ada Data Oleh-Oleh</h5>
                                            <p class="text-muted">Tambahkan produk oleh-oleh pertama Anda untuk memulai</p>
                                            <a href="<?= base_url('admin/oleh_oleh/tambah') ?>" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Tambah Oleh-Oleh Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if (!empty($data_oleh_oleh) && is_array($data_oleh_oleh)): ?>
                <div class="app-card-footer px-4 py-3">
                    <nav aria-label="Navigasi halaman">
                        <ul class="pagination justify-content-end mb-0">
                            <!-- Tautan pagination akan ditempatkan di sini -->
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
    // Aktifkan tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>