<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-ad me-2 text-white"></i> Daftar Permintaan Tampil Iklan</h1>
                    <p class="mb-0 opacity-75">Kelola semua permintaan artikel beriklan di sini</p>
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

        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

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
                            <a href="<?= base_url('admin/artikel_iklan') ?>" class="btn btn-outline-secondary me-2 flex-grow-1">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                            <button type="submit" class="btn btn-info flex-grow-1 text-white">
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
                <?php if (empty($all_data_artikeliklan)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-ad fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada permintaan iklan</h5>
                        <p class="text-muted mb-3">Tidak ada permintaan tampil iklan yang perlu diproses</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="permintaanIklanTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Judul Konten</th>
                                    <th width="150">Tipe Iklan</th>
                                    <th width="120">User</th>
                                    <th width="120" class="text-center">Durasi</th>
                                    <th width="120" class="text-center">Tanggal Mulai</th>
                                    <th width="120" class="text-center">Tanggal Selesai</th>
                                    <th width="120" class="text-center">Status</th>
                                    <th width="120" class="text-center">Kontak</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($all_data_artikeliklan as $artikelIklan) : ?>
                                    <?php
                                    $today = date('Y-m-d');
                                    $tanggalMulai = $artikelIklan['tanggal_mulai'] ?? null;
                                    $tanggalSelesai = $artikelIklan['tanggal_selesai'] ?? null;
                                    $statusIklan = $artikelIklan['status_iklan'] ?? null;

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
                                    <tr>
                                        <td class="text-center text-muted"><?= $i++ ?></td>
                                        <td>
                                            <div class="fw-medium text-truncate" style="max-width: 200px;"><?= esc($artikelIklan['judul_konten'] ?? 'N/A') ?></div>
                                            <small class="text-muted"><?= esc($artikelIklan['tipe_content'] ?? 'N/A') ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10">
                                                <?= esc($artikelIklan['nama_iklan'] ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <span class="avatar-initials bg-light text-dark rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px; font-size: 10px;">
                                                        <?= strtoupper(substr($artikelIklan['username'] ?? 'U', 0, 1)) ?>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1 text-truncate" style="max-width: 100px;">
                                                    <?= esc($artikelIklan['username'] ?? 'N/A') ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <?= esc($artikelIklan['rentang_bulan'] ?? 'N/A') ?> Bulan
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($artikelIklan['tanggal_mulai'])) : ?>
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10">
                                                    <?= date('d M Y', strtotime($artikelIklan['tanggal_mulai'])) ?>
                                                </span>
                                            <?php else : ?>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10">
                                                    Belum ditentukan
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($artikelIklan['tanggal_selesai'])) : ?>
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10">
                                                    <?= date('d M Y', strtotime($artikelIklan['tanggal_selesai'])) ?>
                                                </span>
                                            <?php else : ?>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10">
                                                    Belum ditentukan
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge <?= $badgeClass ?>">
                                                <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i>
                                                <?= $status ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($artikelIklan['kontak'])) : ?>
                                                <a href="https://wa.me/<?= esc($artikelIklan['kontak']) ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                                    <i class="fab fa-whatsapp me-1"></i> Hubungi
                                                </a>
                                            <?php else : ?>
                                                <span class="text-muted">Tidak ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <?php if ($statusIklan == 'diajukan') : ?>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accModal<?= $artikelIklan['id_iklan'] ?>">
                                                        <i class="fas fa-check-circle me-1"></i> Acc
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal<?= $artikelIklan['id_iklan'] ?>">
                                                        <i class="fas fa-times-circle me-1"></i> Tolak
                                                    </button>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Acc -->
                                    <div class="modal fade" id="accModal<?= $artikelIklan['id_iklan'] ?>" tabindex="-1" aria-labelledby="accModalLabel<?= $artikelIklan['id_iklan'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="<?= base_url('admin/artikeliklan/ubahStatus') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <?php $durasiBulan = isset($artikelIklan['rentang_bulan']) ? (int)$artikelIklan['rentang_bulan'] : 0; ?>

                                                    <!-- untuk pemasukan komisi -->
                                                    <input type="hidden" name="user_id" value="<?= $artikelIklan['id_marketing'] ?>">
                                                    <input type="hidden" name="total_harga" value="<?= $artikelIklan['total_harga'] ?>">

                                                    <input type="hidden" name="id" value="<?= $artikelIklan['id_iklan'] ?>">
                                                    <input type="hidden" name="status_iklan" value="diterima">
                                                    <input type="hidden" name="nama_iklan" value="<?= esc($artikelIklan['nama_iklan']) ?>">
                                                    <input type="hidden" name="tipe_content" value="<?= esc($artikelIklan['tipe_content']) ?>">
                                                    <input type="hidden" name="id_content" value="<?= $artikelIklan['id_content'] ?>">
                                                    <input type="hidden" name="durasi_bulan" value="<?= $durasiBulan ?>">

                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="accModalLabel<?= $artikelIklan['id_iklan'] ?>">Konfirmasi Persetujuan</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p>Anda akan menyetujui permintaan tampil iklan ini:</p>
                                                        <ul class="mb-3">
                                                            <li>Judul Artikel: <strong><?= esc($artikelIklan['judul_artikel']) ?></strong></li>
                                                            <li>Nama Iklan: <strong><?= esc($artikelIklan['nama_iklan']) ?></strong></li>
                                                            <li>Durasi: <strong><?= $durasiBulan ?> Bulan</strong></li>
                                                        </ul>

                                                        <div class="mb-3">
                                                            <label for="tanggalMulai_<?= $artikelIklan['id_iklan'] ?>" class="form-label">Tanggal Mulai:</label>
                                                            <input type="date" class="form-control tanggalMulai"
                                                                id="tanggalMulai_<?= $artikelIklan['id_iklan'] ?>"
                                                                name="tanggal_mulai"
                                                                min="<?= date('Y-m-d') ?>"
                                                                required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="tanggalSelesai_<?= $artikelIklan['id_iklan'] ?>" class="form-label">Tanggal Selesai:</label>
                                                            <input type="text" class="form-control tanggalSelesai"
                                                                id="tanggalSelesai_<?= $artikelIklan['id_iklan'] ?>"
                                                                name="tanggal_selesai"
                                                                readonly>
                                                        </div>

                                                        <p class="text-muted">Pastikan tanggal sudah benar sebelum menyetujui.</p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-check-circle me-1"></i> Setujui
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const tanggalMulaiInput = document.getElementById('tanggalMulai_<?= $artikelIklan['id_iklan'] ?>');
                                            const tanggalSelesaiInput = document.getElementById('tanggalSelesai_<?= $artikelIklan['id_iklan'] ?>');
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

                                    <!-- Modal Tolak -->
                                    <div class="modal fade" id="tolakModal<?= $artikelIklan['id_iklan'] ?>" tabindex="-1" aria-labelledby="tolakModalLabel<?= $artikelIklan['id_iklan'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="<?= base_url('admin/artikeliklan/ubahStatus') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="id" value="<?= $artikelIklan['id_iklan'] ?>">
                                                    <input type="hidden" name="status_iklan" value="ditolak">
                                                    <input type="hidden" name="nama_iklan" value="<?= esc($artikelIklan['nama_iklan']) ?>">
                                                    <input type="hidden" name="id_content" value="<?= $artikelIklan['id_content'] ?>">

                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="tolakModalLabel<?= $artikelIklan['id_iklan'] ?>">Konfirmasi Penolakan</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p>Anda akan menolak permintaan tampil iklan ini:</p>
                                                        <ul class="mb-3">
                                                            <li>Judul Artikel: <strong><?= esc($artikelIklan['judul_artikel']) ?></strong></li>
                                                            <li>Nama Iklan: <strong><?= esc($artikelIklan['nama_iklan']) ?></strong></li>
                                                        </ul>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times-circle me-1"></i> Tolak
                                                        </button>
                                                    </div>
                                                </form>
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
        background: linear-gradient(135deg, #667eea 0%,rgb(100, 181, 201) 100%);
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
        // Initialize DataTable
        $('#permintaanIklanTable').DataTable({
            responsive: true,
            searching: true,
            ordering: true,
            paging: true,
            info: false,
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
    });
</script>

<?= $this->endSection('content'); ?>