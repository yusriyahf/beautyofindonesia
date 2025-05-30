<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="bi bi-people me-2"></i> User Approval Management</h1>
                    <p class="mb-0 opacity-75">Manage all user approval requests here</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-primary">
                        <i class="bi bi-people me-1"></i> All Users
                    </a>
                </div>
            </div>
        </div>

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
                            <i class="bi bi-hourglass-split me-1"></i> Waiting Approval
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
                            <i class="bi bi-pencil-square me-1"></i> Writer Users
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
                            <i class="bi bi-megaphone me-1"></i> Marketing Users
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-xl-3">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Rejected</h4>
                        <div class="stats-figure"><?= $rejected_count ?></div>
                        <div class="stats-meta text-danger">
                            <i class="bi bi-x-circle me-1"></i> Rejected Users
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

        <!-- Data Table Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($pending_users)) : ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-people display-5 text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">No pending approval requests</h5>
                        <p class="text-muted mb-3">All requests have been processed</p>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Full Name</th>
                                    <th width="120" class="text-center">Role</th>
                                    <th width="120" class="text-center">Status</th>
                                    <th width="150" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($pending_users as $user) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <img src="<?= !empty($user['foto']) ? base_url('uploads/user/' . $user['foto']) : base_url('assets-baru/img/user/default_profil.jpg') ?>"
                                                        class="rounded-circle border border-light shadow-sm"
                                                        style="width: 40px; height: 40px; object-fit: cover;"
                                                        alt="User Photo">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-medium"><?= esc($user['username'] ?? 'N/A') ?></div>
                                                    <small class="text-muted">ID: <?= $user['id_pengajuan'] ?? '' ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="d-block text-truncate" style="max-width: 200px;">
                                                <?= esc($user['email'] ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td><?= esc($user['full_name'] ?? 'N/A') ?></td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill py-1 px-3 <?=
                                                                                        ($user['role'] == 'penulis') ? 'bg-info bg-opacity-10 text-info border border-info border-opacity-10' : (($user['role'] == 'marketing') ? 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10' :
                                                                                            'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10') ?>">
                                                <?= ucfirst($user['role'] ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill py-1 px-3 bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10">
                                                <i class="bi bi-hourglass me-1"></i> Pending
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
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
                                            <i class="bi bi-check-circle-fill text-success me-2"></i> Confirm Approval
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-0">
                                        <!-- Nav Tabs -->
                                        <ul class="nav nav-tabs px-3 pt-2" id="userTab<?= $user['id_pengajuan'] ?>" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile<?= $user['id_pengajuan'] ?>" type="button" role="tab">
                                                    <i class="bi bi-person me-1"></i> Detail Profile
                                                </button>
                                            </li>
                                            <?php if ($user['role'] == 'penulis' && !empty($user['contoh_karya_artikel'])) : ?>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles<?= $user['id_pengajuan'] ?>" type="button" role="tab">
                                                        <i class="bi bi-file-text me-1"></i> Contoh Karya Artikel
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
                                                                        <th class="text-muted small">Join Date</th>
                                                                        <td class="fw-medium"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-muted small">Phone</th>
                                                                        <td class="fw-medium"><?= $user['kontak'] ?? '-' ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-muted small">Bank Account</th>
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
                                                            <h6 class="fw-semibold mb-3">Sample Article</h6>
                                                            <div class="border rounded p-3 bg-light">
                                                                <?= nl2br(htmlspecialchars($user['contoh_karya_artikel'])) ?>
                                                            </div>
                                                            <div class="mt-3 text-muted small">
                                                                <i class="bi bi-info-circle me-1"></i> This article was submitted as a sample by the writer
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                        <form action="<?= base_url('admin/users/approve/' . $user['id_pengajuan']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                                <i class="bi bi-check-lg me-1"></i> Confirm
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
                                            <i class="bi bi-x-circle-fill text-danger me-2"></i> Confirm Rejection
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('admin/users/reject/' . $user['id_pengajuan']) ?>" method="post">
                                        <div class="modal-body pt-0">
                                            <div class="alert alert-warning border-0 bg-warning-light rounded-3 mb-4">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                You are about to reject this user's access request. Please provide a clear reason.
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
                                                <label for="rejectReason<?= $user['id_pengajuan'] ?>" class="form-label fw-semibold small">Reason for Rejection <span class="text-danger">*</span></label>
                                                <textarea class="form-control rounded-3"
                                                    id="rejectReason<?= $user['id_pengajuan'] ?>"
                                                    name="reject_reason"
                                                    rows="4"
                                                    style="resize: none;"
                                                    required
                                                    placeholder="Example: Incomplete identity data, sample article doesn't meet quality standards, etc."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                <i class="bi bi-x-lg me-1"></i> Reject User
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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

    /* Custom CSS untuk tab */
    .nav-tabs .nav-link {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #dee2e6;
        border-bottom: none;
        margin-right: 5px;
    }

    .nav-tabs .nav-link.active {
        background-color: #fff;
        color: #0d6efd;
        border-bottom-color: #fff;
    }

    .tab-content {
        border: 1px solid #dee2e6;
        border-top: none;
        padding: 15px;
    }
</style>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            responsive: true,
            searching: true,
            ordering: true,
            paging: true,
            info: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                    orderable: false,
                    targets: [6]
                } // Make actions column non-orderable
            ],
            initComplete: function() {
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });

        // Tooltip umum
        $('[title]').tooltip({
            trigger: 'hover',
            placement: 'top'
        });
    });
</script>

<?= $this->endSection('content') ?>