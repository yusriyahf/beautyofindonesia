<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/artikel/artikel_beriklan') ?>">Iklan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Iklan</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="app-page-title mb-0">Detail Iklan #<?= $iklan['id_iklan'] ?></h1>
            <a href="<?= base_url('admin/artikel/artikel_beriklan') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <!-- Card Header with Status Badge -->
                    <div class="app-card-header mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="app-card-title text-primary">
                                    <i class="fas fa-ad me-2"></i><?= $iklan['judul_konten'] ?>
                                </h4>
                                <small class="text-muted">ID: <?= $iklan['id_iklan'] ?></small>
                            </div>
                            <span class="badge <?= $iklan['status_iklan'] == 'aktif' ? 'bg-success' : ($iklan['status_iklan'] == 'pending' ? 'bg-warning' : 'bg-secondary') ?> rounded-pill px-3 py-2">
                                <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i> <?= ucfirst($iklan['status_iklan']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="app-card-body">
                        <!-- Advertisement Summary Cards -->
                        <div class="row mb-5">
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                                <i class="fas fa-calendar-alt text-primary fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">Periode Iklan</h6>
                                                <p class="mb-0">
                                                    <?= date('d M Y', strtotime($iklan['tanggal_mulai'])) ?> -
                                                    <?= date('d M Y', strtotime($iklan['tanggal_selesai'])) ?>
                                                    <span class="text-muted">(<?= $iklan['rentang_bulan'] ?> bulan)</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                                                <i class="fas fa-tag text-info fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">Paket Iklan</h6>
                                                <p class="mb-0"><?= $harga['nama'] ?>
                                                    <span class="text-muted">(Rp<?= number_format($harga['harga'], 0, ',', '.') ?>/bulan)</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                                <i class="fas fa-money-bill-wave text-success fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">Total Biaya</h6>
                                                <p class="mb-0 text-success fw-bold">Rp<?= number_format($iklan['total_harga'], 0, ',', '.') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                                                <i class="fas fa-file-invoice-dollar text-warning fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-semibold">Status Pembayaran</h6>
                                                <p class="mb-0">
                                                    <span class="badge bg-success bg-opacity-10 text-success">Lunas</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Preview Section -->
                        <div class="mb-5">
                            <h5 class="mb-3 fw-semibold border-bottom pb-2">
                                <i class="fas fa-image me-2"></i>Preview Iklan
                            </h5>

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-0">
                                    <div class="ratio ratio-16x9">
                                        <img src="" alt="Thumbnail Iklan">
                                    </div>
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 fw-semibold"><?= $iklan['judul_konten'] ?></h6>
                                            <small class="text-muted">
                                                <i class="fas fa-tag me-1"></i><?= ucfirst($iklan['tipe_content']) ?>
                                            </small>
                                        </div>
                                        <a href="" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-external-link-alt me-1"></i>Lihat Konten
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi Gambar (Alt Text)</label>
                                <div class="card border-0 bg-light">
                                    <div class="card-body py-2">
                                        <p class="mb-0">ALT</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-4">
                            <h5 class="mb-3 fw-semibold border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="fas fa-user me-2 text-muted" style="font-size: small;"></i>No Telepon Pengaju
                                            </h6>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 ms-3">
                                                    <small class="text-muted"><?= $iklan['no_pengaju'] ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="fas fa-user me-2 text-muted"></i>Pemohon
                                            </h6>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar avatar-md bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="fw-semibold"><?= $iklan['username'] ?></div>
                                                    <small class="text-muted">ID: <?= $iklan['id_marketing'] ?></small>
                                                    <div class="mt-1">
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock me-1"></i>Diajukan pada <?= date('d M Y', strtotime($iklan['tanggal_pengajuan'])) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="fas fa-user-shield me-2 text-muted"></i>Status Persetujuan
                                            </h6>
                                            <?php if ($iklan['status_iklan'] == 'aktif'): ?>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar avatar-md bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div class="fw-semibold">Disetujui oleh Admin</div>
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock me-1"></i><?= date('d M Y H:i', strtotime($iklan['tanggal_disetujui'])) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            <?php elseif ($iklan['status_iklan'] == 'ditolak'): ?>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar avatar-md bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-times"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div class="fw-semibold">Ditolak oleh Admin</div>
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock me-1"></i><?= date('d M Y H:i', strtotime($iklan['tanggal_disetujui'])) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar avatar-md bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-clock"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div class="fw-semibold">Menunggu Persetujuan</div>
                                                        <small class="text-muted">Proses verifikasi biasanya 1-2 hari kerja</small>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($iklan['catatan_admin'])): ?>
                                <div class="mt-3">
                                    <label class="form-label fw-semibold">Catatan Admin</label>
                                    <div class="card border-0 bg-light">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-comment-dots text-muted mt-1"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <p class="mb-0"><?= nl2br($iklan['catatan_admin']) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        
                    </div>
                </div>
            </div>

            <!-- Sidebar Information -->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-settings shadow-sm p-4 h-100">
                    <div class="app-card-header mb-4">
                        <h4 class="app-card-title text-primary">
                            <i class="fas fa-chart-line me-2"></i>Statistik & Riwayat
                        </h4>
                    </div>
                    <div class="app-card-body">
                        <!-- Statistics Cards -->
                        <?php
                        $jumlah_klik = 10;
                        $jumlah_tayang = 10;
                        ?>
                        <div class="mb-4">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                            <i class="fas fa-eye text-primary fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 fw-semibold">Total Tayangan</h6>
                                            <h6 class="mb-0"><?php echo $jumlah_tayang; ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                            <i class="fas fa-mouse-pointer text-info fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 fw-semibold">Total Klik</h6>
                                            <h6 class="mb-0"><?php echo $jumlah_klik; ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                            <i class="fas fa-percentage text-success fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 fw-semibold">CTR (Click Through Rate)</h6>
                                            <h6 class="mb-0">
                                                <?php echo round(($jumlah_klik / $jumlah_tayang) * 100, 2); ?>%
                                            </h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Analysis -->
                        <div class="alert alert-light border mb-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-chart-pie me-2"></i>Analisis Performa
                            </h6>

                            <?php if ($jumlah_tayang > 0): ?>
                                <?php $ctr = ($jumlah_klik / $jumlah_tayang) * 100; ?>
                                <?php if ($ctr > 5): ?>
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="fas fa-check-circle text-success mt-1 me-2"></i>
                                        <div>
                                            <p class="mb-0 small">Iklan ini memiliki performa <strong>sangat baik</strong> dengan CTR di atas 5%.</p>
                                        </div>
                                    </div>
                                <?php elseif ($ctr > 2): ?>
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="fas fa-check text-success mt-1 me-2"></i>
                                        <div>
                                            <p class="mb-0 small">Iklan ini memiliki performa <strong>baik</strong> dengan CTR rata-rata.</p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="fas fa-exclamation-triangle text-warning mt-1 me-2"></i>
                                        <div>
                                            <p class="mb-0 small">Iklan ini memiliki performa <strong>di bawah rata-rata</strong>. Pertimbangkan untuk memperbaiki gambar atau penempatan.</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-info-circle text-info mt-1 me-2"></i>
                                    <div>
                                        <p class="mb-0 small">Belum ada data tayangan untuk iklan ini.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Status Timeline -->
                        <div class="alert alert-light border">
                            <h6 class="fw-semibold mb-3">
                                <i class="fas fa-history me-2"></i>Riwayat Status
                            </h6>
                            <div class="timeline">
                                <div class="timeline-item <?= $iklan['status_iklan'] == 'aktif' ? 'active' : '' ?>">
                                    <div class="timeline-point"></div>
                                    <div class="timeline-content">
                                        <small class="text-muted"><?= date('d M Y H:i', strtotime($iklan['tanggal_pengajuan'])) ?></small>
                                        <p class="mb-1 fw-semibold">Diajukan oleh <?= $iklan['username'] ?></p>
                                    </div>
                                </div>

                                <?php if ($iklan['status_iklan'] != 'pending'): ?>
                                    <div class="timeline-item active">
                                        <div class="timeline-point"></div>
                                        <div class="timeline-content">
                                            <small class="text-muted"><?= date('d M Y H:i', strtotime($iklan['tanggal_mulai'])) ?></small>
                                            <p class="mb-1 fw-semibold"><?= $iklan['status_iklan'] == 'aktif' ? 'Disetujui' : 'Ditolak' ?> oleh Admin</p>
                                            <?php if (!empty($iklan['catatan_admin'])): ?>
                                                <small class="text-muted">"<?= $iklan['catatan_admin'] ?>"</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="approveModalLabel">Setujui Iklan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/artikel/approve_iklan/' . $iklan['id_iklan']) ?>" method="post">
                <div class="modal-body">
                    <p>Anda yakin ingin menyetujui iklan ini?</p>
                    <div class="mb-3">
                        <label for="approveNotes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="approveNotes" name="catatan_admin" rows="3" placeholder="Berikan catatan jika perlu"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui Iklan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Iklan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/artikel/reject_iklan/' . $iklan['id_iklan']) ?>" method="post">
                <div class="modal-body">
                    <p>Anda yakin ingin menolak iklan ini?</p>
                    <div class="mb-3">
                        <label for="rejectNotes" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectNotes" name="catatan_admin" rows="3" required placeholder="Berikan alasan penolakan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Iklan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nonaktifkan -->
