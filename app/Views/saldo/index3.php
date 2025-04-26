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
                        <div class="stats-figure">Rp 8,250,000</div>
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
                        <div class="stats-figure">Rp 3,450,000</div>
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
                        <div class="stats-figure">Rp 4,800,000</div>
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
                                        <a class="btn app-btn-primary ms-2" href="#">
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
                                        <th class="cell">Nama</th>
                                        <th class="cell">Tanggal</th>
                                        <!-- <th class="cell">Deskripsi</th> -->
                                        <th class="cell">Tipe</th>
                                        <th class="cell">Total</th>
                                        <th class="cell">Status</th>
                                        <th class="cell">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="cell">marketer88</td>
                                        <td class="cell">22 Apr, 2025</td>
                                        <!-- <td class="cell">pasang iklan pinggir</td> -->
                                        <td class="cell"><span class="badge bg-success">Pemasukan</span></td>
                                        <td class="cell">Rp 1,500,000</td>
                                        <td class="cell"><span class="badge bg-success">Selesai</span></td>
                                        <td class="cell">
                                            <a class="btn-sm app-btn-secondary" href="#">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cell">marketer88</td>
                                        <td class="cell">21 Apr, 2025</td>
                                        <!-- <td class="cell">pasang iklan pinggir</td> -->
                                        <td class="cell"><span class="badge bg-danger">Pengeluaran</span></td>
                                        <td class="cell">Rp 750,000</td>
                                        <td class="cell"><span class="badge bg-success">Selesai</span></td>
                                        <td class="cell">
                                            <a class="btn-sm app-btn-secondary" href="#">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cell">marketer88</td>
                                        <td class="cell">21 Apr, 2025</td>
                                        <!-- <td class="cell">pasang iklan pinggir</td> -->
                                        <td class="cell"><span class="badge bg-success">Pemasukan</span></td>
                                        <td class="cell">Rp 2,300,000</td>
                                        <td class="cell"><span class="badge bg-success">Selesai</span></td>
                                        <td class="cell">
                                            <a class="btn-sm app-btn-secondary" href="#">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cell">marketer88</td>
                                        <td class="cell">21 Apr, 2025</td>
                                        <!-- <td class="cell">pasang iklan pinggir</td> -->
                                        <td class="cell"><span class="badge bg-danger">Pengeluaran</span></td>
                                        <td class="cell">Rp 450,000</td>
                                        <td class="cell"><span class="badge bg-warning">Menunggu</span></td>
                                        <td class="cell">
                                            <a class="btn-sm app-btn-secondary" href="#">View</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cell">marketer88</td>
                                        <td class="cell">18 Apr, 2025</td>
                                        <!-- <td class="cell">pasang iklan pinggir</td> -->
                                        <td class="cell"><span class="badge bg-success">Pemasukan</span></td>
                                        <td class="cell">Rp 3,200,000</td>
                                        <td class="cell"><span class="badge bg-success">Selesai</span></td>
                                        <td class="cell">
                                            <a class="btn-sm app-btn-secondary" href="#">View</a>
                                        </td>
                                    </tr>
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