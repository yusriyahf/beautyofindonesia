<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Artikel Beriklan</h1>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= base_url('admin/artikel/tambah_artikel_iklan') ?>" class="btn btn-primary me-md-2">+ Tambah Data</a>
            </div>
        </div>

        <!-- Date Filter Form -->
        <form method="get" action="<?= base_url('admin/artikel_iklan') ?>" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?= esc($_GET['start_date'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?= esc($_GET['end_date'] ?? '') ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2">Filter</button>
                    <a href="<?= base_url('admin/tambah_artikel_iklan') ?>" class="btn btn-secondary w-100">Tampilkan Semua</a>
                </div>
            </div>
        </form>

        <div class="tab-content" id="artikel-iklan-tab-content">
            <div class="tab-pane fade show active" id="artikel-iklan-all" role="tabpanel">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Judul Artikel</th>
                                        <th class="text-center">Tipe Iklan</th>
                                        <th class="text-center">ID Penulis</th>
                                        <th class="text-center">Rentang Bulan</th>
                                        <th class="text-center">Total Harga</th>
                                        <th class="text-center">Status Iklan</th>
                                        <th class="text-center">Tanggal Mulai</th>
                                        <th class="text-center">Tanggal Selesai</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $startDate = $_GET['start_date'] ?? null;
                                    $endDate = $_GET['end_date'] ?? null;

                                    $i = 1;

                                    if (!empty($all_data) && is_array($all_data)) {
                                        foreach ($all_data as $item):
                                            $tanggalMulai = $item['tanggal_mulai'];

                                            if (
                                                ($startDate && $tanggalMulai < $startDate) ||
                                                ($endDate && $tanggalMulai > $endDate)
                                            ) continue;
                                    ?>
                                            <tr>
                                                <td class="text-center"><?= $i++ ?></td>
                                                <td class="text-center"><?= esc($item['judul_artikel']) ?></td> 
                                                <td class="text-center"><?= esc($item['id_harga_iklan']) ?></td>
                                                <td class="text-center"><?= esc($item['id_marketing']) ?></td>
                                                <td class="text-center"><?= esc($item['rentang_bulan']) ?> Bulan</td>
                                                <td class="text-center"><?= esc($item['total_harga']) ?></td>
                                                <td class="text-center"><?= esc($item['status_iklan']) ?></td>
                                                <td class="text-center"><?= esc($item['tanggal_mulai']) ?></td>
                                                <td class="text-center"><?= esc($item['tanggal_selesai']) ?></td>
                                                <td class="text-center">
                                                    <div class="d-grid gap-2">
                                                        <a href="<?= base_url('admin/artikel_iklan/edit/' . $item['id_iklan']) ?>" class="btn btn-primary">Ubah</a>
                                                        <a href="<?= base_url('admin/artikel_iklan/delete/' . $item['id_iklan']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data yang tersedia.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//tab-pane-->
        </div><!--//tab-content-->
    </div><!--//container-xl-->
</div><!--//app-content-->

<?= $this->endSection('content'); ?>
