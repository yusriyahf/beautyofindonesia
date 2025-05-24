<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-wallet me-2 text-white"></i> Permintaan Penarikan Saldo</h1>
                    <p class="mb-0 opacity-75">Kelola permintaan penarikan saldo dari mitra</p>
                </div>
                <!-- <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <select class="form-select form-select-sm shadow-sm border-0 bg-white bg-opacity-20 text-white" id="filter-status">
                        <option value="all" selected>Semua Status</option>
                        <option value="diproses">Diproses</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div> -->
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Penarikan -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="stat-card bg-white rounded-4 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary-light text-primary rounded-3 p-3 me-3">
                                <i class="fas fa-money-bill-wave fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Penarikan</h6>
                                <?php
                                $total_penarikan = 0;
                                foreach ($all_data_penarikan_saldo as $saldo) {
                                    $total_penarikan += $saldo['jumlah'];
                                }
                                ?>
                                <h3 class="text-primary mb-0">Rp <?= number_format($total_penarikan, 0, ',', '.') ?></h3>
                                <small class="text-primary">
                                    <i class="fas fa-exchange-alt me-1"></i>
                                    Total seluruh penarikan
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dalam Proses -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="stat-card bg-white rounded-4 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-warning-light text-warning rounded-3 p-3 me-3">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Dalam Proses</h6>
                                <h3 class="text-warning mb-0">
                                    <?= count(array_filter($all_data_penarikan_saldo, function ($item) {
                                        return $item['status'] === 'diproses';
                                    })) ?>
                                </h3>
                                <small class="text-warning">
                                    <i class="fas fa-hourglass-half me-1"></i>
                                    Menunggu persetujuan
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Disetujui -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="stat-card bg-white rounded-4 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success-light text-success rounded-3 p-3 me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Disetujui</h6>
                                <h3 class="text-success mb-0">
                                    <?= count(array_filter($all_data_penarikan_saldo, function ($item) {
                                        return $item['status'] === 'disetujui';
                                    })) ?>
                                </h3>
                                <small class="text-success">
                                    <i class="fas fa-check-double me-1"></i>
                                    Penarikan berhasil
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Permintaan Penarikan -->
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4">
            <div class="card-body p-0">
                <?php if (empty($all_data_penarikan_saldo)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-exchange-alt fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada permintaan penarikan</h5>
                        <p class="text-muted mb-3">Tidak ada permintaan penarikan yang perlu diproses</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="withdrawalTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40">No</th>
                                    <th>Pengguna</th>
                                    <th>Role</th>
                                    <th class="text-end">Jumlah</th>
                                    <th>Status</th>
                                    <th width="120">Tanggal</th>
                                    <th width="150" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_data_penarikan_saldo as $i => $saldo): ?>
                                    <tr>
                                        <td class="text-muted"><?= $i + 1 ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <span class="avatar-title bg-primary-light text-primary rounded-circle fw-bold">
                                                        <?= substr(esc($saldo['username']), 0, 1) ?>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= esc($saldo['username']) ?></h6>
                                                    <small class="text-muted">ID: <?= $saldo['id_penarikan_komisi'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info-light text-info rounded-pill px-3 py-1">
                                                <?= esc($saldo['role']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <h6 class="mb-0 text-danger">
                                                - Rp <?= number_format($saldo['jumlah'], 0, ',', '.') ?>
                                            </h6>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $saldo['status'];
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
                                                <?= esc(ucfirst($saldo['status'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <small class="text-muted"><?= date('d M Y', strtotime($saldo['tanggal_pengajuan'])) ?></small>
                                                <small><?= date('H:i', strtotime($saldo['tanggal_pengajuan'])) ?></small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($status == 'diproses') : ?>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <!-- Approve Button -->
                                                    <button type="button"
                                                        class="btn btn-success btn-sm rounded-pill px-3 d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#accModal<?= $saldo['id_penarikan_komisi'] ?>"
                                                        title="Setujui Penarikan">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        <span>Approve</span>
                                                    </button>

                                                    <!-- Reject Button -->
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm rounded-pill px-3 d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#tolakModal<?= $saldo['id_penarikan_komisi'] ?>"
                                                        title="Tolak Penarikan">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        <span>Reject</span>
                                                    </button>
                                                </div>
                                            <?php else : ?>
                                                <span class="badge bg-light text-muted border py-2 px-3 rounded-pill">
                                                    <i class="fas fa-check-double me-1"></i> Selesai
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Modals -->
        <?php foreach ($all_data_penarikan_saldo as $saldo) : ?>
            <!-- Modal Approve -->
            <div class="modal fade" id="accModal<?= $saldo['id_penarikan_komisi'] ?>" tabindex="-1" aria-labelledby="accModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="accModalLabel">
                                <i class="fas fa-check-circle me-2"></i> Konfirmasi Approve Penarikan
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('admin/saldo/ubahstatus') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id_penarikan_komisi" value="<?= $saldo['id_penarikan_komisi'] ?>">
                            <div class="modal-body">
                                <div class="mb-4 text-center">
                                    <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                                    <h5 class="mt-3">Approve Penarikan Saldo?</h5>
                                    <p class="text-muted">Anda akan menyetujui penarikan saldo sebesar <strong>Rp <?= number_format($saldo['jumlah'], 0, ',', '.') ?></strong> oleh <?= esc($saldo['username']) ?></p>
                                </div>

                                <div class="mb-3">
                                    <label for="buktiTransfer<?= $saldo['id_penarikan_komisi'] ?>" class="form-label">Upload Bukti Transfer</label>
                                    <input class="form-control" type="file" id="buktiTransfer<?= $saldo['id_penarikan_komisi'] ?>" name="bukti_transfer" required>
                                    <small class="text-muted">Format: JPG/PNG (max 2MB)</small>
                                </div>

                                <div class="mb-3">
                                    <label for="catatan<?= $saldo['id_penarikan_komisi'] ?>" class="form-label">Catatan (Opsional)</label>
                                    <textarea class="form-control" id="catatan<?= $saldo['id_penarikan_komisi'] ?>" name="catatan" rows="2" placeholder="Tambahkan catatan jika perlu"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Konfirmasi Approve
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Reject -->
            <div class="modal fade" id="tolakModal<?= $saldo['id_penarikan_komisi'] ?>" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="tolakModalLabel">
                                <i class="fas fa-times-circle me-2"></i> Konfirmasi Tolak Penarikan
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('admin/penarikan/reject/' . $saldo['id_penarikan_komisi']) ?>" method="POST">
                            <div class="modal-body">
                                <div class="mb-4 text-center">
                                    <i class="fas fa-times-circle text-danger fa-4x mb-3"></i>
                                    <h5 class="mt-3">Tolak Penarikan Saldo?</h5>
                                    <p class="text-muted">Anda akan menolak penarikan saldo sebesar <strong>Rp <?= number_format($saldo['jumlah'], 0, ',', '.') ?></strong> oleh <?= esc($saldo['username']) ?></p>
                                </div>

                                <div class="mb-3">
                                    <label for="alasan<?= $saldo['id_penarikan_komisi'] ?>" class="form-label">Alasan Penolakan</label>
                                    <textarea class="form-control" id="alasan<?= $saldo['id_penarikan_komisi'] ?>" name="alasan" rows="3" required placeholder="Berikan alasan penolakan"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger rounded-pill">
                                    <i class="fas fa-times-circle me-1"></i> Konfirmasi Tolak
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

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

    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }

    .bg-info-light {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }

    /* Avatar */
    .avatar-sm {
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

    /* Rounded Elements */
    .rounded-4 {
        border-radius: 1rem !important;
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

    /* Badges */
    .badge {
        font-weight: 500;
        padding: 0.5em 1em;
    }

    /* Buttons */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    /* Pagination */
    .pagination .page-link {
        border-radius: 6px;
        margin: 0 3px;
    }

    .page-item.active .page-link {
        background-color: #6366f1;
        border-color: #6366f1;
    }

    .page-link {
        color: #4b5563;
        border: 1px solid #e5e7eb;
    }

    .page-link:hover {
        color: #6366f1;
        background-color: #f3f4f6;
    }

    /* Responsive adjustments */
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

    /* Custom enhancements */
    .form-select-sm {
        padding: 0.25rem 1.75rem 0.25rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .bg-white.bg-opacity-20 {
        background-color: rgba(255, 255, 255, 0.2) !important;
    }
    
    .bg-white.bg-opacity-10 {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }
    
    .date-cell {
        min-width: 120px;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable with enhanced configuration
        $('#withdrawalTable').DataTable({
            responsive: true,
            searching: true,
            ordering: true,
            paging: true,
            info: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            order: [[5, 'desc']], // Default sorting by date (column index 5) descending
            columnDefs: [
                {
                    orderable: false,
                    targets: [0, 6] // Disable sorting for No and Action columns
                },
                {
                    type: 'date',
                    targets: 5 // Proper date sorting for the date column
                },
                {
                    className: 'date-cell',
                    targets: 5 // Apply special class to date column
                }
            ],
            initComplete: function() {
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
                
                // Move the filter dropdown to the header
                $('#filter-status').appendTo('#withdrawalTable_wrapper .dataTables_filter');
            }
        });

        // Initialize tooltips
        $('[title]').tooltip({
            trigger: 'hover',
            placement: 'top'
        });

        // Enhanced filter functionality
        $('#filter-status').change(function() {
            const table = $('#withdrawalTable').DataTable();
            const status = $(this).val();

            if (status === 'all') {
                table.columns(4).search('').draw();
            } else {
                table.columns(4).search('^' + status + '$', true, false).draw();
            }
        });
        
        // Format date cells for better display
        $('.date-cell').each(function() {
            const dateText = $(this).text().trim();
            if (dateText) {
                const parts = dateText.split(' ');
                if (parts.length >= 2) {
                    $(this).html('<div class="d-flex flex-column"><small class="text-muted">' + 
                                parts[0] + '</small><small>' + parts[1] + '</small></div>');
                }
            }
        });
    });
</script>

<?= $this->endSection('content'); ?>