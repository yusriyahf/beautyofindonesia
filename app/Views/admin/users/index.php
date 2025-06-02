<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-users me-2"></i> User Management</h1>
                    <p class="mb-0 opacity-75">Kelola semua user sistem di sini</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= base_url('admin/users/tambah') ?>" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-primary">
                        <i class="fas fa-plus me-1"></i>Tambah User
                    </a>
                </div>
            </div>
        </div>

        <!-- Flash Message -->
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Enhanced Summary Cards -->
        <div class="row g-4 mb-4">
            <?php
            // Count users by role
            $total_users = count($all_data_users);
            $admin_count = array_filter($all_data_users, fn($user) => $user['role'] === 'admin');
            $penulis_count = array_filter($all_data_users, fn($user) => $user['role'] === 'penulis');
            $marketing_count = array_filter($all_data_users, fn($user) => $user['role'] === 'marketing');
            ?>

            <!-- Total Users -->
            <div class="col-6 col-md-4 col-xl-3">
                <div class="card card-statistic h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-primary bg-opacity-10">
                                <i class="bi bi-people-fill text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title text-muted mb-1">Total Users</h6>
                                <h3 class="mb-0"><?= $total_users ?></h3>
                            </div>
                        </div>
                        <div class="card-progress mt-3">
                            <div class="progress bg-primary bg-opacity-10" style="height: 4px;">
                                <div class="progress-bar bg-primary" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="col-6 col-md-4 col-xl-3">
                <div class="card card-statistic h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-danger bg-opacity-10">
                                <i class="bi bi-shield-lock-fill text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title text-muted mb-1">Admin</h6>
                                <h3 class="mb-0"><?= count($admin_count) ?></h3>
                            </div>
                        </div>
                        <div class="card-progress mt-3">
                            <div class="progress bg-danger bg-opacity-10" style="height: 4px;">
                                <div class="progress-bar bg-danger" style="width: <?= $total_users ? round((count($admin_count) / $total_users) * 100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penulis Users -->
            <div class="col-6 col-md-4 col-xl-3">
                <div class="card card-statistic h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-info bg-opacity-10">
                                <i class="bi bi-pencil-fill text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title text-muted mb-1">Penulis</h6>
                                <h3 class="mb-0"><?= count($penulis_count) ?></h3>
                            </div>
                        </div>
                        <div class="card-progress mt-3">
                            <div class="progress bg-info bg-opacity-10" style="height: 4px;">
                                <div class="progress-bar bg-info" style="width: <?= $total_users ? round((count($penulis_count) / $total_users) * 100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Marketing Users -->
            <div class="col-6 col-md-4 col-xl-3">
                <div class="card card-statistic h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-warning bg-opacity-10">
                                <i class="bi bi-megaphone-fill text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title text-muted mb-1">Marketing</h6>
                                <h3 class="mb-0"><?= count($marketing_count) ?></h3>
                            </div>
                        </div>
                        <div class="card-progress mt-3">
                            <div class="progress bg-warning bg-opacity-10" style="height: 4px;">
                                <div class="progress-bar bg-warning" style="width: <?= $total_users ? round((count($marketing_count) / $total_users) * 100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table Section -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <?php if (empty($all_data_users)) : ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-user-slash fa-3x text-muted opacity-50"></i>
                            </div>
                            <h5 class="text-muted mb-2">Belum ada user terdaftar</h5>
                            <p class="text-muted mb-3">Mulai dengan menambahkan user baru</p>
                            <a href="<?= base_url('admin/users/tambah') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Tambah User
                            </a>
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="40" class="text-center">No</th>
                                        <th width="100">Foto</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Nama Lengkap</th>
                                        <th width="120" class="text-center">Role</th>
                                        <th width="150" class="text-center">Rekening</th>
                                        <th width="120" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_users as $user) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td class="text-center">
                                                <div class="avatar avatar-md mx-auto">
                                                    <img src="<?= !empty($user['foto']) ? base_url('uploads/user/' . $user['foto']) : base_url('assets-baru/img/user/default_profil.jpg') ?>"
                                                        class="avatar-img rounded-circle border" alt="User Photo">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-medium"><?= esc($user['username']) ?></div>
                                                <small class="text-muted">ID: <?= $user['id_user'] ?></small>
                                            </td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td><?= esc($user['full_name'] ?? 'N/A') ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-<?=
                                                                        ($user['role'] == 'admin') ? 'danger' : (($user['role'] == 'penulis') ? 'info' : (($user['role'] == 'marketing') ? 'warning' : 'secondary'))
                                                                        ?> bg-opacity-10 text-<?=
                                                                    ($user['role'] == 'admin') ? 'danger' : (($user['role'] == 'penulis') ? 'info' : (($user['role'] == 'marketing') ? 'warning' : 'secondary'))
                                                                    ?> border border-<?=
                                                                ($user['role'] == 'admin') ? 'danger' : (($user['role'] == 'penulis') ? 'info' : (($user['role'] == 'marketing') ? 'warning' : 'secondary'))
                                                                ?> border-opacity-10">
                                                    <?= ucfirst($user['role']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?= $user['bank_account_number'] ?? 'N/A' ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="<?= base_url('admin/users/edit/' . $user['id_user']) ?>"
                                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user['id_user'] ?>"
                                                        title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal<?= $user['id_user'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $user['id_user'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-sm rounded-3">
                                                    <div class="modal-header bg-danger bg-opacity-10 text-danger border-0">
                                                        <h5 class="modal-title fw-semibold" id="deleteModalLabel<?= $user['id_user'] ?>">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar avatar-lg me-3">
                                                                <?php if (!empty($user['foto'])) : ?>
                                                                    <img src="<?= base_url('uploads/user/' . $user['foto']) ?>"
                                                                        class="avatar-img rounded-circle border" alt="User Photo">
                                                                <?php else : ?>
                                                                    <span class="avatar-text rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                                        style="width: 60px; height: 60px; font-size: 24px;">
                                                                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0"><?= esc($user['username']) ?></h6>
                                                                <small class="text-muted"><?= esc($user['email']) ?></small>
                                                                <div class="mt-2">
                                                                    <span class="badge bg-<?=
                                                                                            ($user['role'] == 'admin') ? 'danger' : (($user['role'] == 'penulis') ? 'info' : (($user['role'] == 'marketing') ? 'warning' : 'secondary'))
                                                                                            ?>">
                                                                        <?= ucfirst($user['role']) ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="mb-3">Apakah Anda yakin ingin menghapus akun ini secara permanen?</p>
                                                        <div class="alert alert-warning mb-0">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            Semua data terkait user ini akan dihapus dan tidak dapat dikembalikan.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between border-0">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-1"></i> Batal
                                                        </button>
                                                        <a href="<?= base_url('admin/users/delete/' . $user['id_user']) ?>" class="btn btn-danger">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        /* Custom styling */
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        }

        /* Enhanced Card Statistics */
        .card-statistic {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-top: 3px solid transparent;
        }

        .card-statistic:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-statistic .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .card-statistic .card-title {
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .card-statistic h3 {
            font-weight: 700;
            font-size: 1.75rem;
        }

        .bg-soft {
            opacity: 0.15;
        }

        /* Progress bar styling */
        .card-progress .progress {
            border-radius: 100px;
        }

        .card-progress .progress-bar {
            border-radius: 100px;
        }

        /* Avatar styling */
        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-md {
            width: 40px;
            height: 40px;
        }

        .avatar-lg {
            width: 60px;
            height: 60px;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-text {
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Badge styling */
        .badge {
            font-weight: 500;
            padding: 5px 10px;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        /* Table styling */
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

        /* Button styling */
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 6px;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .card-statistic .card-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }

            .card-statistic h3 {
                font-size: 1.5rem;
            }
        }

        /* Enhanced DataTables Styling dengan Spacing yang Lebih Baik */
    .dataTables_wrapper {
        padding: 1%;
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
            $('#usersTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                columnDefs: [{
                        orderable: false,
                        targets: [1, 7]
                    }, // Disable sorting for photo and action columns
                    {
                        searchable: false,
                        targets: [0, 1, 7]
                    } // Disable searching for no, photo and action columns
                ],
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