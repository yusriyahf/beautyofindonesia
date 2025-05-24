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
                    <form action="<?= base_url('admin/saldo/proses_penarikan') ?>" method="POST" id="withdrawalForm">
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
                                    <?= count($pengeluaran) ?> transaksi
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
                <?php if(empty($semua_transaksi)): ?>
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
                                        <td class="text-muted"><?= $i+1 ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="transaction-icon <?= $transaksi['tipe'] === 'pemasukan' ? 'bg-success-light text-success' : 'bg-primary-light text-primary' ?> rounded-3 p-2 me-3">
                                                    <i class="fas <?= $transaksi['tipe'] === 'pemasukan' ? 'fa-arrow-down' : 'fa-arrow-up' ?>"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= esc(ucfirst($transaksi['tipe'])) ?></h6>
                                                    <small class="text-muted">ID: TRX<?= str_pad($i+1, 4, '0', STR_PAD_LEFT) ?></small>
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
<?php foreach ($semua_transaksi as $i => $transaksi): ?>
<div class="modal fade" id="detailModal<?= $i ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $i ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header <?= $transaksi['tipe'] === 'pemasukan' ? 'bg-success text-white' : 'bg-primary text-white' ?>">
                <h5 class="modal-title" id="detailModalLabel<?= $i ?>">
                    <i class="fas <?= $transaksi['tipe'] === 'pemasukan' ? 'fa-arrow-down' : 'fa-arrow-up' ?> me-2"></i>
                    Detail Transaksi #TRX<?= str_pad($i+1, 4, '0', STR_PAD_LEFT) ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="transaction-detail">
                    <div class="detail-item bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 <?= $transaksi['tipe'] === 'pemasukan' ? 'text-success' : 'text-danger' ?>">
                                    <?= $transaksi['tipe'] === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' ?>
                                </h6>
                                <small class="text-muted"><?= date('l, d F Y H:i', strtotime($transaksi['tanggal'])) ?></small>
                            </div>
                            <h4 class="<?= $transaksi['tipe'] === 'pemasukan' ? 'text-success' : 'text-danger' ?> mb-0">
                                <?= $transaksi['tipe'] === 'pemasukan' ? '+' : '-' ?> Rp <?= number_format($transaksi['jumlah'], 0, ',', '.') ?>
                            </h4>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Tipe Transaksi</span>
                                <span class="detail-value">
                                    <span class="badge <?= $transaksi['tipe'] === 'pemasukan' ? 'bg-success' : 'bg-primary' ?> rounded-pill px-3">
                                        <?= esc(ucfirst($transaksi['tipe'])) ?>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    <span class="badge <?= $badgeClass ?> rounded-pill px-3">
                                        <i class="fas <?= $icon ?> me-1"></i>
                                        <?= esc(ucfirst($transaksi['status'])) ?>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Tanggal/Waktu</span>
                        <span class="detail-value">
                            <?= date('l, d F Y', strtotime($transaksi['tanggal'])) ?>
                            <br>
                            <?= date('H:i:s', strtotime($transaksi['tanggal'])) ?>
                        </span>
                    </div>
                    
                    <?php if(!empty($transaksi['keterangan'])): ?>
                    <div class="detail-item">
                        <div class="alert alert-light">
                            <h6 class="alert-heading">Keterangan</h6>
                            <p class="mb-0"><?= esc($transaksi['keterangan']) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                <?php if($transaksi['tipe'] === 'pengeluaran' && $transaksi['status'] === 'diproses'): ?>
                <button type="button" class="btn btn-danger rounded-pill">
                    <i class="fas fa-times me-1"></i> Batalkan
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<style>
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
});
</script>

<?= $this->endSection('content'); ?>