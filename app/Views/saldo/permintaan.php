<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title text-dark mb-0">
                            <i class="bi bi-wallet2 me-2 fs-2 text-primary"></i>Permintaan Penarikan Saldo
                        </h1>
                        <p class="text-muted mb-0">Kelola permintaan penarikan saldo dari mitra</p>
                    </div>
                    <div class="filter-section">
                        <select class="form-select form-select-sm shadow-sm border-primary">
                            <option value="all" selected>Semua Status</option>
                            <option value="diproses">Diproses</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4 g-4">
            <div class="col-md-4">
                <div class="card stat-card border-0 bg-gradient-primary-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php
                            $total_penarikan = 0;
                            foreach ($all_data_penarikan_saldo as $saldo) {
                                $total_penarikan += $saldo['jumlah'];
                            }
                            ?>

                            <div>
                                <h6 class="text-muted mb-1">Total Penarikan</h6>
                                <h3 class="mb-0 text-white">Rp <?= esc(number_format($total_penarikan, 2, ',', '.')) ?></h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-currency-exchange fs-4 text-white"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Tambahkan bagian count_diproses dan count_disetujui di controller -->
            <div class="col-md-4">
                <div class="card stat-card border-0 bg-gradient-warning-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Dalam Proses</h6>
                                <h2 class="mb-0 text-white">4</h2>
                            </div>
                            <div class="bg-white-10 p-3 rounded-circle">
                                <i class="bi bi-hourglass-split fs-3 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card border-0 bg-gradient-success-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Disetujui</h6>
                                <h2 class="mb-0 text-white">5</h2>
                            </div>
                            <div class="bg-white-10 p-3 rounded-circle">
                                <i class="bi bi-check-circle fs-3 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal Requests Table -->
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="bi bi-wallet2 me-2 text-primary"></i>Daftar Permintaan Penarikan
                    </h5>
                    <div class="d-flex gap-2">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Cari...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 ps-4" style="width: 50px;">#</th>
                                <th class="py-3">Pengguna</th>
                                <th class="py-3">Role</th>
                                <th class="py-3">Jumlah</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Tanggal</th>
                                <th class="py-3 text-center pe-4" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($all_data_penarikan_saldo as $saldo) : ?>
                                <tr class="position-relative hover-shadow">
                                    <td class="ps-4 text-muted"><?= $i++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <span class="avatar-title bg-primary-soft rounded-circle text-primary fw-bold">
                                                    <?= esc($saldo['username']) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge border border-primary-subtle bg-primary-soft text-primary">
                                            <?= esc($saldo['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success">
                                            Rp <?= esc(number_format($saldo['jumlah'], 0, ',', '.')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $status = $saldo['status'];
                                        $badgeClass = 'border border-secondary-subtle bg-secondary-soft text-secondary';
                                        $icon = 'bi-clock-history';

                                        if ($status === 'diproses') {
                                            $badgeClass = 'border border-warning-subtle bg-warning-soft text-warning';
                                            $icon = 'bi-hourglass-split';
                                        } elseif ($status === 'disetujui') {
                                            $badgeClass = 'border border-success-subtle bg-success-soft text-success';
                                            $icon = 'bi-check-circle';
                                        } elseif ($status === 'ditolak') {
                                            $badgeClass = 'border border-danger-subtle bg-danger-soft text-danger';
                                            $icon = 'bi-x-circle';
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>">
                                            <i class="bi <?= $icon ?> me-1"></i><?= esc(ucfirst($status)) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="text-dark fw-medium">
                                                <?= esc(date('d M Y', strtotime($saldo['tanggal_pengajuan']))) ?>
                                            </div>
                                            <small class="text-muted">
                                                <?= esc(date('H:i', strtotime($saldo['tanggal_pengajuan']))) ?>
                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <?php if ($status == 'diproses') : ?>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <!-- Enhanced Approve Button -->
                                                <button type="button"
                                                    class="btn btn-success btn-sm rounded-pill px-3 d-flex align-items-center"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#accModal<?= $saldo['id_penarikan_komisi'] ?>"
                                                    title="Setujui Penarikan"
                                                    style="box-shadow: 0 2px 4px rgba(25, 135, 84, 0.2); transition: all 0.3s;">
                                                    <i class="bi bi-check-circle-fill me-1"></i>
                                                    <span class="fw-medium">Approve</span>
                                                </button>

                                                <!-- Enhanced Reject Button -->
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm rounded-pill px-3 d-flex align-items-center"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tolakModal<?= $saldo['id_penarikan_komisi'] ?>"
                                                    title="Tolak Penarikan"
                                                    style="transition: all 0.3s; border-width: 2px;">
                                                    <i class="bi bi-x-circle-fill me-1"></i>
                                                    <span class="fw-medium">Reject</span>
                                                </button>
                                            </div>
                                        <?php else : ?>
                                            <span class="badge bg-light text-muted border py-2 px-3 rounded-pill">
                                                <i class="bi bi-check2-all me-1"></i> Selesai
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Enhanced Pagination -->
            <div class="card-footer bg-white border-top">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-2 mb-md-0">
                        <p class="small text-muted mb-0">
                            Menampilkan <span class="fw-semibold">1-10</span> dari <span class="fw-semibold">50</span> entri
                        </p>
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <!-- Previous Page -->
                            <li class="page-item disabled">
                                <a class="page-link rounded-start" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <!-- Page Numbers -->
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>

                            <!-- Next Page -->
                            <li class="page-item">
                                <a class="page-link rounded-end" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <div class="mt-2 mt-md-0">
                        <div class="input-group input-group-sm" style="width: 120px;">
                            <span class="input-group-text bg-transparent">Halaman</span>
                            <input type="number" class="form-control" value="1" min="1" max="5">
                        </div>
                    </div>
                </div>
            </div>

            <?php foreach ($all_data_penarikan_saldo as $saldo) : ?>
                <!-- Modal Approve -->
                <div class="modal fade" id="accModal<?= $saldo['id_penarikan_komisi'] ?>" tabindex="-1" aria-labelledby="accModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="accModalLabel">Konfirmasi Approve Penarikan</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('admin/saldo/ubahstatus') ?>" method="POST" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="id_penarikan_komisi" value="<?= $saldo['id_penarikan_komisi'] ?>">
                                <div class="modal-body">
                                    <div class="mb-4 text-center">
                                        <i class="bi bi-check-circle-fill text-success fs-1"></i>
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
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle me-1"></i> Konfirmasi Approve
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
                                <h5 class="modal-title" id="tolakModalLabel">Konfirmasi Tolak Penarikan</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('admin/penarikan/reject/' . $saldo['id_penarikan_komisi']) ?>" method="POST">
                                <div class="modal-body">
                                    <div class="mb-4 text-center">
                                        <i class="bi bi-x-circle-fill text-danger fs-1"></i>
                                        <h5 class="mt-3">Tolak Penarikan Saldo?</h5>
                                        <p class="text-muted">Anda akan menolak penarikan saldo sebesar <strong>Rp <?= number_format($saldo['jumlah'], 0, ',', '.') ?></strong> oleh <?= esc($saldo['username']) ?></p>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alasan<?= $saldo['id_penarikan_komisi'] ?>" class="form-label">Alasan Penolakan</label>
                                        <textarea class="form-control" id="alasan<?= $saldo['id_penarikan_komisi'] ?>" name="alasan" rows="3" required placeholder="Berikan alasan penolakan"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-x-circle me-1"></i> Konfirmasi Tolak
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <style>
            .hover-shadow:hover {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                transform: translateY(-1px);
                transition: all 0.2s ease;
            }

            .avatar-sm {
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .badge {
                padding: 0.5em 0.75em;
                font-weight: 500;
                border-radius: 8px;
            }

            .table thead th {
                background-color: #f8f9fa;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 0.5px;
                color: #6c757d;
            }

            .table tbody td {
                vertical-align: middle;
            }

            .btn-outline-success {
                color: #198754;
                border-color: #198754;
            }

            .btn-outline-danger {
                color: #dc3545;
                border-color: #dc3545;
            }

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
                margin: 0 2px;
            }

            .page-link:hover {
                color: #6366f1;
                background-color: #f3f4f6;
            }

            .input-group-sm input {
                text-align: center;
            }

            .stat-card {
                transition: all 0.3s ease;
                border-radius: 12px;
                overflow: hidden;
                position: relative;
                border: none;
            }

            .stat-card::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1));
                transform: rotate(45deg);
                pointer-events: none;
            }

            .bg-gradient-primary-hover {
                background: linear-gradient(135deg, #4a90e2, #6366f1);
            }

            .bg-gradient-warning-hover {
                background: linear-gradient(135deg, #f59e0b, #d97706);
            }

            .bg-gradient-success-hover {
                background: linear-gradient(135deg, #10b981, #059669);
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .avatar-sm {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .table thead th {
                background-color: #f8f9fa;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.8rem;
                letter-spacing: 0.5px;
                color: #6c757d;
            }

            .table tbody tr {
                transition: all 0.2s ease;
            }

            .table tbody tr:hover {
                background-color: #f8fafc;
                transform: scale(1.002);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .badge {
                padding: 0.5em 0.8em;
                font-weight: 500;
            }
        </style>

        <?= $this->endSection('content') ?>