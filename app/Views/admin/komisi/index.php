<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-percentage me-2 text-white"></i> Manajemen Komisi</h1>
                    <p class="mb-0 opacity-75">Kelola komisi default dan riwayat komisi custom</p>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card stat-card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Komisi Default</h6>
                                <h3 class="mb-0"><?= count($komisi_default) ?></h3>
                            </div>
                            <div class="stat-icon bg-primary-light rounded-4">
                                <i class="fas fa-cog text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Komisi Custom</h6>
                                <h3 class="mb-0"><?= count($komisi_custom) ?></h3>
                            </div>
                            <div class="stat-icon bg-success-light rounded-4">
                                <i class="fas fa-history text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Penerima Komisi Custom</h6>
                                <h3 class="mb-0"><?= count(array_unique(array_column($komisi_custom, 'id_user'))) ?></h3>
                            </div>
                            <div class="stat-icon bg-info-light rounded-4">
                                <i class="fas fa-users text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Komisi Custom -->
        <div class="modal fade" id="addCustomCommissionModal" tabindex="-1" aria-labelledby="addCustomCommissionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title" id="addCustomCommissionModalLabel"><i class="fas fa-plus-circle me-2"></i> Tambah Komisi Custom</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('admin/riwayatkomisi/tambah_custom') ?>" method="POST">
                        <div class="modal-body">
                            <?= csrf_field(); ?>

                            <div class="mb-3">
                                <label for="id_iklan" class="form-label">ID Iklan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control rounded-pill" id="id_iklan" name="id_iklan" required>
                                <small class="text-muted">Masukkan ID iklan yang akan diberikan komisi</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipe_iklan" class="form-label">Tipe Iklan <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-pill" id="tipe_iklan" name="tipe_iklan" required>
                                        <option value="konten">Konten</option>
                                        <option value="utama">Utama</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="id_user" class="form-label">ID User <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control rounded-pill" id="id_user" name="id_user" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="peran" class="form-label">Peran <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-pill" id="peran" name="peran" required>
                                        <option value="penulis">Penulis</option>
                                        <option value="marketing">Marketing</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="persen" class="form-label">Persentase Komisi (%) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control rounded-pill" id="persen" name="persen" min="1" max="100" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="jumlah_komisi" class="form-label">Jumlah Komisi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text rounded-start-pill">Rp</span>
                                    <input type="number" class="form-control rounded-end-pill" id="jumlah_komisi" name="jumlah_komisi" required>
                                </div>
                                <small class="text-muted">Masukkan jumlah komisi dalam rupiah</small>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>
                        <strong>Sukses!</strong> <?= session()->getFlashdata('success') ?>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>
                        <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tabel Komisi Default -->
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4">
            <div class="card-header bg-white p-4 border-0">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0"><i class="fas fa-cog text-primary me-2"></i> Komisi Default</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2">
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text bg-light border-0 rounded-start-pill"><i class="fas fa-filter"></i></span>
                                <select class="form-select border-0 bg-light rounded-end-pill" id="filter-peran-default">
                                    <option value="all" selected>Semua Peran</option>
                                    <option value="admin">Admin</option>
                                    <option value="penulis">Penulis</option>
                                    <option value="marketing">Marketing</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="defaultCommissionTable" class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="40">No</th>
                                <th>Nama Peran</th>
                                <th class="text-end">Persentase Komisi</th>
                                <th>Tanggal Dibuat</th>
                                <th>Terakhir Diupdate</th>
                                <th width="140" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($komisi_default as $i => $komisi): ?>
                                <tr>
                                    <td class="text-muted"><?= $i + 1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="transaction-icon bg-primary-light text-primary rounded-3 p-2 me-3">
                                                <i class="fas fa-user-tag"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-capitalize"><?= esc($komisi['nama']) ?></h6>
                                                <small class="text-muted">ID: <?= $komisi['id'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <h6 class="mb-0 text-primary"><?= $komisi['komisi'] ?>%</h6>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= date('d M Y', strtotime($komisi['created_at'])) ?></small><br>
                                        <small><?= date('H:i', strtotime($komisi['created_at'])) ?></small>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= date('d M Y', strtotime($komisi['updated_at'])) ?></small><br>
                                        <small><?= date('H:i', strtotime($komisi['updated_at'])) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#editDefaultModal<?= $komisi['id'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteDefaultModal<?= $komisi['id'] ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Komisi Default -->
                                <div class="modal fade" id="editDefaultModal<?= $komisi['id'] ?>" tabindex="-1" aria-labelledby="editDefaultModalLabel<?= $komisi['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header bg-primary text-white rounded-top-4">
                                                <h5 class="modal-title" id="editDefaultModalLabel<?= $komisi['id'] ?>">
                                                    <i class="fas fa-edit me-2"></i> Edit Komisi Default
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?= base_url('admin/riwayatkomisi/update_default/' . $komisi['id']) ?>" method="POST">
                                                <div class="modal-body">
                                                    <?= csrf_field(); ?>

                                                    <div class="mb-3">
                                                        <label for="nama<?= $komisi['id'] ?>" class="form-label">Nama Peran <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control rounded-pill" id="nama<?= $komisi['id'] ?>" name="nama" value="<?= esc($komisi['nama']) ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="komisi<?= $komisi['id'] ?>" class="form-label">Persentase Komisi (%) <span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control rounded-pill" id="komisi<?= $komisi['id'] ?>" name="komisi" min="1" max="100" value="<?= $komisi['komisi'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                        <i class="fas fa-save me-1"></i> Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Hapus Komisi Default -->
                                <div class="modal fade" id="deleteDefaultModal<?= $komisi['id'] ?>" tabindex="-1" aria-labelledby="deleteDefaultModalLabel<?= $komisi['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header bg-danger text-white rounded-top-4">
                                                <h5 class="modal-title" id="deleteDefaultModalLabel<?= $komisi['id'] ?>">
                                                    <i class="fas fa-trash me-2"></i> Hapus Komisi Default
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?= base_url('admin/riwayatkomisi/delete_default/' . $komisi['id']) ?>" method="POST">
                                                <div class="modal-body">
                                                    <?= csrf_field(); ?>
                                                    <p>Anda yakin ingin menghapus komisi default untuk peran <strong><?= esc($komisi['nama']) ?></strong>?</p>
                                                    <div class="alert alert-warning mt-3 rounded-4">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        Perubahan ini akan mempengaruhi semua komisi yang menggunakan setting default.
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                        <i class="fas fa-trash me-1"></i> Hapus
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
            </div>
        </div>

        <!-- Modal Tambah Komisi Default -->
        <div class="modal fade" id="addDefaultModal" tabindex="-1" aria-labelledby="addDefaultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title" id="addDefaultModalLabel">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Komisi Default
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('admin/riwayatkomisi/tambah_default') ?>" method="POST">
                        <div class="modal-body">
                            <?= csrf_field(); ?>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Peran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-pill" id="nama" name="nama" required>
                                <small class="text-muted">Contoh: Penulis, Marketing, Admin</small>
                            </div>

                            <div class="mb-3">
                                <label for="komisi" class="form-label">Persentase Komisi (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control rounded-pill" id="komisi" name="komisi" min="1" max="100" required>
                                <small class="text-muted">Masukkan persentase antara 1-100%</small>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Komisi Custom -->
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
            <div class="card-header bg-white p-4 border-0">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0"><i class="fas fa-history text-primary me-2"></i> Riwayat Komisi Custom</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2">
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text bg-light border-0 rounded-start-pill"><i class="fas fa-filter"></i></span>
                                <select class="form-select border-0 bg-light rounded-end-pill" id="filter-peran-custom">
                                    <option value="all" selected>Semua Peran</option>
                                    <option value="penulis">Penulis</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text bg-light border-0 rounded-start-pill"><i class="fas fa-ad"></i></span>
                                <select class="form-select border-0 bg-light rounded-end-pill" id="filter-tipe-custom">
                                    <option value="all" selected>Semua Tipe</option>
                                    <option value="konten">Konten</option>
                                    <option value="utama">Utama</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <?php if (empty($komisi_custom)): ?>
                    <div class="text-center py-5 empty-state">
                        <div class="mb-3">
                            <i class="fas fa-exchange-alt fa-4x text-muted opacity-25"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada komisi custom</h5>
                        <p class="text-muted mb-3">Tambahkan komisi custom untuk melihat riwayat</p>
                        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addCustomCommissionModal">
                            <i class="fas fa-plus me-1"></i> Tambah Komisi
                        </button>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="customCommissionTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40">No</th>
                                    <th>Detail Komisi</th>
                                    <th>Peran</th>
                                    <th class="text-end">Persentase</th>
                                    <th class="text-end">Jumlah</th>
                                    <th>Tanggal</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($komisi_custom as $i => $komisi): ?>
                                    <tr>
                                        <td class="text-muted"><?= $i + 1 ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="transaction-icon bg-info-light text-info rounded-3 p-2 me-3">
                                                    <i class="fas fa-ad"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Iklan #<?= $komisi['id_iklan'] ?></h6>
                                                    <small class="text-muted text-capitalize"><?= esc($komisi['tipe_iklan']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-capitalize">
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                                                <?= esc($komisi['peran']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <h6 class="mb-0 text-success"><?= $komisi['persen'] ?>%</h6>
                                        </td>
                                        <td class="text-end">
                                            <h6 class="mb-0 text-success">Rp <?= number_format($komisi['jumlah_komisi'], 0, ',', '.') ?></h6>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?= date('d M Y', strtotime($komisi['created_at'])) ?></small><br>
                                            <small><?= date('H:i', strtotime($komisi['created_at'])) ?></small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#detailCustomModal<?= $komisi['id'] ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteCustomModal<?= $komisi['id'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail Komisi Custom -->
                                    <div class="modal fade" id="detailCustomModal<?= $komisi['id'] ?>" tabindex="-1" aria-labelledby="detailCustomModalLabel<?= $komisi['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header bg-primary text-white rounded-top-4">
                                                    <h5 class="modal-title" id="detailCustomModalLabel<?= $komisi['id'] ?>">
                                                        <i class="fas fa-info-circle me-2"></i> Detail Komisi Custom
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card h-100 border-0 shadow-sm">
                                                                <div class="card-body">
                                                                    <h6 class="card-title text-muted mb-3"><i class="fas fa-ad me-2"></i>Info Iklan</h6>
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                            <span>ID Iklan</span>
                                                                            <span class="badge bg-primary rounded-pill">#<?= $komisi['id_iklan'] ?></span>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                            <span>Tipe Iklan</span>
                                                                            <span class="text-capitalize"><?= esc($komisi['tipe_iklan']) ?></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card h-100 border-0 shadow-sm">
                                                                <div class="card-body">
                                                                    <h6 class="card-title text-muted mb-3"><i class="fas fa-user-tag me-2"></i>Info Penerima</h6>
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                            <span>ID User</span>
                                                                            <span class="badge bg-info rounded-pill">#<?= $komisi['id_user'] ?></span>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                            <span>Peran</span>
                                                                            <span class="text-capitalize"><?= esc($komisi['peran']) ?></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card h-100 border-0 shadow-sm">
                                                                <div class="card-body">
                                                                    <h6 class="card-title text-muted mb-3"><i class="fas fa-percentage me-2"></i>Detail Komisi</h6>
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                            <span>Persentase</span>
                                                                            <span class="badge bg-success rounded-pill"><?= $komisi['persen'] ?>%</span>
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                            <span>Jumlah Komisi</span>
                                                                            <span class="fw-bold text-success">Rp <?= number_format($komisi['jumlah_komisi'], 0, ',', '.') ?></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card h-100 border-0 shadow-sm">
                                                                <div class="card-body">
                                                                    <h6 class="card-title text-muted mb-3"><i class="fas fa-calendar-alt me-2"></i>Info Waktu</h6>
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                            <span>Dibuat Pada</span>
                                                                            <small><?= date('d M Y H:i', strtotime($komisi['created_at'])) ?></small>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i> Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus Komisi Custom -->
                                    <div class="modal fade" id="deleteCustomModal<?= $komisi['id'] ?>" tabindex="-1" aria-labelledby="deleteCustomModalLabel<?= $komisi['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header bg-danger text-white rounded-top-4">
                                                    <h5 class="modal-title" id="deleteCustomModalLabel<?= $komisi['id'] ?>">
                                                        <i class="fas fa-trash me-2"></i> Hapus Komisi Custom
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?= base_url('admin/riwayatkomisi/delete_custom/' . $komisi['id']) ?>" method="POST">
                                                    <div class="modal-body">
                                                        <?= csrf_field(); ?>
                                                        <p>Anda yakin ingin menghapus komisi custom untuk iklan <strong>#<?= $komisi['id_iklan'] ?></strong>?</p>
                                                        <div class="alert alert-warning mt-3 rounded-4">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            Penghapusan komisi custom tidak dapat dibatalkan.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                            <i class="fas fa-trash me-1"></i> Hapus
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

    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1) !important;
    }

    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.1) !important;
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

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    /* Card Styling */
    .card-body h6.card-title {
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }

    .list-group-item {
        border-left: 0;
        border-right: 0;
        padding: 0.75rem 0;
    }

    /* Modal Styling */
    .modal-content {
        border: none;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-footer {
        border-top: none;
    }

    /* Responsive Adjustments */
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

        .modal-body .row>div {
            margin-bottom: 1rem;
        }
    }

    /* Enhanced DataTables Styling dengan Spacing yang Lebih Baik */
    .dataTables_wrapper {
        padding: 0 1.5rem;
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
        // Initialize DataTables
        $('#defaultCommissionTable').DataTable({
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
        $('#customCommissionTable').DataTable({
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
                targets: [6] // Disable sorting for action column
            }],
            initComplete: function() {
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });

        // Filter functionality for default commissions
        $('#filter-peran-default').change(function() {
            var peran = $(this).val();
            var table = $('#defaultCommissionTable').DataTable();

            if (peran === 'all') {
                table.columns(1).search('').draw();
            } else {
                table.columns(1).search(peran).draw();
            }
        });

        // Filter functionality for custom commissions
        $('#filter-peran-custom').change(function() {
            var peran = $(this).val();
            var table = $('#customCommissionTable').DataTable();

            if (peran === 'all') {
                table.columns(2).search('').draw();
            } else {
                table.columns(2).search(peran).draw();
            }
        });

        $('#filter-tipe-custom').change(function() {
            var tipe = $(this).val();
            var table = $('#customCommissionTable').DataTable();

            if (tipe === 'all') {
                table.columns(1).search('').draw();
            } else {
                table.columns(1).search(tipe).draw();
            }
        });

        // Tooltip initialization
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Auto close alerts after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);

        // Format currency input
        $('input[name="jumlah_komisi"]').on('keyup', function() {
            var value = $(this).val().replace(/\D/g, '');
            $(this).val(formatRupiah(value));
        });

        function formatRupiah(angka) {
            if (!angka) return '';
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });
</script>
<?= $this->endSection(); ?>