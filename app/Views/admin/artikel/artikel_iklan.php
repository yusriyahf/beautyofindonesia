<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-ad me-2 text-white"></i> Daftar Artikel Beriklan</h1>
                    <p class="mb-0 opacity-75">Kelola semua artikel beriklan di sini</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <?php $role = session()->get('role'); ?>
                    <a href="<?= base_url($role . '/daftariklankonten/tambah') ?>" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-info">
                        <i class="fas fa-plus me-1"></i>Tambah Iklan
                    </a>
                </div>
            </div>
        </div>

        <!-- Modern Filter Section -->
        <div class="card border-0 mb-4">
            <div class="card-body p-4">
                <form method="get" action="<?= base_url('admin/daftariklankonten') ?>">
                    <div class="row g-3 align-items-end">
                        <!-- Date Range Filter -->
                        <div class="col-md-3">
                            <label class="form-label small text-muted mb-1">TANGGAL MULAI</label>
                            <div class="input-group">
                                <input type="date" id="start_date" name="start_date" class="form-control" 
                                    value="<?= esc($_GET['start_date'] ?? '') ?>">
                                <span class="input-group-text bg-transparent">
                                    <i class="far fa-calendar-alt text-muted"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted mb-1">TANGGAL AKHIR</label>
                            <div class="input-group">
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                    value="<?= esc($_GET['end_date'] ?? '') ?>">
                                <span class="input-group-text bg-transparent">
                                    <i class="far fa-calendar-alt text-muted"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-3">
                            <label class="form-label small text-muted mb-1">STATUS IKLAN</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="diajukan" <?= (($_GET['status'] ?? '') == 'diajukan') ? 'selected' : '' ?>>Diajukan</option>
                                <option value="diterima" <?= (($_GET['status'] ?? '') == 'diterima') ? 'selected' : '' ?>>Disetujui</option>
                                <option value="ditolak" <?= (($_GET['status'] ?? '') == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                                <option value="berjalan" <?= (($_GET['status'] ?? '') == 'berjalan') ? 'selected' : '' ?>>Berjalan</option>
                                <option value="selesai" <?= (($_GET['status'] ?? '') == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-md-3 d-flex">
                            <a href="<?= base_url('admin/daftariklankonten') ?>" class="btn btn-outline-secondary me-2 flex-grow-1">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                            <button type="submit" class="btn btn-info flex-grow-1 text-white">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($all_data)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-ad fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada artikel beriklan</h5>
                        <p class="text-muted mb-3">Mulai dengan membuat iklan baru</p>
                        <a href="<?= base_url($role . '/daftariklankonten/tambah') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Iklan
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="iklanTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Judul Artikel</th>
                                    <th width="150">Tipe Iklan</th>
                                    <th width="120">Penulis</th>
                                    <th width="120" class="text-center">Durasi</th>
                                    <th width="120" class="text-end">Harga</th>
                                    <th width="120" class="text-center">Status</th>
                                    <th width="150" class="text-center">Periode</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $startDate = $_GET['start_date'] ?? null;
                                $endDate = $_GET['end_date'] ?? null;
                                $statusFilter = $_GET['status'] ?? null;
                                
                                foreach ($all_data as $item): 
                                    $tanggalMulai = $item['tanggal_mulai'];
                                    $statusIklan = $item['status_iklan'];
                                    
                                    // Filter logic
                                    if ($startDate && $tanggalMulai < $startDate) continue;
                                    if ($endDate && $tanggalMulai > $endDate) continue;
                                    if ($statusFilter && $statusIklan != $statusFilter) continue;
                                    
                                    // Status badge styling
                                    $badgeClass = [
                                        'diajukan' => 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10',
                                        'diterima' => 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10',
                                        'ditolak' => 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10',
                                        'berjalan' => 'bg-success bg-opacity-10 text-success border border-success border-opacity-10',
                                        'selesai' => 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10'
                                    ][$statusIklan] ?? 'bg-light text-dark';
                                ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $i++ ?></td>
                                        <td>
                                            <div class="fw-medium text-truncate" style="max-width: 250px;"><?= esc($item['judul_konten']) ?></div>
                                            <small class="text-muted"><?= esc($item['tipe_content'] ?? 'N/A') ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10">
                                                <?= esc($item['nama']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <span class="avatar-initials bg-light text-dark rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px; font-size: 10px;">
                                                        <?= strtoupper(substr($item['username'] ?? 'U', 0, 1)) ?>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1 text-truncate" style="max-width: 100px;">
                                                    <?= esc($item['username']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <?= esc($item['rentang_bulan']) ?> Bulan
                                        </td>
                                        <td class="text-end">
                                            Rp <?= number_format($item['total_harga'], 0, ',', '.') ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge <?= $badgeClass ?>">
                                                <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i>
                                                <?= ucfirst($statusIklan) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($item['tanggal_mulai']): ?>
                                                <small class="text-muted">
                                                    <?= date('d M Y', strtotime($item['tanggal_mulai'])) ?>
                                                    <br>s/d<br>
                                                    <?= date('d M Y', strtotime($item['tanggal_selesai'])) ?>
                                                </small>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="<?= base_url('admin/daftariklankonten/detail/' . $item['id_iklan']) ?>" 
                                                    class="btn btn-sm btn-outline-primary" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/daftariklankonten/edit/' . $item['id_iklan']) ?>" 
                                                    class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/daftariklankonten/delete/' . $item['id_iklan']) ?>" 
                                                    class="btn btn-sm btn-outline-danger delete-btn" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if (!empty($all_data)): ?>
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan <?= count($all_data) ?> data
                        </div>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Custom styling for the filter section */
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }

    .form-control,
    .form-select {
        border: 1px solid #e0e0e0;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4d90fe;
        box-shadow: 0 0 0 2px rgba(77, 144, 254, 0.2);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #e0e0e0;
    }

    .btn {
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }

    label {
        font-weight: 500;
    }

    .btn-sm {
        padding: 0.4rem 1rem;
        border-radius: 8px;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%,rgb(100, 181, 201) 100%);
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

    .badge {
        font-weight: 500;
        padding: 4px 8px;
    }

    .avatar-initials {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    .pagination {
        margin: 0;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .page-link {
        font-size: 14px;
        padding: 6px 12px;
    }

    @media (max-width: 768px) {
        .card-footer {
            flex-direction: column;
            gap: 10px;
        }

        .table td,
        .table th {
            padding: 8px 12px;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#iklanTable').DataTable({
            responsive: true,
            searching: false,
            ordering: true,
            paging: false,
            info: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                orderable: false,
                targets: [8] // Disable sorting for action column
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
    });
</script>

<?= $this->endSection('content'); ?>