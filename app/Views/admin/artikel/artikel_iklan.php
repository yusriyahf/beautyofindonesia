<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header Section -->
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Artikel Beriklan</h1>
                <p class="text-muted mb-0">Kelola semua artikel beriklan di sini</p>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('admin/artikel/tambah_artikel_iklan') ?>" class="btn app-btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="app-card app-card-settings shadow-sm p-4 mb-4">
            <div class="app-card-body">
                <form method="get" action="<?= base_url('admin/artikel_iklan') ?>">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" 
                                   value="<?= esc($_GET['start_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" 
                                   value="<?= esc($_GET['end_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Status Iklan</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="diajukan" <?= (($_GET['status'] ?? '') == 'diajukan') ? 'selected' : '' ?>>Diajukan</option>
                                <option value="diterima" <?= (($_GET['status'] ?? '') == 'diterima') ? 'selected' : '' ?>>Disetujui</option>
                                <option value="ditolak" <?= (($_GET['status'] ?? '') == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                                <option value="berjalan" <?= (($_GET['status'] ?? '') == 'berjalan') ? 'selected' : '' ?>>Berjalan</option>
                                <option value="selesai" <?= (($_GET['status'] ?? '') == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn app-btn-primary me-md-2">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="<?= base_url('admin/artikel_iklan') ?>" class="btn btn-secondary">
                                <i class="fas fa-sync-alt me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Daftar Artikel Beriklan</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-action">
                            <span class="badge bg-success me-2">Total: <?= count($all_data) ?></span>
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
                                <th class="cell">Tipe Konten</th>
                                <th class="cell">Judul Artikel</th>
                                <th class="cell">Tipe Iklan</th>
                                <th class="cell">Penulis</th>
                                <th class="cell text-center">Durasi</th>
                                <th class="cell text-end">Harga</th>
                                <th class="cell text-center">Status</th>
                                <th class="cell text-center">Periode</th>
                                <th class="cell text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($all_data) && is_array($all_data)) : ?>
                                <?php 
                                $i = 1;
                                $startDate = $_GET['start_date'] ?? null;
                                $endDate = $_GET['end_date'] ?? null;
                                $statusFilter = $_GET['status'] ?? null;
                                ?>
                                <?php foreach ($all_data as $item) : ?>
                                    <?php
                                    $tanggalMulai = $item['tanggal_mulai'];
                                    $statusIklan = $item['status_iklan'];
                                    
                                    // Filter logic
                                    if ($startDate && $tanggalMulai < $startDate) continue;
                                    if ($endDate && $tanggalMulai > $endDate) continue;
                                    if ($statusFilter && $statusIklan != $statusFilter) continue;
                                    
                                    // Status badge styling
                                    $badgeClass = [
                                        'diajukan' => 'bg-warning',
                                        'diterima' => 'bg-primary',
                                        'ditolak' => 'bg-danger',
                                        'berjalan' => 'bg-success',
                                        'selesai' => 'bg-secondary'
                                    ][$statusIklan] ?? 'bg-light text-dark';
                                    ?>
                                    <tr class="text-center">
                                        <td class="cell text-center"><?= $i++ ?></td>
                                        <td class="cell"><?= esc($item['tipe_content'] ?? 'N/A') ?></td>
                                        <td class="cell"><?= esc($item['judul_konten']) ?></td>
                                        <td class="cell"><?= esc($item['nama']) ?></td>
                                        <td class="cell">
                                            <span class="badge bg-light text-dark"><?= esc($item['username']) ?></span>
                                        </td>
                                        <td class="cell text-center">
                                            <?= esc($item['rentang_bulan']) ?> Bulan
                                        </td>
                                        <td class="cell text-end">
                                            Rp <?= number_format($item['total_harga'], 0, ',', '.') ?>
                                        </td>
                                        <td class="cell text-center">
                                            <span class="badge <?= $badgeClass ?>">
                                                <?= ucfirst($statusIklan) ?>
                                            </span>
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
                                        <td class="cell text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                        id="actionDropdown<?= $item['id_iklan'] ?>" 
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionDropdown<?= $item['id_iklan'] ?>">
                                                    <li>
                                                        <a class="dropdown-item" href="<?= base_url('admin/artikel_iklan/edit/' . $item['id_iklan']) ?>">
                                                            <i class="fas fa-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="<?= base_url('admin/artikel/delete/' . $item['id_iklan']) ?>" 
                                                           onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                            <i class="fas fa-trash me-2"></i>Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                                            <p>Tidak ada data yang ditemukan</p>
                                            <a href="<?= base_url('admin/artikel/tambah_artikel_iklan') ?>" class="btn app-btn-primary">
                                                <i class="fas fa-plus me-2"></i>Tambah Data Baru
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