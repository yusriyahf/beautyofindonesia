<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-ad me-2 text-white"></i> Daftar Iklan Utama</h1>
                    <p class="mb-0 opacity-75">Kelola semua iklan utama di sini</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= base_url('marketing/iklanutama/tambah') ?>" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-info">
                        <i class="fas fa-plus me-1"></i>Tambah Iklan
                    </a>
                </div>
            </div>
        </div>

        <!-- Modern Filter Section -->
        <div class="card border-0 mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <!-- Date Filter -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">TANGGAL PENGAJUAN</label>
                        <div class="input-group">
                            <input type="date" id="publish_date" class="form-control flatpickr-input" placeholder="Pilih tanggal">
                            <span class="input-group-text bg-transparent">
                                <i class="far fa-calendar-alt text-muted"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">STATUS</label>
                        <select id="statusFilter" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <!-- Search Field -->
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">CARI IKLAN</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Marketing, jenis iklan...">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-2 d-flex">
                        <button type="button" id="resetFilter" class="btn btn-outline-secondary me-2 flex-grow-1">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <button type="button" id="applyFilter" class="btn btn-info flex-grow-1 text-white">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ads Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($all_data_iklan_utama)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-ad fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada iklan utama</h5>
                        <p class="text-muted mb-3">Mulai dengan membuat iklan baru</p>
                        <a href="<?= base_url('marketing/iklanutama/tambah') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Iklan
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="iklanTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Marketing</th>
                                    <th width="120">Jenis Iklan</th>
                                    <th width="120">Rentang</th>
                                    <th width="120" class="text-center">Tanggal Pengajuan</th>
                                    <th width="120" class="text-center">Status</th>
                                    <th width="100" class="text-center">Harga</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($all_data_iklan_utama as $item):
                                    $today = date('Y-m-d');
                                    $tanggalMulai = $artikelIklan['tanggal_mulai'] ?? null;
                                    $tanggalSelesai = $artikelIklan['tanggal_selesai'] ?? null;
                                    $statusIklan = $item['status'] ?? null;

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

                                    switch (strtolower($status)) {
                                        case 'diajukan':
                                            $badgeClass = 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10';
                                            break;
                                        case 'ditolak':
                                            $badgeClass = 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10';
                                            break;
                                        case 'diterima':
                                            $badgeClass = 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10';
                                            break;
                                        case 'berjalan':
                                            $badgeClass = 'bg-success bg-opacity-10 text-success border border-success border-opacity-10';
                                            break;
                                        case 'selesai':
                                            $badgeClass = 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10';
                                            break;
                                        default:
                                            $badgeClass = 'bg-dark bg-opacity-10 text-dark border border-dark border-opacity-10';
                                            break;
                                    }
                                ?>
                                    <tr class="table-row"
                                        data-date="<?= date('Y-m-d', strtotime($item['tanggal_pengajuan'])) ?>"
                                        data-status="<?= esc($item['status']) ?>"
                                        data-search="<?= strtolower(esc($item['id_marketing'] . ' ' . $item['id_tipe_iklan_utama'])) ?>">
                                        <td class="text-center text-muted"><?= $i++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <span class="avatar-initials bg-light text-dark rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px; font-size: 10px;">
                                                        <?= strtoupper(substr($item['id_marketing'] ?? 'M', 0, 1)) ?>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <?= esc($item['username']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10">
                                                        <?= esc($item['id_tipe_iklan_utama'] ?? '-') ?>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <?= esc($item['nama_tipe_iklan_utama'] ?? '-') ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?= esc($item['rentang_bulan']) ?> Bulan
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="text-dark fw-medium"><?= date('d', strtotime($item['tanggal_pengajuan'])) ?></div>
                                                <div class="text-muted small"><?= date('M Y', strtotime($item['tanggal_pengajuan'])) ?></div>
                                            </div>
                                        </td>
                                         <td class="text-center">
                                            <span class="badge <?= $badgeClass ?>">
                                                <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i>
                                                <?= $status ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            Rp <?= number_format(esc($item['total_harga']), 0, ',', '.') ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="<?= base_url('marketing/iklanutama/detail/' . $item['id_iklan_utama']) ?>"
                                                    class="btn btn-sm btn-outline-primary" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('marketing/iklanutama/edit/' . $item['id_iklan_utama']) ?>"
                                                    class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger delete-btn"
                                                    title="Hapus" data-id="<?= $item['id_iklan_utama'] ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus iklan ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-sm btn-danger">Hapus</a>
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
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable (without paging to keep CI pagination)
        $('#iklanTable').DataTable({
            responsive: true,
            searching: false, // Disable DataTables search since we have custom search
            ordering: true,
            paging: true,
            info: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                    orderable: false,
                    targets: [7] // Disable sorting for action column
                },
                {
                    type: 'currency',
                    targets: 6 // For proper sorting of currency values
                }
            ],
            initComplete: function() {
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });

        // Delete button handler
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id_iklan_utama');
            var url = '<?= base_url("marketing/iklanutama/delete/") ?>' + id;
            $('#confirmDelete').attr('href', url);
            $('#deleteModal').modal('show');
        });

        // Initialize tooltips
        $('[title]').tooltip({
            trigger: 'hover',
            placement: 'top'
        });

        // Filter functionality
        function applyFilters() {
            const dateFilter = $('#publish_date').val();
            const status = $('#statusFilter').val();
            const searchTerm = $('#searchInput').val().toLowerCase();

            $('.table-row').each(function() {
                const rowDate = $(this).data('date');
                const rowStatus = $(this).data('status');
                const rowSearch = $(this).data('search');

                // Date filter
                const datePass = !dateFilter || rowDate === dateFilter;

                // Status filter
                const statusPass = !status || rowStatus === status;

                // Search filter
                const searchPass = !searchTerm || rowSearch.includes(searchTerm);

                // Show/hide based on filters
                if (datePass && statusPass && searchPass) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Apply filter button
        $('#applyFilter').on('click', applyFilters);

        // Reset filter button
        $('#resetFilter').on('click', function() {
            $('#publish_date').val('');
            $('#statusFilter').val('');
            $('#searchInput').val('');
            applyFilters();
        });

        // Auto-apply filter when inputs change
        $('#publish_date, #statusFilter').on('change', applyFilters);
        $('#searchInput').on('keyup', applyFilters);

        // Initialize date picker
        flatpickr("#publish_date", {
            dateFormat: "Y-m-d",
            allowInput: true,
            onChange: function() {
                applyFilters();
            }
        });
    });
</script>

<?= $this->endSection('content'); ?>