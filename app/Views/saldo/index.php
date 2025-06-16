<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-wallet me-2 text-white"></i> Manajemen Saldo</h1>
                    <p class="mb-0 opacity-75">Pantau semua transaksi dan saldo Anda</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn btn-light btn-lg rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#withdrawalModal">
                        <i class="fas fa-plus me-2"></i> Tarik Saldo
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Penarikan Saldo -->
        <div class="modal fade" id="withdrawalModal" tabindex="-1" aria-labelledby="withdrawalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="withdrawalModalLabel"><i class="fas fa-money-bill-wave me-2"></i> Penarikan Saldo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url(session('role') . '/saldo/proses_penarikan') ?>" method="POST" id="withdrawalForm" class="m-4">
                        <div class="modal-body">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="status" value="diproses">
                            <input type="hidden" name="tanggal_pengajuan" value="<?= date('Y-m-d H:i:s') ?>">

                            <div class="balance-summary text-center mb-4 p-3 bg-light rounded">
                                <h6 class="text-muted mb-1">Saldo Tersedia</h6>
                                <h2 class="text-success mb-0">Rp <?= number_format(max(0, $total_pemasukan - $total_pengeluaran), 0, ',', '.') ?></h2>
                                <small class="text-muted">Pemasukan: Rp <?= number_format($total_pemasukan, 0, ',', '.') ?> | Pengeluaran: Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></small>
                            </div>

                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Penarikan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                        class="form-control"
                                        id="jumlah"
                                        name="jumlah"
                                        max="<?= max(0, $total_pemasukan - $total_pengeluaran) ?>"
                                        placeholder="Masukkan jumlah"
                                        required
                                        oninput="validateWithdrawal(this)">
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Maksimal: Rp <?= number_format(max(0, $total_pemasukan - $total_pengeluaran), 0, ',', '.') ?></small>
                                </div>
                                <div class="invalid-feedback" id="withdrawalError"></div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                <textarea class="form-control"
                                    id="keterangan"
                                    name="keterangan"
                                    rows="2"
                                    placeholder="Contoh: Penarikan untuk kebutuhan operasional"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill" id="submitWithdrawal">
                                <i class="fas fa-paper-plane me-1"></i> Ajukan Penarikan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Statistik Cards -->
        <div class="row g-4 mb-4">
            <!-- Pemasukan -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="stat-card bg-white rounded-4 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success-light text-success rounded-3 p-3 me-3">
                                <i class="fas fa-arrow-down fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Pemasukan</h6>
                                <h3 class="text-success mb-0">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></h3>
                                <small class="text-success">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?= count($pemasukan) ?> transaksi
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="stat-card bg-white rounded-4 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-danger-light text-danger rounded-3 p-3 me-3">
                                <i class="fas fa-arrow-up fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Pengeluaran</h6>
                                <h3 class="text-danger mb-0">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></h3>
                                <small class="text-danger">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?= count($pengeluaran_acc) ?> transaksi
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saldo -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="stat-card bg-white rounded-4 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary-light text-primary rounded-3 p-3 me-3">
                                <i class="fas fa-piggy-bank fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Saldo Saat Ini</h6>
                                <h3 class="text-primary mb-0">
                                    Rp <?= number_format(max(0, $saldo['saldo']), 0, ',', '.') ?>
                                </h3>
                                <small class="text-primary">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Saldo Tersedia
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4">
            <div class="card-header bg-white p-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0"><i class="fas fa-history text-primary me-2"></i> Riwayat Transaksi</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2">
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-filter"></i></span>
                                <select class="form-select border-0 bg-light" id="filter-type">
                                    <option value="all" selected>Semua Tipe</option>
                                    <option value="pemasukan">Pemasukan</option>
                                    <option value="pengeluaran">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-tag"></i></span>
                                <select class="form-select border-0 bg-light" id="filter-status">
                                    <option value="all" selected>Semua Status</option>
                                    <option value="diproses">Diproses</option>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <?php if (empty($semua_transaksi)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-exchange-alt fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada transaksi</h5>
                        <p class="text-muted mb-3">Mulai dengan melakukan penarikan saldo</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="transactionTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40">No</th>
                                    <th>Transaksi</th>
                                    <th class="text-end">Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($semua_transaksi as $i => $transaksi): ?>
                                    <tr>
                                        <td class="text-muted"><?= $i + 1 ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="transaction-icon <?= $transaksi['tipe'] === 'pemasukan' ? 'bg-success-light text-success' : 'bg-primary-light text-primary' ?> rounded-3 p-2 me-3">
                                                    <i class="fas <?= $transaksi['tipe'] === 'pemasukan' ? 'fa-arrow-down' : 'fa-arrow-up' ?>"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= esc(ucfirst($transaksi['tipe'])) ?></h6>
                                                    <small class="text-muted">ID: TRX<?= str_pad($i + 1, 4, '0', STR_PAD_LEFT) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <h6 class="mb-0 <?= $transaksi['tipe'] === 'pemasukan' ? 'text-success' : 'text-danger' ?>">
                                                <?= $transaksi['tipe'] === 'pemasukan' ? '+' : '-' ?> Rp <?= number_format($transaksi['jumlah'], 0, ',', '.') ?>
                                            </h6>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $transaksi['status'];
                                            $badgeClass = 'bg-secondary';
                                            $icon = 'fa-question-circle';

                                            if ($status === 'diproses') {
                                                $badgeClass = 'bg-warning';
                                                $icon = 'fa-clock';
                                            } elseif ($status === 'disetujui') {
                                                $badgeClass = 'bg-success';
                                                $icon = 'fa-check-circle';
                                            } elseif ($status === 'ditolak') {
                                                $badgeClass = 'bg-danger';
                                                $icon = 'fa-times-circle';
                                            }
                                            ?>
                                            <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1">
                                                <i class="fas <?= $icon ?> me-1"></i>
                                                <?= esc(ucfirst($transaksi['status'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?= date('d M Y', strtotime($transaksi['tanggal'])) ?></small><br>
                                            <small><?= date('H:i', strtotime($transaksi['tanggal'])) ?></small>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#detailModal<?= $i ?>">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modals -->
<?php foreach ($semua_transaksi as $i => $transaksi):
    $isPemasukan = $transaksi['tipe'] === 'pemasukan';
    $colorClass = $isPemasukan ? 'success' : 'primary';
    $iconClass = $isPemasukan ? 'fa-arrow-down' : 'fa-arrow-up';
    $isPenarikanDisetujui = $transaksi['tipe'] === 'penarikan' &&
        $transaksi['status'] === 'disetujui' &&
        !empty($transaksi['bukti_transfer']);
?>
    <div class="modal fade" id="detailModal<?= $i ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $i ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <!-- Modal Header with Gradient Background -->
                <div class="modal-header bg-gradient-<?= $colorClass ?> text-white rounded-top-4">
                    <div class="d-flex align-items-center w-100">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas <?= $iconClass ?> text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-1" id="detailModalLabel<?= $i ?>">
                            </h5>
                            <div class="d-flex flex-wrap align-items-center">
                                <span class="badge bg-white text-<?= $colorClass ?> rounded-pill me-2 mb-1">
                                    <i class="fas <?= $iconClass ?> me-1"></i>
                                    <?= esc(ucfirst($transaksi['tipe'])) ?>
                                </span>
                                <span class="badge bg-white text-<?=
                                                                    $transaksi['status'] === 'disetujui' ? 'success' : ($transaksi['status'] === 'ditolak' ? 'danger' : 'warning')
                                                                    ?> rounded-pill me-2 mb-1">
                                    <i class="fas <?=
                                                    $transaksi['status'] === 'disetujui' ? 'fa-check-circle' : ($transaksi['status'] === 'ditolak' ? 'fa-times-circle' : 'fa-clock')
                                                    ?> me-1"></i>
                                    <?= esc(ucfirst($transaksi['status'])) ?>
                                </span>
                                <span class="text-white opacity-75 small mb-1">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?= date('d M Y, H:i', strtotime($transaksi['tanggal'])) ?>
                                </span>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white opacity-100" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-0">
                    <!-- Amount Summary Card -->
                    <div class="card border-0 shadow-none rounded-0">
                        <div class="card-body py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Transaksi</h6>
                                    <h2 class="text-<?= $colorClass ?> mb-0 fw-bold">
                                        <?= $isPemasukan ? '+' : '-' ?> Rp<?= number_format($transaksi['jumlah'], 0, ',', '.') ?>
                                    </h2>
                                </div>
                                <div class="text-end">
                                    <h6 class="text-muted mb-2">Saldo <?= $isPemasukan ? 'Bertambah' : 'Berkurang' ?></h6>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <i class="fas <?= $iconClass ?> fa-2x text-<?= $colorClass ?> me-2"></i>
                                        <span class="h4 mb-0 fw-bold"><?= $isPemasukan ? 'Pemasukan' : 'Penarikan' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="p-4">
                        <div class="row">
                            <!-- Left Column - Transaction Details -->
                            <div class="col-lg-<?= $isPenarikanDisetujui ? '6' : '12' ?>">
                                <!-- Transaction Details Card -->
                                <div class="card mb-4 border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 fw-semibold">
                                            <i class="fas fa-receipt text-<?= $colorClass ?> me-2"></i>
                                            Rincian Transaksi
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Transaction Type -->
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0 text-muted mt-1">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <small class="text-muted d-block">Jenis Transaksi</small>
                                                        <p class="mb-0 fw-medium">
                                                            <span class="badge bg-<?= $colorClass ?>-subtle text-<?= $colorClass ?>">
                                                                <?= esc(ucfirst($transaksi['tipe'])) ?>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Transaction Status -->
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0 text-muted mt-1">
                                                        <i class="fas fa-info-circle"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <small class="text-muted d-block">Status</small>
                                                        <p class="mb-0 fw-medium">
                                                            <span class="badge bg-<?=
                                                                                    $transaksi['status'] === 'disetujui' ? 'success' : ($transaksi['status'] === 'ditolak' ? 'danger' : 'warning')
                                                                                    ?>-subtle text-<?=
                                                                                                    $transaksi['status'] === 'disetujui' ? 'success' : ($transaksi['status'] === 'ditolak' ? 'danger' : 'warning')
                                                                                                    ?>">
                                                                <?= esc(ucfirst($transaksi['status'])) ?>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Transaction Date -->
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0 text-muted mt-1">
                                                        <i class="far fa-calendar"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <small class="text-muted d-block">Tanggal Transaksi</small>
                                                        <p class="mb-0 fw-medium"><?= date('d F Y', strtotime($transaksi['tanggal'])) ?></p>
                                                        <small class="text-muted"><?= date('H:i:s', strtotime($transaksi['tanggal'])) ?></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Approval Date (if approved) -->
                                            <?php if ($transaksi['status'] === 'disetujui' && !empty($transaksi['tanggal_persetujuan'])): ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0 text-muted mt-1">
                                                            <i class="fas fa-check-double"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <small class="text-muted d-block">Disetujui Pada</small>
                                                            <p class="mb-0 fw-medium"><?= date('d F Y H:i', strtotime($transaksi['tanggal_persetujuan'])) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- User Information -->
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0 text-muted mt-1">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <small class="text-muted d-block">Pemilik Transaksi</small>
                                                        <p class="mb-0 fw-medium"><?= esc($transaksi['username']) ?></p>
                                                        <small class="text-muted">ID: <?= $transaksi['user_id'] ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Admin Notes -->
                                <?php if (!empty($transaksi['catatan'])): ?>
                                    <div class="card mb-4 border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 fw-semibold">
                                                <i class="fas fa-clipboard-check text-<?= $colorClass ?> me-2"></i>
                                                Catatan Admin
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-light border">
                                                <p class="mb-0"><?= esc($transaksi['catatan']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Right Column - Withdrawal Proof (if applicable) -->
                            <?php if ($isPenarikanDisetujui): ?>
                                <div class="col-lg-6">
                                    <div class="card border h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 fw-semibold">
                                                <i class="fas fa-file-invoice-dollar text-<?= $colorClass ?> me-2"></i>
                                                Bukti Transfer
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="text-center mb-3">
                                                <?php if (file_exists(FCPATH . 'uploads/bukti_transfer/' . $transaksi['bukti_transfer'])): ?>
                                                    <!-- Thumbnail with preview trigger -->
                                                    <img src="<?= base_url('uploads/bukti_transfer/' . $transaksi['bukti_transfer']) ?>"
                                                        class="img-fluid rounded border shadow-sm cursor-pointer hover-zoom mb-2"
                                                        alt="Bukti Transfer"
                                                        style="max-height: 250px;"
                                                        onclick="showImagePreview('<?= base_url('uploads/bukti_transfer/' . $transaksi['bukti_transfer']) ?>', '<?= $transaksi['bukti_transfer'] ?>')">

                                                    <!-- Download Button -->
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button class="btn btn-sm btn-outline-primary"
                                                            onclick="downloadImage('<?= base_url('uploads/bukti_transfer/' . $transaksi['bukti_transfer']) ?>', '<?= $transaksi['bukti_transfer'] ?>')">
                                                            <i class="fas fa-download me-1"></i> Unduh
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-secondary"
                                                            onclick="showImagePreview('<?= base_url('uploads/bukti_transfer/' . $transaksi['bukti_transfer']) ?>', '<?= $transaksi['bukti_transfer'] ?>')">
                                                            <i class="fas fa-expand me-1"></i> Preview
                                                        </button>
                                                    </div>

                                                    <!-- Preview Modal (Taruh di bagian bawah file sebelum penutup section) -->
                                                    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                                            <div class="modal-content bg-transparent border-0">
                                                                <div class="modal-header bg-dark bg-opacity-75 text-white">
                                                                    <h6 class="modal-title" id="previewImageTitle">Preview Bukti Transfer</h6>
                                                                    <div>
                                                                        <button class="btn btn-sm btn-outline-light me-2" id="downloadPreviewBtn">
                                                                            <i class="fas fa-download me-1"></i> Unduh
                                                                        </button>
                                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-body p-0 text-center">
                                                                    <img id="previewImage" src="" class="img-fluid" style="max-height: 80vh;">
                                                                </div>
                                                                <div class="modal-footer bg-dark bg-opacity-75 justify-content-between">
                                                                    <small class="text-white-50" id="previewImageName"></small>
                                                                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">
                                                                        <i class="fas fa-times me-1"></i> Tutup
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center" style="height: 200px;">
                                                        <div class="text-center p-3">
                                                            <i class="fas fa-file-image fa-3x text-muted mb-2"></i>
                                                            <p class="mb-0 small text-muted">File bukti tidak ditemukan</p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-center">
                                                <small class="text-muted">Nama File: <?= $transaksi['bukti_transfer'] ?></small>
                                                <?php if (!empty($transaksi['tanggal_persetujuan'])): ?>
                                                    <div class="mt-2">
                                                        <small class="text-muted">Diverifikasi pada:</small>
                                                        <p class="mb-0 small"><?= date('d F Y H:i', strtotime($transaksi['tanggal_persetujuan'])) ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Commission Details (for income transactions) -->
                        <?php if ($isPemasukan && isset($transaksi['id_iklan'])): ?>
                            <div class="card border mt-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-semibold">
                                        <i class="fas fa-percent text-<?= $colorClass ?> me-2"></i>
                                        Detail Komisi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0 text-muted mt-1">
                                                    <i class="fas fa-ad"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <small class="text-muted d-block">Sumber Komisi</small>
                                                    <p class="mb-1 fw-medium">Iklan #<?= $transaksi['id_iklan'] ?></p>

                                                    <?php if (isset($iklan_info[$transaksi['id_iklan']])): ?>
                                                        <?php
                                                        $iklan = $iklan_info[$transaksi['id_iklan']];
                                                        $detail = $iklan['detail_konten'] ?? null;
                                                        $tipe = $iklan['tipe_content'] ?? null;
                                                        ?>
                                                        <span class="badge bg-info bg-opacity-10 text-info small mt-1">
                                                            <?= esc($tipe) ?>
                                                        </span>

                                                        <?php if (!empty($detail)): ?>
                                                            <div class="mt-2">
                                                                <small class="text-muted d-block">
                                                                    <?= $tipe === 'artikel' ? 'Judul Artikel' : ($tipe === 'tempatwisata' ? 'Nama Wisata' : ($tipe === 'oleholeh' ? 'Nama Produk' : 'Detail')) ?>
                                                                </small>
                                                                <p class="mb-0 fw-medium small">
                                                                    <?php
                                                                    switch ($tipe) {
                                                                        case 'artikel':
                                                                            $judul = $detail['judul_artikel'] ?? '-';
                                                                            break;
                                                                        case 'tempatwisata':
                                                                            $judul = $detail['nama_wisata_ind'] ?? '-';
                                                                            break;
                                                                        case 'oleholeh':
                                                                            $judul = $detail['nama_oleholeh'] ?? '-';
                                                                            break;
                                                                        default:
                                                                            $judul = '-';
                                                                    }
                                                                    ?>

                                                                    <?= esc($judul) ?>

                                                                </p>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-shrink-0 text-muted mt-1">
                                                    <i class="fas fa-hand-holding-usd"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <small class="text-muted d-block">Nilai Komisi</small>
                                                    <p class="mb-0 fw-medium">Rp<?= number_format($transaksi['jumlah'], 0, ',', '.') ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Tutup
                    </button>
                    <?php if ($transaksi['tipe'] === 'penarikan' && $transaksi['status'] === 'pending'): ?>
                        <button type="button" class="btn btn-<?= $colorClass ?>">
                            <i class="fas fa-edit me-1"></i> Edit Permintaan
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<style>
    /* Gradient Backgrounds */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    /* Card Styling */
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.5rem;
    }

    .modal-body {
        padding: 0;
    }

    /* Badge Styling */
    .badge {
        padding: 5px 10px;
        font-weight: 500;
    }

    /* Transaction Amount */
    .transaction-amount {
        font-size: 2rem;
        font-weight: 700;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .modal-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .modal-title {
            font-size: 1.25rem;
        }
    }

    /* Hover Effects */
    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.02);
    }

    /* Custom Border Radius */
    .rounded-4 {
        border-radius: 15px !important;
    }

    .rounded-top-4 {
        border-top-left-radius: 15px !important;
        border-top-right-radius: 15px !important;
    }

    .rounded-bottom-4 {
        border-bottom-left-radius: 15px !important;
        border-bottom-right-radius: 15px !important;
    }


    /* Gradient Header */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Stat Cards */
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1) !important;
    }

    .bg-danger-light {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }

    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    /* Transaction Table */
    .transaction-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Empty State */
    .empty-state {
        opacity: 0.6;
    }

    /* Detail Items in Modal */
    .detail-item {
        margin-bottom: 1rem;
    }

    .detail-label {
        color: #6c757d;
        font-weight: 500;
        display: block;
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-weight: 500;
    }

    /* Rounded Elements */
    .rounded-4 {
        border-radius: 1rem !important;
    }

    /* Balance Summary */
    .balance-summary {
        border-left: 4px solid #0d6efd;
    }

    /* Enhanced Table Styling */
    .table {
        font-size: 14px;
        margin-bottom: 0;
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

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    /* Enhanced DataTables Styling */
    .dataTables_wrapper {
        padding: 1.5rem;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 6px;
        margin: 0 2px;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            text-align: center;
        }

        .dashboard-header .text-md-end {
            text-align: center !important;
            margin-top: 1rem;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .hover-zoom {
        transition: transform 0.3s ease;
    }

    .hover-zoom:hover {
        transform: scale(1.03);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

   /* Image Preview Modal Styles */
#imagePreviewModal .modal-dialog {
    max-width: 95%;
    margin: auto;
}

#imagePreviewModal .modal-content {
    background: rgba(0, 0, 0, 0.95);
    border: none;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
    overflow: hidden;
}

#imagePreviewModal .modal-header,
#imagePreviewModal .modal-footer {
    background-color: transparent;
    border: none;
    padding: 1rem 1.5rem;
    justify-content: space-between;
    align-items: center;
}

