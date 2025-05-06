<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">User Management</h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto">
                            <a href="<?= base_url('admin/users/tambah') ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Tambah User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Message -->
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


        <?php
        // Hitung langsung di View (tidak ideal)
        $total_users = count($all_data_users);
        $admin_count = array_filter($all_data_users, fn($user) => $user['role'] === 'admin');
        $penulis_count = array_filter($all_data_users, fn($user) => $user['role'] === 'penulis');
        $marketing_count = array_filter($all_data_users, fn($user) => $user['role'] === 'marketing');
        ?>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Users -->
            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Total Users</h4>
                        <div class="stats-figure"><?= $total_users ?></div>
                        <div class="stats-meta text-success">
                            <i class="bi bi-people-fill"></i> Semua User
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Users -->
            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Admin</h4>
                        <div class="stats-figure"><?= is_array($admin_count) ? count($admin_count) : $admin_count ?></div>
                        <div class="stats-meta text-danger">
                            <i class="bi bi-shield-lock"></i> User Administrator
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penulis Users -->
            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Penulis</h4>
                        <div class="stats-figure"><?= is_array($penulis_count) ? count($penulis_count) : $penulis_count ?></div>
                        <div class="stats-meta text-info">
                            <i class="bi bi-pencil-square"></i> User Penulis
                        </div>
                    </div>
                </div>
            </div>

            <!-- Marketing Users -->
            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Marketing</h4>
                        <div class="stats-figure"><?= is_array($marketing_count) ? count($marketing_count) : $marketing_count ?></div>
                        <div class="stats-meta text-warning">
                            <i class="bi bi-megaphone"></i> User Marketing
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h5 class="app-card-title">Daftar Semua User</h5>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-actions">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari user...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-card-body p-3">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr class="table-light">
                                <th class="cell text-center" width="5%">No</th>
                                <th class="cell text-center">Foto User</th>
                                <th class="cell">User</th>
                                <th class="cell">Email</th>
                                <th class="cell">Nama Lengkap</th>
                                <th class="cell text-center">Role</th>
                                <th class="cell text-center">Nomor Rekening</th>
                                <th class="cell text-center" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($all_data_users)) : ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-people display-4 text-muted mb-3"></i>
                                            <h5 class="text-muted">Tidak ada user ditemukan</h5>
                                            <a href="<?= base_url('admin/users/tambah') ?>" class="btn btn-sm btn-primary mt-2">
                                                <i class="bi bi-plus-circle me-1"></i> Tambah User Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($all_data_users as $user) : ?>
                                    <tr>
                                        <td class="cell text-center"><?= $i++ ?></td>
                                        <td class="cell text-center">
                                            <div class="avatar avatar-md">
                                                <img src="<?= !empty($user['foto'])
                                                                ? base_url('uploads/user/' . $user['foto'])
                                                                : base_url('assets-baru/img/user/default_profil.jpg') ?>"
                                                    class="avatar-img rounded-circle" alt="User Photo">
                                            </div>
                                        </td>

                                        <td class="cell">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold"><?= $user['username'] ?? 'N/A' ?></span>
                                                <small class="text-muted">ID: <?= $user['id_user'] ?? '' ?></small>
                                            </div>
                                        </td>
                                        <td class="cell"><?= $user['email'] ?? 'N/A' ?></td>
                                        <td class="cell"><?= $user['full_name'] ?? 'N/A' ?></td>
                                        <td class="cell text-center">
                                            <span class="badge bg-<?=
                                                                    ($user['role'] == 'admin') ? 'danger' : (($user['role'] == 'penulis') ? 'info' : (($user['role'] == 'marketing') ? 'warning' : 'secondary'))
                                                                    ?>">
                                                <?= ucfirst($user['role'] ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td class="cell text-center"><?= $user['bank_account_number'] ?? 'N/A' ?></td>
                                        <td class="cell text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?= base_url('admin/users/edit/' . $user['id_user']) ?>" class="btn btn-outline-primary" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user['id_user'] ?>" data-bs-tooltip="tooltip" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal<?= $user['id_user'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $user['id_user'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $user['id_user'] ?>">Konfirmasi Penghapusan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="avatar avatar-md me-3">
                                                            <?php if (!empty($user['foto'])) : ?>
                                                                <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" class="avatar-img rounded-circle" alt="User Photo">
                                                            <?php else : ?>
                                                                <span class="avatar-text rounded-circle bg-primary text-white">
                                                                    <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0"><?= $user['username'] ?? 'N/A' ?></h6>
                                                            <small class="text-muted"><?= $user['email'] ?? 'N/A' ?></small>
                                                            <div class="mt-1">
                                                                <span class="badge bg-<?=
                                                                                        ($user['role'] == 'admin') ? 'danger' : (($user['role'] == 'penulis') ? 'info' : (($user['role'] == 'marketing') ? 'warning' : 'secondary'))
                                                                                        ?>">
                                                                    <?= ucfirst($user['role'] ?? 'N/A') ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p>Apakah Anda yakin ingin menghapus akun user ini secara permanen?</p>
                                                    <div class="alert alert-warning mb-0">
                                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                                        Aksi ini tidak dapat dibatalkan.
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('admin/users/delete/' . $user['id_user']) ?>" class="btn btn-danger">
                                                        <i class="bi bi-trash me-1"></i> Hapus
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>

<style>
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-md {
        width: 40px;
        height: 40px;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-text {
        font-weight: 600;
        font-size: 1rem;
    }

    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 500;
    }

    .badge.bg-danger {
        background-color: #dc3545 !important;
    }

    .badge.bg-info {
        background-color: #0dcaf0 !important;
    }

    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .table th {
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }

    .app-card-title {
        font-weight: 500;
    }

    .alert {
        border-left: 4px solid;
    }
</style>

<script>
    // Enable tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.querySelector(".app-table-hover");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                var found = false;
                var tds = tr[i].getElementsByTagName("td");

                for (var j = 0; j < tds.length - 1; j++) { // Skip the last column (actions)
                    td = tds[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }

                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        });
    });
</script>

<?= $this->endSection('content') ?>