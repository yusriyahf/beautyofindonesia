<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>
<?php $role = session()->get('role'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-ad me-2 text-white"></i> Detail Iklan Utama</h1>
                    <p class="mb-0 opacity-75">ID Iklan: <?= $iklan['id_iklan_utama'] ?></p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= base_url($role . '/iklanutama') ?>" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-info">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Konten Utama -->
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <!-- Header dengan Status -->
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div>
                            <h4 class="app-card-title text-primary mb-1">
                                <i class="fas fa-info-circle me-2"></i>Informasi Iklan
                            </h4>
                            <div class="text-muted small">
                                Dibuat: <?= date('d/m/Y H:i', strtotime($iklan['dibuat_pada'])) ?>
                                <?php if ($iklan['diperbarui_pada']): ?>
                                    | Diperbarui: <?= date('d/m/Y H:i', strtotime($iklan['diperbarui_pada'])) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <?php
                            $statusColor = match ($iklan['status']) {
                                'diajukan' => 'bg-warning',
                                'diterima' => 'bg-primary',
                                'ditolak' => 'bg-danger',
                                'berjalan' => 'bg-success',
                                'selesai' => 'bg-secondary',
                                default => 'bg-light'
                            };
                            ?>
                            <span class="badge <?= $statusColor ?> text-capitalize py-2 px-3">
                                <?= $iklan['status'] ?>
                            </span>
                        </div>
                    </div>

                    <!-- Informasi Paket dan Periode -->
                    <div class="row mb-4 g-3">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">
                                        <i class="fas fa-box-open me-2"></i>Paket Iklan
                                    </h6>
                                    <h5 class="fw-bold mb-1"><?= esc($iklan['nama_tipe_iklan_utama']) ?></h5>
                                    <div class="text-muted small mb-2">
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            <?= esc($iklan['id_tipe_iklan_utama']) ?>
                                        </span>
                                        | Durasi: <?= $iklan['rentang_bulan'] ?> bulan
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fs-5 fw-bold text-success">
                                            Rp<?= number_format($iklan['total_harga'], 0, ',', '.') ?>
                                        </span>
                                        <span class="badge bg-light text-dark">
                                            <?= $iklan['nama_tipe_iklan_utama'] ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">
                                        <i class="fas fa-calendar-alt me-2"></i>Periode Iklan
                                    </h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <div class="small text-muted">Mulai</div>
                                            <div class="fw-bold">
                                                <?php if ($iklan['status'] === 'diajukan'): ?>
                                                    <span class="text-warning">Menunggu ACC admin</span>
                                                <?php elseif (empty($iklan['tanggal_mulai'])): ?>
                                                    <span class="text-danger">Iklan ditolak</span>
                                                <?php else: ?>
                                                    <?= date('d F Y', strtotime($iklan['tanggal_mulai'])) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="small text-muted">Selesai</div>
                                            <div class="fw-bold">
                                                <?php if ($iklan['status'] === 'diajukan'): ?>
                                                    <span class="text-warning">Menunggu ACC admin</span>
                                                <?php elseif (empty($iklan['tanggal_selesai'])): ?>
                                                    <span class="text-danger">Iklan ditolak</span>
                                                <?php else: ?>
                                                    <?= date('d F Y', strtotime($iklan['tanggal_selesai'])) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($iklan['status'] === 'berjalan'): ?>
                                        <div class="progress mt-3" style="height: 8px;">
                                            <?php
                                            $startDate = new DateTime($iklan['tanggal_mulai']);
                                            $endDate = new DateTime($iklan['tanggal_selesai']);
                                            $today = new DateTime();
                                            $totalDays = $startDate->diff($endDate)->days;
                                            $daysPassed = $startDate->diff($today)->days;
                                            $percentage = min(100, max(0, ($daysPassed / $totalDays) * 100));
                                            ?>
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: <?= $percentage ?>%"
                                                aria-valuenow="<?= $percentage ?>"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                                data-bs-toggle="tooltip"
                                                title="Progress: <?= round($percentage) ?>% (<?= $daysPassed ?> dari <?= $totalDays ?> hari)">
                                            </div>
                                        </div>
                                        <div class="text-center small text-muted mt-1">
                                            <?= round($percentage) ?>% selesai
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Konten Iklan -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">
                            <i class="fas fa-image me-2"></i>Konten Iklan
                        </h5>

                        <div class="card border-0 bg-light mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <?php if (!empty($iklan['gambar'])): ?>
                                            <img src="<?= base_url('assets/images/iklan_utama/' . $iklan['thumbnail_iklan']) ?>"
                                                class="img-fluid rounded"
                                                alt="Gambar Iklan"
                                                style="max-height: 200px; object-fit: contain;">
                                        <?php else: ?>
                                            <div class="bg-white rounded d-flex align-items-center justify-content-center"
                                                style="height: 200px;">
                                                <i class="fas fa-image text-muted fs-3"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="mb-2"><?= esc($iklan['nama_tipe_iklan_utama']) ?></h5>

                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="<?= esc($iklan['link_iklan']) ?>"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-external-link-alt me-1"></i> Kunjungi Link
                                            </a>

                                            <?php if (!empty($iklan['gambar'])): ?>
                                                <a href="<?= base_url('uploads/iklan_utama/' . $iklan['gambar']) ?>"
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-expand me-1"></i> Lihat Full Gambar
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">
                            <i class="fas fa-user-tie me-2"></i>Informasi Pemohon
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?= esc($iklan['username']) ?></h6>
                                                <div class="text-muted small">
                                                    Marketing
                                                </div>
                                                <div class="text-muted small">
                                                    <?= date('d/m/Y H:i', strtotime($iklan['tanggal_pengajuan'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted mb-3">
                                            <i class="fas fa-phone-alt me-2"></i>Kontak Pengaju
                                        </h6>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-phone me-2 text-muted"></i>
                                            <div class="text-muted small">
                                                <?= !empty($iklan['no_pengaju']) ? esc($iklan['no_pengaju']) : 'Mohon isikan nomor pengaju terlebih dahulu' ?>
                                            </div>

                                        </div>
                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $iklan['no_pengaju']) ?>"
                                            target="_blank"
                                            class="btn btn-sm btn-success w-100">
                                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Admin -->
                    <?php if (!empty($iklan['catatan_admin'])): ?>
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 border-bottom pb-2">
                                <i class="fas fa-sticky-note me-2"></i>Catatan Admin
                            </h5>
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fas fa-info-circle text-primary mt-1"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <?= nl2br(esc($iklan['catatan_admin'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                        <div class="text-muted small">
                            Terakhir diupdate: <?= date('d/m/Y H:i', strtotime($iklan['diperbarui_pada'])) ?>
                        </div>

                        <div class="d-flex gap-3">
                            <?php if ($iklan['status'] == 'diajukan' && $role === 'admin'): ?>
                                <a href="<?= base_url('admin/iklanutama/terima/' . $iklan['id_iklan_utama']) ?>"
                                    class="btn btn-success px-4">
                                    <i class="fas fa-check me-2"></i> Terima
                                </a>
                                <a href="<?= base_url('admin/iklanutama/tolak/' . $iklan['id_iklan_utama']) ?>"
                                    class="btn btn-danger px-4">
                                    <i class="fas fa-times me-2"></i> Tolak
                                </a>
                            <?php elseif ($iklan['status'] == 'diterima' && $role === 'admin'): ?>
                                <a href="<?= base_url('admin/iklanutama/aktifkan/' . $iklan['id_iklan_utama']) ?>"
                                    class="btn btn-primary px-4">
                                    <i class="fas fa-play me-2"></i> Aktifkan
                                </a>
                            <?php elseif ($iklan['status'] == 'berjalan' && $role === 'admin'): ?>
                                <a href="<?= base_url('admin/iklanutama/nonaktifkan/' . $iklan['id_iklan_utama']) ?>"
                                    class="btn btn-warning px-4">
                                    <i class="fas fa-pause me-2"></i> Nonaktifkan
                                </a>
                            <?php endif; ?>

                            <a href="<?= base_url($role . '/iklanutama/edit/' . $iklan['id_iklan_utama']) ?>"
                                class="btn btn-outline-primary px-4">
                                <i class="fas fa-edit me-2"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Informasi -->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-settings shadow-sm p-4 h-100">
                    <div class="app-card-header mb-4">
                        <h4 class="app-card-title text-primary">
                            <i class="fas fa-chart-line me-2"></i>Statistik & Info
                        </h4>
                    </div>

                    <div class="app-card-body">
                        <!-- Timeline Status -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Timeline Status</h6>
                            <div class="timeline-steps">
                                <?php
                                $statuses = [
                                    'diajukan' => ['icon' => 'paper-plane', 'color' => 'warning', 'label' => 'Diajukan'],
                                    'diterima' => ['icon' => 'check-circle', 'color' => 'primary', 'label' => 'Diterima'],
                                    'ditolak' => ['icon' => 'times-circle', 'color' => 'danger', 'label' => 'Ditolak'],
                                    'berjalan' => ['icon' => 'play-circle', 'color' => 'success', 'label' => 'Berjalan'],
                                    'selesai' => ['icon' => 'stop-circle', 'color' => 'secondary', 'label' => 'Selesai']
                                ];

                                $currentStatus = $iklan['status'];
                                $statusKeys = array_keys($statuses);
                                $currentIndex = array_search($currentStatus, $statusKeys);

                                foreach ($statuses as $status => $data):
                                    $isActive = $currentStatus == $status;
                                    $isCompleted = array_search($status, $statusKeys) < $currentIndex;
                                    $isFuture = array_search($status, $statusKeys) > $currentIndex;
                                ?>
                                    <div class="timeline-step <?= $isActive ? 'active' : '' ?> <?= $isCompleted ? 'completed' : '' ?> <?= $isFuture ? 'future' : '' ?>">
                                        <div class="timeline-icon bg-<?= $data['color'] ?>">
                                            <i class="fas fa-<?= $data['icon'] ?>"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <span class="text-capitalize fw-semibold"><?= $data['label'] ?></span>
                                            <?php if ($isActive): ?>
                                                <small class="d-block text-muted">Status saat ini</small>
                                            <?php elseif ($isCompleted && isset($iklan['tanggal_status_' . $status])): ?>
                                                <small class="d-block text-muted">
                                                    <?= date('d M Y', strtotime($iklan['tanggal_status_' . $status])) ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Statistik -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Statistik</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body text-center py-3">
                                            <div class="text-primary fw-bold fs-4"><?= number_format($iklan['jumlah_klik'] ?? 0) ?></div>
                                            <div class="text-muted small">Total Klik</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body text-center py-3">
                                            <div class="text-primary fw-bold fs-4"><?= number_format($iklan['jumlah_tayang'] ?? 0) ?></div>
                                            <div class="text-muted small">Total Tayang</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pembayaran -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Informasi Pembayaran</h6>
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div class="small text-muted">Status</div>
                                        <div class="fw-bold text-capitalize">
                                            <?= $iklan['status_pembayaran'] ?? 'belum dibayar' ?>
                                        </div>
                                    </div>

                                    <?php if (!empty($iklan['tanggal_pembayaran'])): ?>
                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="small text-muted">Tanggal</div>
                                            <div class="fw-bold">
                                                <?= date('d M Y', strtotime($iklan['tanggal_pembayaran'])) ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($iklan['bukti_pembayaran'])): ?>
                                        <div class="mt-3">
                                            <a href="<?= base_url('uploads/pembayaran/' . $iklan['bukti_pembayaran']) ?>"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-primary w-100">
                                                <i class="fas fa-receipt me-1"></i> Lihat Bukti
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- QR Code -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">QR Code Iklan</h6>
                            <div class="card border-0 bg-light">
                                <div class="card-body text-center py-4">
                                    <div id="qrcode" class="mb-3"></div>
                                    <small class="text-muted">Scan untuk membuka link iklan</small>
                                    <div class="mt-2">
                                        <a href="<?= esc($iklan['link_iklan']) ?>"
                                            target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i> <?= parse_url($iklan['link_iklan'], PHP_URL_HOST) ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Generator -->
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script>
    // Generate QR Code
    document.addEventListener('DOMContentLoaded', function() {
        const qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "<?= esc($iklan['link_iklan']) ?>",
            width: 150,
            height: 150,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<style>
    /* Timeline Styles */
    .timeline-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .timeline-steps:before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 3px;
        background: #e9ecef;
        z-index: 1;
    }

    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        width: 20%;
    }

    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        margin-bottom: 8px;
        border: 3px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .timeline-content {
        text-align: center;
        font-size: 0.85rem;
    }

    .timeline-step.completed .timeline-icon {
        background-color: var(--bs-success) !important;
    }

    .timeline-step.completed:before {
        background-color: var(--bs-success) !important;
    }

    .timeline-step.future .timeline-icon {
        background-color: #e9ecef !important;
        color: #6c757d;
    }

    .timeline-step.future .timeline-content {
        color: #6c757d;
    }

    .timeline-step.active .timeline-icon {
        transform: scale(1.1);
        box-shadow: 0 0 0 3px rgba(var(--bs-primary-rgb), 0.3);
    }

    .timeline-step:not(:first-child):before {
        content: '';
        position: absolute;
        top: 20px;
        left: -50%;
        width: 100%;
        height: 3px;
        background: inherit;
    }

    .timeline-step.completed:not(:first-child):before {
        background-color: var(--bs-success);
    }

    /* Progress bar styling */
    .progress {
        border-radius: 10px;
        background-color: #f0f0f0;
    }

    .progress-bar {
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    /* Card styling */
    .card {
        border-radius: 10px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, rgb(100, 181, 201) 100%);
    }
</style>

<?= $this->endSection('content'); ?>