#imagePreviewModal .modal-title {
    font-size: 1rem;
    font-weight: 500;
    color: #fff;
}

#imagePreviewModal .btn-close {
    filter: invert(1);
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

#imagePreviewModal .btn-close:hover {
    opacity: 1;
}

#imagePreviewModal .modal-body {
    background-color: #000;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0;
}

#previewImage {
    max-height: 85vh;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

#previewImage:hover {
    transform: scale(1.01);
}

#previewImageName {
    font-size: 0.8rem;
    color: #ccc;
}

/* Responsive */
@media (max-width: 768px) {
    #imagePreviewModal .modal-dialog {
        max-width: 100%;
        margin: 1rem;
    }

    #previewImage {
        max-height: 70vh;
    }

    #imagePreviewModal .modal-title {
        font-size: 0.9rem;
    }
}

</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#transactionTable').DataTable({
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
                targets: [5] // Disable sorting for action column
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

        // Filter functionality
        $('#filter-type, #filter-status').change(function() {
            const table = $('#transactionTable').DataTable();
            const type = $('#filter-type').val();
            const status = $('#filter-status').val();

            if (type === 'all' && status === 'all') {
                table.search('').columns().search('').draw();
            } else {
                // Combine both filters
                table.columns(1).search(type === 'all' ? '' : type)
                    .columns(3).search(status === 'all' ? '' : status)
                    .draw();
            }
        });

        // Withdrawal validation function
        function validateWithdrawal(input) {
            const amount = parseFloat(input.value);
            const balance = parseFloat(<?= max(0, $total_pemasukan - $total_pengeluaran) ?>);
            const errorElement = document.getElementById('withdrawalError');
            const submitBtn = document.getElementById('submitWithdrawal');

            // Clear previous errors
            input.classList.remove('is-invalid');
            errorElement.textContent = '';

            if (isNaN(amount)) {
                return;
            }

            if (amount > balance) {
                input.classList.add('is-invalid');
                errorElement.textContent = 'Jumlah penarikan melebihi saldo tersedia!';
                submitBtn.disabled = true;
                return;
            }

            submitBtn.disabled = false;
        }

        // Form submission handler
        $('#withdrawalForm').submit(function(e) {
            const amount = parseFloat($('#jumlah').val());
            const balance = parseFloat(<?= max(0, $total_pemasukan - $total_pengeluaran) ?>);

            if (amount > balance) {
                e.preventDefault();
                $('#jumlah').addClass('is-invalid');
                $('#withdrawalError').text('Jumlah penarikan melebihi saldo tersedia!');
                return;
            }
        });

        // Format currency input
        $('#jumlah').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Fungsi untuk menampilkan preview gambar
        function showImagePreview(imageSrc, fileName) {
            const previewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            const previewImage = document.getElementById('previewImage');
            const previewImageTitle = document.getElementById('previewImageTitle');
            const previewImageName = document.getElementById('previewImageName');

            previewImage.src = imageSrc;
            previewImageTitle.textContent = 'Preview: ' + fileName;
            previewImageName.textContent = fileName;
            previewModal.show();
        }

        // Download image
        function downloadImage(imageSrc, fileName) {
            // Buat elemen anchor sementara
            const link = document.createElement('a');
            link.href = imageSrc;
            link.download = fileName || 'bukti-transfer-' + new Date().getTime();

            // Tambahkan ke dokumen dan klik
            document.body.appendChild(link);
            link.click();

            // Bersihkan
            document.body.removeChild(link);

            // Tutup modal jika terbuka
            const previewModal = bootstrap.Modal.getInstance(document.getElementById('imagePreviewModal'));
            if (previewModal) {
                previewModal.hide();
            }
        }

        // Event delegation untuk tombol preview dan download
        $(document).on('click', '[onclick^="showImagePreview"]', function() {
            const onclickContent = $(this).attr('onclick');
            const matches = onclickContent.match(/showImagePreview\('([^']+)',\s*'([^']+)'/);
            if (matches && matches.length === 3) {
                showImagePreview(matches[1], matches[2]);
            }
        });

        $(document).on('click', '[onclick^="downloadImage"]', function() {
            const onclickContent = $(this).attr('onclick');
            const matches = onclickContent.match(/downloadImage\('([^']+)',\s*'([^']+)'/);
            if (matches && matches.length === 3) {
                downloadImage(matches[1], matches[2]);
            }
        });

        // Handler untuk tombol download di modal preview
        $('#downloadPreviewBtn').click(function() {
            const imageSrc = $('#previewImage').attr('src');
            const fileName = $('#previewImageName').text();
            downloadImage(imageSrc, fileName);
        });
    });
</script>

<?= $this->endSection('content'); ?>