<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">List of Saldo</h1>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <!-- Income Card -->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Total Masuk</h4>
                        <div class="stats-figure">Rp <?= number_format($saldo['total_masuk'], 2) ?></div>
                        <div class="stats-meta text-success">
                            <i class="fa fa-arrow-up"></i> 20.5%
                        </div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                </div>
            </div>

            <!-- Expense Card -->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Total Keluar</h4>
                        <div class="stats-figure">Rp <?= number_format($saldo['total_keluar'], 2) ?></div>
                        <div class="stats-meta text-danger">
                            <i class="fa fa-arrow-down"></i> 5.2%
                        </div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                </div>
            </div>

            <!-- Net Balance Card -->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-stat shadow-sm h-100">
                    <div class="app-card-body p-3 p-lg-4">
                        <h4 class="stats-type mb-1">Saldo</h4>
                        <div class="stats-figure">Rp <?= number_format($saldo['saldo'], 2) ?></div>
                        <div class="stats-meta text-success">
                            <i class="fa fa-check-circle"></i> Positive
                        </div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                </div>
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
                                        <a class="btn app-btn-primary ms-2" href="<?= base_url('admin/saldo/penarikan'); ?>">
                                            <i class="fa fa-plus"></i> Tarik Saldo
                                        </a>
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
                                        <th class="cell">Total</th>
                                        <th class="cell">Tipe</th>
                                        <th class="cell">Status</th>
                                        <th class="cell">Tgl Pengajuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($semua_transaksi as $transaksi) : ?>
                                        <tr>
                                            <td class="cell">Rp <?= esc(number_format($transaksi['jumlah'], 2, ',', '.')) ?></td>
                                            <td class="cell"><span class="badge bg-success"><?= esc($transaksi['tipe']) ?></span></td>

                                            <?php
                                            $status = $transaksi['status'];
                                            $badgeClass = 'bg-secondary'; // default

                                            if ($status === 'diproses') {
                                                $badgeClass = 'bg-warning';
                                            } elseif ($status === 'disetujui') {
                                                $badgeClass = 'bg-success';
                                            } elseif ($status === 'ditolak') {
                                                $badgeClass = 'bg-danger';
                                            }
                                            ?>

                                            <td class="cell"><span class="badge <?= $badgeClass ?>"><?= esc($transaksi['status']) ?></span></td>
                                            <td class="cell"><?= esc(date('d-m-Y H:i', strtotime($transaksi['tanggal']))) ?></td>

                                        </tr>
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