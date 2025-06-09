<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-ad me-2 text-white"></i> Permintaan Iklan Utama</h1>
                    <p class="mb-0 opacity-75">Kelola semua artikel iklan utama di sini</p>
                </div>
            </div>
        </div>

        <!-- Notifikasi -->
        <div class="col-12">
            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Modern Filter Section -->
        <div class="card border-0 mb-4">
            <div class="card-body p-4">
                <form method="get" action="<?= base_url('admin/artikel_iklan') ?>">
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
                            <button type="button" id="resetButton" class="btn btn-outline-secondary me-2 flex-grow-1">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                            <button type="button" id="filterButton" class="btn btn-info flex-grow-1 text-white">
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
                <?php if (empty($all_data_iklan_utama)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-ad fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada permintaan iklan</h5>
                        <p class="text-muted mb-3">Tidak ada permintaan tampil iklan yang perlu diproses</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="iklanTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Jenis</th>
                                    <th>Tipe Iklan</th>
                                    <th>Marketing</th>
                                    <th class="text-center">Durasi</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center">Tgl Pengajuan</th>
                                    <th class="text-center">Periode</th>
                                    <th class="text-center">Status</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($all_data_iklan_utama as $iklan) : ?>
                                    <tr class="table-row"
                                        data-start-date="<?= date('Y-m-d', strtotime($iklan['tanggal_mulai'] ?? '')) ?>"
                                        data-end-date="<?= date('Y-m-d', strtotime($iklan['tanggal_selesai'] ?? '')) ?>"
                                        data-status="<?= strtolower($iklan['status']) ?>">

                                        <td class="text-center text-muted"><?= $i++ ?></td>
                                        <td><?= esc($iklan['jenis'] ?? 'N/A') ?></td>
                                        <td><?= esc($iklan['nama'] ?? 'N/A') ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <span class="avatar-initials bg-light text-dark rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px; font-size: 10px;">
                                                        <?= strtoupper(substr($iklan['id_marketing'] ?? 'M', 0, 1)) ?>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <?= esc($iklan['full_name'] ?? 'N/A') ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center"><?= esc($iklan['rentang_bulan'] ?? 'N/A') ?> Bulan</td>
                                        <td class="text-end">Rp <?= number_format($iklan['total_harga'] ?? 0, 0, ',', '.') ?></td>
                                        <td class="text-center">
                                            <?= date('d M Y', strtotime($iklan['tanggal_pengajuan'] ?? '')) ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($iklan['tanggal_mulai'])) : ?>
                                                <small class="text-muted">
                                                    <?= date('d M Y', strtotime($iklan['tanggal_mulai'])) ?>
                                                    <br>s/d<br>
                                                    <?= date('d M Y', strtotime($iklan['tanggal_selesai'])) ?>
                                                </small>
                                            <?php else : ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <?php
                                        $today = date('Y-m-d');
                                        $tanggalMulai = $iklan['tanggal_mulai'] ?? null;
                                        $tanggalSelesai = $iklan['tanggal_selesai'] ?? null;
                                        $statusIklan = $iklan['status'] ?? null;

                                        if ($statusIklan == 'diajukan') {
                                            $status = 'Diajukan';
                                        } elseif ($statusIklan == 'ditolak') {
                                            $status = 'Ditolak';
                                        } elseif ($tanggalMulai && $tanggalSelesai) {
                                            if ($today < $tanggalMulai) {
                                                $status = 'Diterima';
                                            } elseif ($today >= $tanggalMulai && $today <= $tanggalSelesai) {
                                                $status = 'Berjalan';
                                            } elseif ($today > $tanggalSelesai) {
                                                $status = 'Selesai';
                                            }
                                        } else {
                                            $status = 'Belum diproses';
                                        }

                                        $badgeClass = [
                                            'Diajukan' => 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10',
                                            'Ditolak' => 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10',
                                            'Diterima' => 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10',
                                            'Berjalan' => 'bg-success bg-opacity-10 text-success border border-success border-opacity-10',
                                            'Selesai' => 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10',
                                            'Belum diproses' => 'bg-light text-dark'
                                        ][$status];
                                        ?>
                                        <td class="text-center">
                                            <span class="badge <?= $badgeClass ?>">
                                                <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i>
                                                <?= $status ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <?php if ($statusIklan == 'diajukan') : ?>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accModal<?= $iklan['id_iklan_utama'] ?>">
                                                        <i class="bi bi-check-circle me-1"></i> Acc
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal<?= $iklan['id_iklan_utama'] ?>">
                                                        <i class="bi bi-x-circle me-1"></i> Tolak
                                                    </button>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Acc -->
                                    <div class="modal fade" id="accModal<?= $iklan['id_iklan_utama'] ?>" tabindex="-1" aria-labelledby="accModalLabel<?= $iklan['id_iklan_utama'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="<?= base_url('admin/acciklanutama/ubahStatus') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <?php $durasiBulan = isset($iklan['rentang_bulan']) ? (int)$iklan['rentang_bulan'] : 0; ?>

                                                    <!-- Hidden inputs untuk data -->
                                                    <input type="hidden" name="id_iklan_utama" value="<?= $iklan['id_iklan_utama'] ?>">
                                                    <input type="hidden" name="id_marketing" value="<?= $iklan['id_marketing'] ?>">
                                                    <input type="hidden" name="total_harga" value="<?= $iklan['total_harga'] ?>">
                                                    <input type="hidden" name="status" value="diterima">
                                                    <input type="hidden" name="durasi_bulan" value="<?= $durasiBulan ?>">
                                                    <input type="hidden" name="id_tipe_iklan_utama" value="<?= $iklan['id_tipe_iklan_utama'] ?>">

                                                    <div class="modal-header modal-header-custom text-white">
                                                        <h5 class="modal-title" id="accModalLabel<?= $iklan['id_iklan_utama'] ?>">
                                                            <i class="fas fa-check-circle me-2"></i>Konfirmasi Persetujuan Iklan
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="alert alert-info border-0 mb-4">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            <strong>Perhatian:</strong> Anda akan menyetujui permintaan tampil iklan berikut ini.
                                                        </div>

                                                        <!-- Info Iklan -->
                                                        <div class="info-list mb-4">
                                                            <h6 class="text-primary mb-3"><i class="fas fa-clipboard-list me-2"></i>Detail Iklan</h6>
                                                            <ul class="list-unstyled mb-0">
                                                                <li><i class="fas fa-ad me-2 text-primary"></i>Nama Iklan: <strong><?= esc($iklan['nama']) ?></strong></li>
                                                                <li><i class="fas fa-calendar-alt me-2 text-warning"></i>Durasi: <strong><?= $durasiBulan ?> Bulan</strong></li>
                                                                <li><i class="fas fa-money-bill-wave me-2 text-danger"></i>Total Harga: <strong>Rp <?= number_format($iklan['total_harga'], 0, ',', '.') ?></strong></li>
                                                            </ul>
                                                        </div>

                                                        <div class="row mb-4">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="tanggalMulai_<?= $iklan['id_iklan_utama'] ?>" class="form-label">
                                                                        <i class="fas fa-play-circle me-2 text-success"></i>Tanggal Mulai
                                                                    </label>
                                                                    <input type="date" class="form-control commission-input"
                                                                        id="tanggalMulai_<?= $iklan['id_iklan_utama'] ?>"
                                                                        name="tanggal_mulai"
                                                                        min="<?= date('Y-m-d') ?>"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="tanggalSelesai_<?= $iklan['id_iklan_utama'] ?>" class="form-label">
                                                                        <i class="fas fa-stop-circle me-2 text-danger"></i>Tanggal Selesai
                                                                    </label>
                                                                    <input type="text" class="form-control commission-input"
                                                                        id="tanggalSelesai_<?= $iklan['id_iklan_utama'] ?>"
                                                                        name="tanggal_selesai_display"
                                                                        readonly>
                                                                    <input type="hidden" id="tanggalSelesaiValue_<?= $iklan['id_iklan_utama'] ?>" name="tanggal_selesai">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Section Komisi -->
                                                        <div class="commission-card">
                                                            <div class="commission-header text-white">
                                                                <h6 class="mb-0">
                                                                    <i class="fas fa-percentage me-2"></i>Pengaturan Komisi
                                                                </h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-check mb-3">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="useCustomCommission_<?= $iklan['id_iklan_utama'] ?>"
                                                                        name="use_custom_commission" value="1">
                                                                    <label class="form-check-label fw-bold" for="useCustomCommission_<?= $iklan['id_iklan_utama'] ?>">
                                                                        <i class="fas fa-cog me-2"></i>Gunakan Komisi Custom
                                                                    </label>
                                                                    <small class="d-block text-muted mt-1">Centang untuk mengatur komisi secara manual</small>
                                                                </div>

                                                                <div id="customCommissionSection_<?= $iklan['id_iklan_utama'] ?>" class="custom-commission-section" style="display: none;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <label for="komisiMarketing_<?= $iklan['id_iklan_utama'] ?>" class="form-label">
                                                                                    <i class="fas fa-bullhorn me-2 text-primary"></i>Marketing (%)
                                                                                </label>
                                                                                <input type="number" step="0.01" min="0" max="100"
                                                                                    class="form-control commission-input"
                                                                                    id="komisiMarketing_<?= $iklan['id_iklan_utama'] ?>"
                                                                                    name="komisi_marketing"
                                                                                    value="<?= $komisiMarketing ?? 0 ?>"
                                                                                    placeholder="<?= $komisiMarketing ?? 0 ?>">
                                                                                <small class="text-muted">Default: <?= $komisiMarketing ?? 0 ?>%</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <label for="komisiPenulis_<?= $iklan['id_iklan_utama'] ?>" class="form-label">
                                                                                    <i class="fas fa-pen me-2 text-success"></i>Penulis (%)
                                                                                </label>
                                                                                <input type="number" step="0.01" min="0" max="100"
                                                                                    class="form-control commission-input"
                                                                                    id="komisiPenulis_<?= $iklan['id_iklan_utama'] ?>"
                                                                                    name="komisi_penulis"
                                                                                    value="<?= $komisiPenulis ?? 0 ?>"
                                                                                    placeholder="<?= $komisiPenulis ?? 0 ?>" <?= ($komisiPenulis ?? 0) == 0 ? 'disabled' : '' ?>>
                                                                                <small class="text-muted">Default: <?= $komisiPenulis ?? 0 ?>%</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <label for="komisiAdmin_<?= $iklan['id_iklan_utama'] ?>" class="form-label">
                                                                                    <i class="fas fa-user-cog me-2 text-warning"></i>Admin (%)
                                                                                </label>
                                                                                <input type="number" step="0.01" min="0" max="100"
                                                                                    class="form-control commission-input"
                                                                                    id="komisiAdmin_<?= $iklan['id_iklan_utama'] ?>"
                                                                                    name="komisi_admin"
                                                                                    value="<?= $komisiAdmin ?? 0 ?>"
                                                                                    placeholder="<?= $komisiAdmin ?? 0 ?>">
                                                                                <small class="text-muted">Default: <?= $komisiAdmin ?? 0 ?>%</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="alert alert-custom">
                                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                                        <strong>Catatan:</strong> Total komisi sebaiknya tidak melebihi 100%. Sistem akan menghitung komisi berdasarkan persentase yang dimasukkan.
                                                                    </div>
                                                                </div>

                                                                <!-- Preview Komisi -->
                                                                <div class="mt-4">
                                                                    <h6 class="mb-3">
                                                                        <i class="fas fa-eye me-2 text-info"></i>Preview Pembagian Komisi
                                                                    </h6>
                                                                    <div class="preview-card">
                                                                        <div class="preview-item">
                                                                            <span class="preview-label">
                                                                                <i class="fas fa-bullhorn me-2"></i>Marketing
                                                                            </span>
                                                                            <span class="preview-amount">
                                                                                Rp <span id="previewMarketing_<?= $iklan['id_iklan_utama'] ?>"><?= number_format($iklan['total_harga'] * ($komisiMarketing ?? 0) / 100, 0, ',', '.') ?></span> (<span id="percentMarketing_<?= $iklan['id_iklan_utama'] ?>"><?= $komisiMarketing ?? 0 ?></span>%)
                                                                            </span>
                                                                        </div>
                                                                        <div class="preview-item">
                                                                            <span class="preview-label">
                                                                                <i class="fas fa-pen me-2"></i>Penulis
                                                                            </span>
                                                                            <span class="preview-amount">
                                                                                Rp <span id="previewPenulis_<?= $iklan['id_iklan_utama'] ?>"><?= number_format($iklan['total_harga'] * ($komisiPenulis ?? 0) / 100, 0, ',', '.') ?></span> (<span id="percentPenulis_<?= $iklan['id_iklan_utama'] ?>"><?= $komisiPenulis ?? 0 ?></span>%)
                                                                            </span>
                                                                        </div>
                                                                        <div class="preview-item">
                                                                            <span class="preview-label">
                                                                                <i class="fas fa-user-cog me-2"></i>Admin
                                                                            </span>
                                                                            <span class="preview-amount">
                                                                                Rp <span id="previewAdmin_<?= $iklan['id_iklan_utama'] ?>"><?= number_format($iklan['total_harga'] * ($komisiAdmin ?? 0) / 100, 0, ',', '.') ?></span> (<span id="percentAdmin_<?= $iklan['id_iklan_utama'] ?>"><?= $komisiAdmin ?? 0 ?></span>%)
                                                                            </span>
                                                                        </div>
                                                                        <hr class="my-2">
                                                                        <div class="preview-item">
                                                                            <span class="preview-label fw-bold">
                                                                                <i class="fas fa-calculator me-2"></i>Total Komisi
                                                                            </span>
                                                                            <span class="preview-amount text-primary">
                                                                                Rp <span id="totalCommission_<?= $iklan['id_iklan_utama'] ?>"><?= number_format($iklan['total_harga'], 0, ',', '.') ?></span> (<span id="totalPercent_<?= $iklan['id_iklan_utama'] ?>">100</span>%)
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="alert alert-light border mt-4">
                                                            <i class="fas fa-shield-alt me-2 text-success"></i>
                                                            <strong>Konfirmasi:</strong> Pastikan semua data sudah benar sebelum menyetujui permintaan iklan ini.
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-1"></i> Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-success-custom">
                                                            <i class="fas fa-check-circle me-2"></i> Setujui Permintaan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Tolak -->
                                    <div class="modal fade" id="tolakModal<?= $iklan['id_iklan_utama'] ?>" tabindex="-1" aria-labelledby="tolakModalLabel<?= $iklan['id_iklan_utama'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="<?= base_url('admin/acciklanutama/tolakiklan') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="id_iklan_utama" value="<?= $iklan['id_iklan_utama'] ?>">
                                                    <input type="hidden" name="status" value="ditolak">

                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="tolakModalLabel<?= $iklan['id_iklan_utama'] ?>">Konfirmasi Penolakan</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p>Anda akan menolak permintaan tampil iklan ini:</p>
                                                        <ul class="mb-3">
                                                            <li>Jenis: <strong><?= esc($iklan['jenis'] ?? 'N/A') ?></strong></li>
                                                            <li>Durasi: <strong><?= esc($iklan['rentang_bulan'] ?? 'N/A') ?> Bulan</strong></li>
                                                            <li>Harga: <strong>Rp <?= number_format($iklan['total_harga'] ?? 0, 0, ',', '.') ?></strong></li>
                                                        </ul>

                                                        <div class="mb-3">
                                                            <label for="alasan_penolakan<?= $iklan['id_iklan_utama'] ?>" class="form-label">Alasan Penolakan</label>
                                                            <textarea class="form-control" id="alasan_penolakan<?= $iklan['id_iklan_utama'] ?>" name="alasan_penolakan" rows="3" required placeholder="Masukkan alasan penolakan..."></textarea>
                                                            <div class="invalid-feedback">Harap isi alasan penolakan.</div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-x-circle me-1"></i> Tolak
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const tanggalMulaiInput = document.getElementById('tanggalMulai_<?= $iklan['id_iklan_utama'] ?>');
                                            const tanggalSelesaiInput = document.getElementById('tanggalSelesai_<?= $iklan['id_iklan_utama'] ?>');
                                            const durasiBulan = <?= $durasiBulan ?>;

                                            tanggalMulaiInput.addEventListener('change', function() {
                                                const tanggalMulai = new Date(tanggalMulaiInput.value);
                                                if (!isNaN(tanggalMulai.getTime())) {
                                                    // Menambahkan durasi bulan ke tanggal mulai
                                                    tanggalMulai.setMonth(tanggalMulai.getMonth() + durasiBulan);

                                                    // Mengatur tanggal selesai
                                                    const tanggalSelesai = tanggalMulai.toISOString().split('T')[0]; // Format YYYY-MM-DD
                                                    tanggalSelesaiInput.value = tanggalSelesai;
                                                }
                                            });
                                        });
                                    </script>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
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
        background: linear-gradient(135deg, #667eea 0%, rgb(100, 181, 201) 100%);
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

    /* enhance modal acc */
    .commission-card {
        border: 2px solid #e3f2fd;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .commission-card:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .commission-header {
        background: linear-gradient(135deg, #2196f3, #1976d2);
        border-radius: 10px 10px 0 0;
        padding: 1rem;
    }

    .custom-commission-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .commission-input {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .commission-input:focus {
        border-color: #2196f3;
        box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
    }

    .preview-card {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        border: 2px solid #ffb74d;
        border-radius: 8px;
        padding: 1rem;
    }

    .preview-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255, 183, 77, 0.3);
    }

    .preview-item:last-child {
        border-bottom: none;
    }

    .preview-label {
        font-weight: 600;
        color: #e65100;
    }

    .preview-amount {
        font-weight: 700;
        font-size: 1.1em;
        color: #bf360c;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #4caf50, #388e3c);
        border-radius: 0.375rem 0.375rem 0 0;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .btn-success-custom {
        background: linear-gradient(135deg, #4caf50, #388e3c);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success-custom:hover {
        background: linear-gradient(135deg, #388e3c, #2e7d32);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
    }

    .alert-custom {
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border-left: 4px solid #ffc107;
    }

    .info-list {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        border-left: 4px solid #17a2b8;
    }

    .info-list li {
        margin-bottom: 0.5rem;
        color: #495057;
    }

    .info-list strong {
        color: #212529;
    }

    /* Enhanced DataTables Styling dengan Spacing yang Lebih Baik */
    .dataTables_wrapper {
        padding: 1.5rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
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

    /* enhance modal acc */
    .commission-card {
        border: 2px solid #e3f2fd;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .commission-card:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .commission-header {
        background: linear-gradient(135deg, #2196f3, #1976d2);
        border-radius: 10px 10px 0 0;
        padding: 1rem;
    }

    .custom-commission-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .commission-input {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .commission-input:focus {
        border-color: #2196f3;
        box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
    }

    .preview-card {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        border: 2px solid #ffb74d;
        border-radius: 8px;
        padding: 1rem;
    }

    .preview-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255, 183, 77, 0.3);
    }

    .preview-item:last-child {
        border-bottom: none;
    }

    .preview-label {
        font-weight: 600;
        color: #e65100;
    }

    .preview-amount {
        font-weight: 700;
        font-size: 1.1em;
        color: #bf360c;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #4caf50, #388e3c);
        border-radius: 0.375rem 0.375rem 0 0;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .btn-success-custom {
        background: linear-gradient(135deg, #4caf50, #388e3c);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success-custom:hover {
        background: linear-gradient(135deg, #388e3c, #2e7d32);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
    }

    .alert-custom {
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border-left: 4px solid #ffc107;
    }

    .info-list {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        border-left: 4px solid #17a2b8;
    }

    .info-list li {
        margin-bottom: 0.5rem;
        color: #495057;
    }

    .info-list strong {
        color: #212529;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#iklanTable').DataTable({
            responsive: true,
            searching: true,
            ordering: true,
            paging: true,
            info: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                orderable: false,
                targets: [9] // Disable sorting for action column
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

        // Setup modal functionality for each modal when shown
        $('.modal').on('show.bs.modal', function() {
            const modalId = $(this).attr('id');
            if (modalId.startsWith('accModal')) {
                const iklanId = modalId.replace('accModal', '');
                const durasiBulan = parseInt($(`#accModal${iklanId} input[name="durasi_bulan"]`).val());
                const totalHarga = parseInt($(`#accModal${iklanId} input[name="total_harga"]`).val());

                setupModalFunctionality({
                    iklanId: iklanId,
                    durasiBulan: durasiBulan,
                    totalHarga: totalHarga
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const statusSelect = document.getElementById('status');
        const resetBtn = document.getElementById('resetButton');
        const rows = document.querySelectorAll('.table-row');

        function applyFilters() {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            const status = statusSelect.value.toLowerCase();

            rows.forEach(row => {
                const rowStart = row.dataset.startDate || '';
                const rowEnd = row.dataset.endDate || '';
                const rowStatus = row.dataset.status || '';

                let show = true;

                if (startDate && rowStart) {
                    show = show && (rowStart >= startDate);
                }

                if (endDate && rowEnd) {
                    show = show && (rowEnd <= endDate);
                }

                if (status) {
                    show = show && (rowStatus === status);
                }

                row.style.display = show ? '' : 'none';
            });
        }

        function resetFilters() {
            startDateInput.value = '';
            endDateInput.value = '';
            statusSelect.value = '';
            applyFilters();
        }

        startDateInput.addEventListener('change', applyFilters);
        endDateInput.addEventListener('change', applyFilters);
        statusSelect.addEventListener('change', applyFilters);

        resetBtn.addEventListener('click', resetFilters);
    });

    function setupModalFunctionality(config) {
        const {
            iklanId,
            durasiBulan,
            totalHarga
        } = config;

        // Get default values from the inputs
        const defaultMarketing = parseFloat(document.getElementById(`komisiMarketing_${iklanId}`).placeholder) || 0;
        const defaultPenulis = parseFloat(document.getElementById(`komisiPenulis_${iklanId}`).placeholder) || 0;
        const defaultAdmin = parseFloat(document.getElementById(`komisiAdmin_${iklanId}`).placeholder) || 0;

        // 1. Setup toggle komisi custom
        const commissionCheckbox = document.getElementById(`useCustomCommission_${iklanId}`);
        const commissionSection = document.getElementById(`customCommissionSection_${iklanId}`);

        if (commissionCheckbox && commissionSection) {
            commissionCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    commissionSection.style.display = 'block';
                    commissionSection.style.animation = 'fadeIn 0.3s ease-in-out';
                } else {
                    commissionSection.style.display = 'none';
                    // Reset ke nilai default
                    document.getElementById(`komisiMarketing_${iklanId}`).value = 0;
                    document.getElementById(`komisiPenulis_${iklanId}`).value = 0;
                    document.getElementById(`komisiAdmin_${iklanId}`).value = 0;
                    updateCommissionPreview();
                }
            });
        }

        // 2. Setup tanggal otomatis
        const startDateInput = document.getElementById(`tanggalMulai_${iklanId}`);
        const endDateInput = document.getElementById(`tanggalSelesai_${iklanId}`);
        const endDateValueInput = document.getElementById(`tanggalSelesaiValue_${iklanId}`);

        if (startDateInput && endDateInput && endDateValueInput) {
            // Set min date to today
            const today = new Date().toISOString().split('T')[0];
            startDateInput.min = today;
            startDateInput.value = today; // Set default ke hari ini

            // Hitung tanggal selesai default
            calculateEndDate();

            startDateInput.addEventListener('change', function() {
                calculateEndDate();
            });

            function calculateEndDate() {
                if (startDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    startDate.setMonth(startDate.getMonth() + durasiBulan);

                    // Format tanggal untuk tampilan yang lebih baik
                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    const endDateFormatted = startDate.toLocaleDateString('id-ID', options);
                    const endDateValue = startDate.toISOString().split('T')[0];

                    endDateInput.value = endDateFormatted;
                    endDateValueInput.value = endDateValue;
                }
            }
        }

        // 3. Setup perhitungan komisi
        const komisiInputs = [
            document.getElementById(`komisiMarketing_${iklanId}`),
            document.getElementById(`komisiPenulis_${iklanId}`),
            document.getElementById(`komisiAdmin_${iklanId}`)
        ];

        komisiInputs.forEach(input => {
            if (input) {
                input.addEventListener('input', updateCommissionPreview);
                input.addEventListener('blur', validateCommission);
            }
        });

        function updateCommissionPreview() {
            const marketing = parseFloat(komisiInputs[0]?.value) || defaultMarketing;
            const penulis = parseFloat(komisiInputs[1]?.value) || defaultPenulis;
            const admin = parseFloat(komisiInputs[2]?.value) || defaultAdmin;

            const marketingAmount = Math.round(totalHarga * marketing / 100);
            const penulisAmount = Math.round(totalHarga * penulis / 100);
            const adminAmount = Math.round(totalHarga * admin / 100);
            const totalCommission = marketingAmount + penulisAmount + adminAmount;
            const totalPercent = marketing + penulis + admin;

            // Update preview amounts
            updatePreviewElement(`previewMarketing_${iklanId}`, marketingAmount);
            updatePreviewElement(`previewPenulis_${iklanId}`, penulisAmount);
            updatePreviewElement(`previewAdmin_${iklanId}`, adminAmount);
            updatePreviewElement(`totalCommission_${iklanId}`, totalCommission);

            // Update percentages
            updateTextElement(`percentMarketing_${iklanId}`, marketing);
            updateTextElement(`percentPenulis_${iklanId}`, penulis);
            updateTextElement(`percentAdmin_${iklanId}`, admin);
            updateTextElement(`totalPercent_${iklanId}`, totalPercent.toFixed(1));

            // Highlight if total exceeds 100%
            const totalElement = document.getElementById(`totalPercent_${iklanId}`);
            if (totalElement) {
                if (totalPercent > 100) {
                    totalElement.style.color = '#dc3545';
                    totalElement.style.fontWeight = 'bold';
                } else {
                    totalElement.style.color = '#28a745';
                    totalElement.style.fontWeight = 'bold';
                }
            }
        }

        function updatePreviewElement(id, amount) {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = new Intl.NumberFormat('id-ID').format(amount);
            }
        }

        function updateTextElement(id, value) {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = value;
            }
        }

        function validateCommission() {
            const marketing = parseFloat(komisiInputs[0]?.value) || 0;
            const penulis = parseFloat(komisiInputs[1]?.value) || 0;
            const admin = parseFloat(komisiInputs[2]?.value) || 0;
            const total = marketing + penulis + admin;

            if (total > 100) {
                showAlert('Peringatan: Total komisi melebihi 100%!', 'warning');
            }
        }

        function showAlert(message, type = 'info') {
            // Create alert element
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Insert at top of modal body
            const modalBody = document.querySelector(`#accModal${iklanId} .modal-body`);
            if (modalBody) {
                modalBody.insertBefore(alertDiv, modalBody.firstChild);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
        }

        // Initialize preview
        updateCommissionPreview();
    }

    // CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
</script>
<?= $this->endSection('content'); ?>