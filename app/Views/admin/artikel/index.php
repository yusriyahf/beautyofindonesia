<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Artikel</h1>
            </div>
            <div class="col-auto">
                <a href="<?= base_url("admin/artikel/tambah") ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Artikel
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="app-card app-card-settings shadow-sm p-4 mb-4">
            <div class="app-card-body">
                <form method="get" action="<?= base_url('admin/artikel') ?>">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
                        </div>
                        <div class="col-md-4 mb-3 d-flex">
                            <button type="submit" class="btn btn-primary me-2 flex-grow-1">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="<?= base_url('admin/artikel/index') ?>" class="btn btn-outline-secondary flex-grow-1">
                                <i class="fas fa-sync-alt me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Articles Table -->
        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body">
                <div class="table-responsive">
                    <?php if (empty($all_data_artikel)): ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i> Tidak ada artikel ditemukan
                        </div>
                    <?php else: ?>
                        <table class="table app-table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th>Judul Artikel</th>
                                    <th>Judul (English)</th>
                                    <th class="text-center" width="12%">Kategori</th>
                                    <th class="text-center" width="12%">Penulis</th>
                                    <th class="text-center" width="12%">Tanggal</th>
                                    <th class="text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Get the current page number
                                $page = $pager->getCurrentPage('artikel');  // Get the current page for 'artikel' pagination
                                $offset = ($page - 1) * 10; // Calculate the offset for the current page

                                $i = $offset + 1; // Start the numbering from the correct offset
                                foreach ($all_data_artikel as $tampilArtikel):
                                    // Filter by date (as you have done)
                                    $startDate = $_GET['start_date'] ?? null;
                                    $endDate = $_GET['end_date'] ?? null;
                                    $tglPublish = $tampilArtikel['tgl_publish'];

                                    if (($startDate && $tglPublish < $startDate) || ($endDate && $tglPublish > $endDate)) {
                                        continue;
                                    }
                                ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $i++ ?></td>
                                        <td class="align-middle">
                                            <?= $tampilArtikel['judul_artikel'] ?? 'Judul Tidak Tersedia' ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= $tampilArtikel['judul_artikel_en'] ?? 'Judul Tidak Tersedia' ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-info">
                                                <?= $tampilArtikel['nama_kategori'] ?? 'Kategori Tidak Tersedia' ?>
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?= $tampilArtikel['nama_penulis'] ?? 'Penulis Tidak Tersedia' ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <?= date('d M Y', strtotime($tglPublish)) ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?= base_url('admin/artikel/viewArtikel/' . $tampilArtikel['id_artikel'] . '/' . $tampilArtikel['slug']) ?>"
                                                    class="btn btn-sm btn-info" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/artikel/edit/' . $tampilArtikel['id_artikel']) ?>"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/artikel/delete/' . $tampilArtikel['id_artikel']) ?>"
                                                    class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <?= $pager->links('artikel', 'bootstrap_full') ?>
        </div>

    </div>
</div>

<?= $this->endSection('content') ?>