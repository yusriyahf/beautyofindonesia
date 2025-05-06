<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header Section -->
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Iklan Utama</h1>
                <p class="text-muted mb-0">Kelola semua Iklan Utama di sini</p>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('marketing/iklanutama/tambah') ?>" class="btn app-btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Iklan Utama
                </a>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Daftar Iklan Utama</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-action">
                            <span class="badge bg-success me-2">Total: <?= count($all_data_iklan_utama) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0">
                        <thead class="text-center">
                            <tr>
                                <th class="cell text-center">No</th>
                                <th class="cell">Marketing</th>
                                <th class="cell">Jenis</th>
                                <th class="cell">Jenis Iklan</th>
                                <th class="cell">Rentang Bulan</th>
                                <th class="cell">Tanggal Pengajuan</th>
                                <th class="cell text-center">Tanggal Mulai</th>
                                <th class="cell text-end">Tanggal Selesai</th>
                                <th class="cell text-center">Status</th>
                                <th class="cell text-center">Harga</th>
                                <!-- <th class="cell text-center">Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($all_data_iklan_utama) && is_array($all_data_iklan_utama)) : ?>
                                <?php foreach ($all_data_iklan_utama as $item) : ?>

                                    <tr class="text-center">
                                        <td class="cell text-center">1</td>
                                        <td class="cell"><?= esc($item['id_marketing'] ?? 'N/A') ?></td>
                                        <td class="cell"><?= esc($item['jenis']) ?></td>
                                        <td class="cell"><?= esc($item['id_tipe_iklan_utama']) ?></td>
                                        <td class="cell text-center">
                                            <?= esc($item['rentang_bulan']) ?> Bulan
                                        </td>
                                        <td class="cell text-center">
                                            <?= esc($item['tanggal_pengajuan']) ?>
                                        </td>

                                        <td class="cell text-center">
                                            <?php if ($item['tanggal_mulai']) : ?>
                                                <small>
                                                    <?= date('d M Y', strtotime($item['tanggal_mulai'])) ?>
                                                    <br>s/d<br>
                                                    <?= date('d M Y', strtotime($item['tanggal_selesai'])) ?>
                                                </small>
                                            <?php else : ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="cell">
                                            <span class="badge bg-light text-dark"><?= esc($item['thumbnail_iklan']) ?></span>
                                        </td>
                                        <td class="cell">
                                            <span class="badge bg-light text-dark"><?= esc($item['status']) ?></span>
                                        </td>
                                        <td class="cell">
                                            <span class="badge bg-light text-dark"><?= esc($item['total_harga']) ?></span>
                                        </td>


                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                                            <p>Tidak ada data yang ditemukan</p>
                                            <a href="<?= base_url('marketing/iklanutama/tambah') ?>" class="btn app-btn-primary">
                                                <i class="fas fa-plus me-2"></i>Tambah Iklan Utama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="app-card-footer px-3 py-2 border-top">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<style>
    .app-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .app-card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .badge {
        font-weight: 500;
        padding: 5px 8px;
    }

    .dropdown-menu {
        min-width: 10rem;
    }
</style>