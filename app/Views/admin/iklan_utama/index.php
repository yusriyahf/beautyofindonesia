<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Permintaan Tampil Iklan</h1>
                <p class="text-muted mb-0">Kelola semua permintaan artikel beriklan di sini</p>
            </div>
        </div>

        <!-- Notifikasi -->
        <div class="col-12">
            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>

        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <!-- Filter Section -->
                <div class="app-card app-card-settings shadow-sm p-4 mb-4">
                    <div class="app-card-body">
                        <form method="get" action="<?= base_url('admin/artikel_iklan') ?>">
                            <div class="row align-items-end">
                                <div class="col-md-3 mb-3">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control"
                                        value="<?= esc($_GET['start_date'] ?? '') ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                        value="<?= esc($_GET['end_date'] ?? '') ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="status" class="form-label">Status Iklan</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="diajukan" <?= (($_GET['status'] ?? '') == 'diajukan') ? 'selected' : '' ?>>Diajukan</option>
                                        <option value="diterima" <?= (($_GET['status'] ?? '') == 'diterima') ? 'selected' : '' ?>>Disetujui</option>
                                        <option value="ditolak" <?= (($_GET['status'] ?? '') == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                                        <option value="berjalan" <?= (($_GET['status'] ?? '') == 'berjalan') ? 'selected' : '' ?>>Berjalan</option>
                                        <option value="selesai" <?= (($_GET['status'] ?? '') == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 d-grid gap-2 d-md-flex">
                                    <button type="submit" class="btn app-btn-primary me-md-2">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                    <a href="<?= base_url('admin/artikel_iklan') ?>" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Data Table Section -->
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title">Daftar Artikel Beriklan</h4>
                            </div>
                            <div class="col-auto">
                                <div class="card-header-action">
                                    <span class="badge bg-success me-2">Total: <?= count($all_data_iklan_utama) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead class="atas">
                                    <tr>
                                        <th class="text-center" valign="middle">No</th>
                                        <th class="text-center" valign="middle">Jenis</th>
                                        <th class="text-center" valign="middle">Id Tipe Iklan Utama</th>
                                        <th class="text-center" valign="middle">Id Marketing</th>
                                        <th class="text-center" valign="middle">Rentang Bulan</th>
                                        <th class="text-center" valign="middle">Total Harga </th>
                                        <th class="text-center" valign="middle">Tgl Pengajuan</th>
                                        <th class="text-center" valign="middle">Tgl Mulai</th>
                                        <th class="text-center" valign="middle">Tgl Selesai</th>
                                        <th class="text-center" valign="middle">Status</th>

                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_iklan_utama as $iklan) : ?>
                                        <tr class="text-center">
                                            <td class="cell"><?= $i++ ?></td>
                                            <td class="cell"><?= esc($iklan['jenis'] ?? 'N/A') ?></td>
                                            <td class="cell"><?= esc($iklan['id_tipe_iklan_utama'] ?? 'N/A') ?></td>
                                            <td class="cell"><?= esc($iklan['id_marketing'] ?? 'N/A') ?></td>
                                            <td class="cell"><?= esc($iklan['rentang_bulan'] ?? 'N/A') ?> Bulan</td>
                                            <td class="cell"><?= esc($iklan['total_harga'] ?? 'N/A') ?> </td>

                                            <td class="cell">
                                                <?php if (!empty($iklan['tanggal_mulai'])) : ?>
                                                    <span class="badge bg-success"><?= date('d M Y', strtotime($iklan['tanggal_mulai'])) ?></span>
                                                <?php else : ?>
                                                    <span class="badge bg-secondary">Belum ditentukan</span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="cell">
                                                <?php if (!empty($iklan['tanggal_selesai'])) : ?>
                                                    <span class="badge bg-success"><?= date('d M Y', strtotime($iklan['tanggal_selesai'])) ?></span>
                                                <?php else : ?>
                                                    <span class="badge bg-secondary">Belum ditentukan</span>
                                                <?php endif; ?>
                                            </td>

                                            <?php
                                            $today = date('Y-m-d');
                                            $tanggalMulai = $iklan['tanggal_mulai'] ?? null;
                                            $tanggalSelesai = $iklan['tanggal_selesai'] ?? null;
                                            $statusIklan = $iklan['status'] ?? null;

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

                                            $badgeClass = match (strtolower($status)) {
                                                'diajukan' => 'bg-warning',
                                                'ditolak' => 'bg-danger',
                                                'diterima' => 'bg-primary',
                                                'berjalan' => 'bg-success',
                                                'selesai' => 'bg-secondary',
                                                default => 'bg-dark',
                                            };
                                            ?>

                                            <td class="cell"><?= esc($iklan['tanggal_pengajuan'] ?? 'N/A') ?> </td>
                                            <td class="cell">
                                                <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                                            </td>



                                            <td class="cell">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <?php if ($statusIklan == 'diajukan') : ?>
                                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accModal<?= $iklan['id_iklan_utama'] ?>">
                                                            <i class="bi bi-check-circle me-1"></i> Acc
                                                        </button>

                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal<?= $iklan['id_iklan_utama'] ?>">
                                                            <i class="bi bi-x-circle me-1"></i> Tolak
                                                        </button>
                                                    <?php else : ?>
                                                        <span class="text-muted">Tidak ada aksi</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Acc -->
                                        <div class="modal fade" id="accModal<?= $iklan['id_iklan_utama'] ?>" tabindex="-1" aria-labelledby="accModalLabel<?= $iklan['id_iklan_utama'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="<?= base_url('admin/iklanutama/ubahStatus') ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <?php $durasiBulan = isset($iklan['rentang_bulan']) ? (int)$iklan['rentang_bulan'] : 0; ?>

                                                        <!-- untuk pemasukan komisi -->
                                                        <input type="hidden" name="user_id" value="<?= $iklan['id_marketing'] ?>">
                                                        <input type="hidden" name="total_harga" value="<?= $iklan['total_harga'] ?>">

                                                        <input type="hidden" name="id_iklan_utama" value="<?= $iklan['id_iklan_utama'] ?>">
                                                        <input type="hidden" name="id_tipe_iklan_utama" value="<?= $iklan['id_tipe_iklan_utama'] ?>">
                                                        <input type="hidden" name="status" value="diterima">
                                                        <input type="hidden" name="durasi_bulan" value="<?= $durasiBulan ?>">

                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title" id="accModalLabel<?= $iklan['id_iklan_utama'] ?>">Konfirmasi Persetujuan</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>Anda akan menyetujui permintaan tampil iklan ini:</p>
                                                            <ul class="mb-3">
                                                                <li>Durasi: <strong><?= $durasiBulan ?> Bulan</strong></li>
                                                            </ul>

                                                            <div class="mb-3">
                                                                <label for="tanggalMulai_<?= $iklan['id_iklan_utama'] ?>" class="form-label">Tanggal Mulai:</label>
                                                                <input type="date" class="form-control tanggalMulai"
                                                                    id="tanggalMulai_<?= $iklan['id_iklan_utama'] ?>"
                                                                    name="tanggal_mulai"
                                                                    min="<?= date('Y-m-d') ?>"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="tanggalSelesai_<?= $iklan['id_iklan_utama'] ?>" class="form-label">Tanggal Selesai:</label>
                                                                <input type="text" class="form-control tanggalSelesai"
                                                                    id="tanggalSelesai_<?= $iklan['id_iklan_utama'] ?>"
                                                                    name="tanggal_selesai"
                                                                    readonly>
                                                            </div>

                                                            <p class="text-muted">Pastikan tanggal sudah benar sebelum menyetujui.</p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="bi bi-check-circle me-1"></i> Setujui
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const tanggalMulaiInput = document.getElementById('tanggalMulai_<?= $iklan['id_iklan_utama'] ?>');
                                                const tanggalSelesaiInput = document.getElementById('tanggalSelesai_<?= $iklan['id_iklan_utama'] ?>');
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
                                        <div class="modal fade" id="tolakModal<?= $iklan['id_iklan_utama'] ?>" tabindex="-1" aria-labelledby="tolakModalLabel<?= $iklan['id_iklan_utama'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="<?= base_url('admin/artikeliklan/ubahStatus') ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id" value="<?= $iklan['id_iklan_utama'] ?>">


                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="tolakModalLabel<?= $iklan['id_iklan_utama'] ?>">Konfirmasi Penolakan</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>Anda akan menolak permintaan tampil iklan ini:</p>
                                                            <ul class="mb-3">

                                                            </ul>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="bi bi-x-circle me-1"></i> Tolak
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

                    <div class="app-card-footer p-3">
                        <!-- Pagination bisa ditambahkan di sini jika diperlukan -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->endSection('content') ?>