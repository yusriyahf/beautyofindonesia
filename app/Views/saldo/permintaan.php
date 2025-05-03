<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Permintaan Penarikan Saldo</h1>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title">Riwayat Saldo</h4>
                            </div>
                            <div class="col-auto">
                                <div class="card-header-action">
                                    <div class="mb-3 d-flex">
                                        <select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
                                            <option value="all" selected>All</option>
                                            <option value="income">Pemasukan</option>
                                            <option value="expense">Pengeluaran</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="app-card-body p-3 p-lg-4">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Username</th>
                                        <th class="cell">Role</th>
                                        <th class="cell">Total</th>
                                        <th class="cell">Status</th>
                                        <th class="cell">Tgl Pengajuan</th>
                                        <th class="cell">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_penarikan_saldo as $saldo) : ?>
                                        <tr>
                                            <td class="cell"><?= esc($saldo['username']) ?></td>
                                            <td class="cell"><?= esc($saldo['role']) ?></td>
                                            <td class="cell">Rp <?= esc(number_format($saldo['jumlah'], 2, ',', '.')) ?></td>

                                            <?php
                                            $status = $saldo['status'];
                                            $badgeClass = 'bg-secondary'; // default

                                            if ($status === 'diproses') {
                                                $badgeClass = 'bg-warning';
                                            } elseif ($status === 'disetujui') {
                                                $badgeClass = 'bg-success';
                                            } elseif ($status === 'ditolak') {
                                                $badgeClass = 'bg-danger';
                                            }
                                            ?>

                                            <td class="cell"><span class="badge <?= $badgeClass ?>"><?= esc($saldo['status']) ?></span></td>
                                            <td class="cell"><?= esc(date('d-m-Y H:i', strtotime($saldo['tanggal_pengajuan']))) ?></td>

                                            <td class="cell">
                                                <?php if ($status == 'diproses') : ?>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#accModal<?= $saldo['id_penarikan_komisi'] ?>">
                                                        <i class="bi bi-check-circle me-1"></i> Acc
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal<?= $saldo['id_penarikan_komisi'] ?>">
                                                        <i class="bi bi-x-circle me-1"></i> Tolak
                                                    </button>
                                                <?php else : ?>
                                                    <span class="text-muted">Tidak ada aksi</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <!-- Modal Acc -->
                                        <div class="modal fade" id="accModal<?= $saldo['id_penarikan_komisi'] ?>" tabindex="-1" aria-labelledby="accModalLabel<?= $saldo['id_penarikan_komisi'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="<?= base_url('admin/saldo/ubahstatus') ?>" method="post">
                                                        <?= csrf_field() ?>

                                                        <input type="hidden" name="id_penarikan_komisi" value="<?= $saldo['id_penarikan_komisi'] ?>">
                                                        <input type="hidden" name="status_iklan" value="diterima">

                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title" id="accModalLabel<?= $saldo['id_penarikan_komisi'] ?>">Konfirmasi Persetujuan</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>Anda akan menyetujui permintaan penarikan saldo ini:</p>
                                                            <ul class="mb-3">
                                                                <li>Nama pengaju: <strong><?= esc($saldo['username']) ?></strong></li>
                                                                <li>Role: <strong><?= esc($saldo['role']) ?></strong></li>
                                                                <li>Jumlah Penarikan: <strong><?= esc($saldo['jumlah']) ?></strong></li>
                                                            </ul>
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

                                        <!-- Modal Tolak -->
                                        <div class="modal fade" id="tolakModal<?= $saldo['id_penarikan_komisi'] ?>" tabindex="-1" aria-labelledby="tolakModalLabel<?= $saldo['id_penarikan_komisi'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="<?= base_url('admin/saldo/ubahstatus') ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id_penarikan_komisi" value="<?= $saldo['id_penarikan_komisi'] ?>">


                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="tolakModalLabel<?= $saldo['id_penarikan_komisi'] ?>">Konfirmasi Penolakan</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>Anda akan menolak permintaan tampil iklan ini:</p>
                                                            <ul class="mb-3">
                                                                <li>Nama pengaju: <strong><?= esc($saldo['user_id']) ?></strong></li>
                                                                <li>Jumlah Penarikan: <strong><?= esc($saldo['jumlah']) ?></strong></li>
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
                    <div class="app-card-footer p-4 mt-auto">
                        <nav class="app-pagination">
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
    </div>
</div><!--//app-content-->

<?= $this->endSection('content') ?>