<div class="modal fade" id="nonaktifkanModal" tabindex="-1" aria-labelledby="nonaktifkanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="nonaktifkanModalLabel">Nonaktifkan Iklan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/artikel/nonaktifkan_iklan/' . $iklan['id_iklan']) ?>" method="post">
                <div class="modal-body">
                    <p>Anda yakin ingin menonaktifkan iklan ini?</p>
                    <div class="mb-3">
                        <label for="deactivateNotes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="deactivateNotes" name="catatan_admin" rows="3" placeholder="Berikan catatan jika perlu"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom Timeline Style */
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
        border-left: 2px solid #e9ecef;
        padding-left: 1.5rem;
    }

    .timeline-item:last-child {
        border-left: 0;
        padding-bottom: 0;
    }

    .timeline-point {
        position: absolute;
        left: -10px;
        top: 0;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: #e9ecef;
        border: 3px solid white;
    }

    .timeline-item.active .timeline-point {
        background-color: #0d6efd;
    }

    .timeline-content {
        margin-left: 0;
    }

    /* Avatar Style */
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-md {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    /* Card Hover Effect */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    /* Ratio for image container */
    .ratio-16x9 {
        --bs-aspect-ratio: 56.25%;
    }

    .object-fit-cover {
        object-fit: cover;
    }
</style>

<?= $this->endSection('content'); ?>