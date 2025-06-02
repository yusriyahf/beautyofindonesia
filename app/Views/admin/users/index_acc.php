<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">User Approval Management</h1>
            </div>
            <div class="col-auto">
                <div class="page-utilities">
                    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                        <div class="col-auto">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                                <i class="bi bi-people me-1"></i> All Users
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
        $AccUserModel = new App\Models\AccUserModel();
        $pending_users = $AccUserModel->where('status', 'pending')->findAll();
        $penulis_count = $AccUserModel
            ->where('role', 'penulis')
            ->where('status', 'pending')
            ->countAllResults();

        $marketing_count = $AccUserModel
            ->where('role', 'marketing')
            ->where('status', 'pending')
            ->countAllResults();
        $rejected_count = $AccUserModel->where('status', 'rejected')->countAllResults();
        ?>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Pending Approval</h4>
                        <div class="stats-figure"><?= count($pending_users) ?></div>
                        <div class="stats-meta text-warning">
                            <i class="bi bi-hourglass-split"></i> Menunggu Persetujuan
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Penulis</h4>
                        <div class="stats-figure"><?= $penulis_count ?></div>
                        <div class="stats-meta text-info">
                            <i class="bi bi-pencil-square"></i> User Penulis
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Marketing</h4>
                        <div class="stats-figure"><?= $marketing_count ?></div>
                        <div class="stats-meta text-primary">
                            <i class="bi bi-megaphone"></i> User Marketing
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Ditolak</h4>
                        <div class="stats-figure"><?= $rejected_count ?></div>
                        <div class="stats-meta text-danger">
                            <i class="bi bi-x-circle"></i> User Ditolak
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Table Section -->
        <div class="app-card app-card-orders-table shadow-sm mb-5 border-0">
            <div class="app-card-header p-3 border-0 bg-white">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h5 class="app-card-title fs-4 fw-semibold text-gray-800">Daftar User Menunggu Persetujuan</h5>
                    </div>
                    <div class="col-auto">
                        <div class="input-group input-group-sm search-group" style="width: 280px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari user...">
                            <button class="btn btn-outline-secondary" type="button">
                                Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left table-borderless">
                        <thead>
                            <tr class="text-uppercase text-muted" style="background-color: #f8f9fa;">
                                <th class="cell fw-semibold" width="5%">No</th>
                                <th class="cell fw-semibold text-center">Foto</th>
                                <th class="cell fw-semibold">User</th>
                                <th class="cell fw-semibold">Email</th>
                                <th class="cell fw-semibold">Nama Lengkap</th>
                                <th class="cell fw-semibold text-center">Role</th>
                                <th class="cell fw-semibold text-center">Status</th>
                                <th class="cell fw-semibold text-end pe-4" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pending_users)) : ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center text-muted">
                                            <i class="bi bi-people display-5 mb-3"></i>
                                            <h5 class="fw-normal">Tidak ada user menunggu persetujuan</h5>
                                            <p class="small">Semua permintaan telah diproses</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($pending_users as $user) : ?>
                                    <tr class="border-bottom border-light">
                                        <td class="cell align-middle"><?= $i++ ?></td>
                                        <td class="cell text-center align-middle">
                                            <div class="avatar avatar-md mx-auto">
                                                <img src="<?= esc($profileImage) ?>"
                                                    class="avatar-img rounded-circle border border-light shadow-sm"
                                                    style="width: 40px; height: 40px; object-fit: cover;"
                                                    alt="User Photo"
                                                    onerror="this.onerror=null; this.src='<?= base_url('assets-baru/img/user/default_profil.jpg') ?>';">
                                            </div>
                                        </td>
                                        <td class="cell align-middle">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold text-gray-800"><?= $user['username'] ?? 'N/A' ?></span>
                                                <small class="text-muted">ID: <?= $user['id_pengajuan'] ?? '' ?></small>
                                            </div>
                                        </td>
                                        <td class="cell align-middle">
                                            <span class="d-block text-truncate" style="max-width: 200px;">
                                                <?= $user['email'] ?? 'N/A' ?>
                                            </span>
                                        </td>
                                        <td class="cell align-middle"><?= $user['full_name'] ?? 'N/A' ?></td>
                                        <td class="cell text-center align-middle">
                                            <span class="badge rounded-pill py-1 px-3 fs-6 <?=
                                                                                            ($user['role'] == 'penulis') ? 'bg-info-light text-info' : (($user['role'] == 'marketing') ? 'bg-primary-light text-primary' :
                                                                                                'bg-secondary-light text-secondary') ?>">
                                                <?= ucfirst($user['role'] ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td class="cell text-center align-middle">
                                            <span class="badge rounded-pill py-1 px-3 fs-6 bg-warning-light text-warning">
                                                <i class="bi bi-hourglass me-1"></i> Pending
                                            </span>
                                        </td>
                                        <td class="text-end pe-4 align-middle">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <!-- Approve Button -->
                                                <button type="button"
                                                    class="btn btn-sm rounded-pill px-3 d-flex align-items-center border-0 shadow-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#approveModal<?= $user['id_pengajuan'] ?>"
                                                    style="background-color: #e8f7ef; color: #198754;">
                                                    <i class="bi bi-check-circle-fill me-1"></i>
                                                    <span class="fw-medium">Approve</span>
                                                </button>

                                                <!-- Reject Button -->
                                                <button type="button"
                                                    class="btn btn-sm rounded-pill px-3 d-flex align-items-center border-0 shadow-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal<?= $user['id_pengajuan'] ?>"
                                                    style="background-color: #fce8e6; color: #dc3545;">
                                                    <i class="bi bi-x-circle-fill me-1"></i>
                                                    <span class="fw-medium">Reject</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                        </tbody>
                    </table>

                    <!-- Approve Modal -->
                    <div class="modal fade" id="approveModal<?= $user['id_pengajuan'] ?>" tabindex="-1" aria-labelledby="approveModalLabel<?= $user['id_pengajuan'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 900px;">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title fs-5 fw-semibold text-gray-800" id="approveModalLabel<?= $user['id_pengajuan'] ?>">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i> Konfirmasi Persetujuan
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body p-0">
                                    <!-- Nav Tabs -->
                                    <ul class="nav nav-tabs px-3 pt-2" id="userTab<?= $user['id_pengajuan'] ?>" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile<?= $user['id_pengajuan'] ?>" type="button" role="tab">
                                                <i class="bi bi-person me-1"></i> Profil
                                            </button>
                                        </li>
                                        <?php if ($user['role'] == 'penulis' && !empty($user['contoh_karya_artikel'])) : ?>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles<?= $user['id_pengajuan'] ?>" type="button" role="tab">
                                                    <i class="bi bi-file-text me-1"></i> Contoh Karya
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content p-3" id="userTabContent<?= $user['id_pengajuan'] ?>">
                                        <!-- Profile Tab -->
                                        <div class="tab-pane fade show active" id="profile<?= $user['id_pengajuan'] ?>" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    <div class="mb-3 position-relative">
                                                        <img src="<?= !empty($user['foto'])
                                                                        ? base_url('uploads/user/' . $user['foto'])
                                                                        : base_url('assets-baru/img/user/default_profil.jpg') ?>"
                                                            class="img-thumbnail rounded-circle shadow-sm"
                                                            style="width: 120px; height: 120px; object-fit: cover;"
                                                            alt="User Photo">
                                                    </div>
                                                    <h5 class="fw-semibold mb-1"><?= $user['full_name'] ?? 'N/A' ?></h5>
                                                    <span class="text-muted small">@<?= $user['username'] ?></span>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <th width="30%" class="text-muted small">Email</th>
                                                                    <td class="fw-medium"><?= $user['email'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-muted small">Role</th>
                                                                    <td class="fw-medium">
                                                                        <span class="badge <?=
                                                                                            ($user['role'] == 'penulis') ? 'bg-info' : (($user['role'] == 'marketing') ? 'bg-primary' :
                                                                                                'bg-secondary') ?>">
                                                                            <?= ucfirst($user['role']) ?>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-muted small">Bergabung</th>
                                                                    <td class="fw-medium"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-muted small">No. Telepon</th>
                                                                    <td class="fw-medium"><?= $user['kontak'] ?? '-' ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-muted small">Bank & Rekening</th>
                                                                    <td class="fw-medium">
                                                                        <?= $user['bank_account_number'] ?? '-' ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Articles Tab (Only for Penulis) -->
                                        <?php if ($user['role'] == 'penulis' && !empty($user['contoh_karya_artikel'])) : ?>
                                            <div class="tab-pane fade" id="articles<?= $user['id_pengajuan'] ?>" role="tabpanel">
                                                <div class="card border-0 shadow-none">
                                                    <div class="card-body">
                                                        <h6 class="fw-semibold mb-3">Contoh Karya Artikel</h6>
                                                        <div class="border rounded p-3 bg-light">
                                                            <?= nl2br(htmlspecialchars($user['contoh_karya_artikel'])) ?>
                                                        </div>
                                                        <div class="mt-3 text-muted small">
                                                            <i class="bi bi-info-circle me-1"></i> Artikel ini dikirim sebagai contoh karya oleh penulis
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                    <form action="<?= base_url('admin/users/approve/' . $user['id_pengajuan']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-success rounded-pill px-4">
                                            <i class="bi bi-check-lg me-1"></i> Konfirmasi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal<?= $user['id_pengajuan'] ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?= $user['id_pengajuan'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fs-5 fw-semibold text-gray-800" id="rejectModalLabel<?= $user['id_pengajuan'] ?>">
                                        <i class="bi bi-x-circle-fill text-danger me-2"></i> Konfirmasi Penolakan
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?= base_url('admin/users/reject/' . $user['id_pengajuan']) ?>" method="post">
                                    <div class="modal-body pt-0">
                                        <div class="alert alert-warning border-0 bg-warning-light rounded-3 mb-4">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                            Anda akan menolak permintaan akses dari user ini. Berikan alasan yang jelas.
                                        </div>

                                        <div class="mb-4 text-center">
                                            <div class="avatar avatar-lg mb-2">
                                                <img src="<?= !empty($user['foto'])
                                                                ? base_url('uploads/user/' . $user['foto'])
                                                                : base_url('assets-baru/img/user/default_profil.jpg') ?>"
                                                    class="avatar-img rounded-circle border border-2 border-danger shadow-sm"
                                                    style="width: 60px; height: 60px; object-fit: cover;"
                                                    alt="User Photo">
                                            </div>
                                            <h6 class="fw-semibold mb-1"><?= $user['full_name'] ?? 'N/A' ?></h6>
                                            <span class="text-muted small">@<?= $user['username'] ?></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="rejectReason<?= $user['id_pengajuan'] ?>" class="form-label fw-semibold small">Alasan Penolakan <span class="text-danger">*</span></label>
                                            <textarea class="form-control rounded-3"
                                                id="rejectReason<?= $user['id_pengajuan'] ?>"
                                                name="reject_reason"
                                                rows="4"
                                                style="resize: none;"
                                                required
                                                placeholder="Contoh: Data identitas tidak lengkap, contoh artikel tidak memenuhi standar kualitas, dll."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                                            <i class="bi bi-x-lg me-1"></i> Tolak User
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
            </table>
                </div>

                <!-- Pagination (if needed) -->
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Menampilkan <span class="fw-semibold"><?= count($pending_users) ?></span> dari <span class="fw-semibold"><?= count($pending_users) ?></span> user
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Selanjutnya</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Enhanced Table Styles */
    .app-card-orders-table {
        border-radius: 12px;
        overflow: hidden;
    }

    .table-borderless thead tr {
        border-bottom: 2px solid #f0f0f0;
    }

    .table-borderless tbody tr {
        transition: all 0.2s;
    }

    .table-borderless tbody tr:hover {
        background-color: #f9fafb;
    }

    /* Avatar Styles */
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-lg {
        width: 60px;
        height: 60px;
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

    /* Badge Styles */
    .badge {
        font-weight: 500;
        letter-spacing: 0.4px;
    }

    .bg-info-light {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }

    .bg-primary-light {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }

    .bg-warning-light {
        background-color: rgba(246, 194, 62, 0.1) !important;
    }

    .bg-danger-light {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }

    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }

    /* Search Input */
    .search-group .form-control {
        border-left: 0;
        padding-left: 0;
    }

    .search-group .input-group-text {
        border-right: 0;
        background-color: transparent;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 12px;
    }

    .list-group-flush .list-group-item {
        border-left: 0;
        border-right: 0;
        padding-left: 0;
        padding-right: 0;
    }

    .list-group-flush .list-group-item:last-child {
        border-bottom: 0;
    }

    /* Custom Tab Styling */
    .nav-tabs .nav-link {
        color: #6c757d;
        /* Gray color for inactive tabs */
        border: none;
        padding: 0.5rem 1rem;
        margin-right: 0.5rem;
        background: transparent;
    }

    .nav-tabs .nav-link.active {
        color: #198754;
        /* Green color for active tab */
        font-weight: 500;
        background: transparent;
        border-bottom: 3px solid #198754 !important;
    }

    .nav-tabs .nav-link:hover:not(.active) {
        color: #495057;
        /* Darker gray on hover */
        border-bottom: 3px solid #dee2e6 !important;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

                for (var j = 0; j < tds.length - 1; j++) {
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

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<?= $this->endSection('content') ?>