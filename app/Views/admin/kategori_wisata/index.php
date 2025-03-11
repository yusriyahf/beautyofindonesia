<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Kategori Wisata</h1>
            </div>
            </br>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= base_url('admin/kategori_wisata/tambah') ?>" class="btn btn-primary me-md-2"> + Tambah Kategori Wisata</a>
            </div>
        </div>
        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover table-bordered mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="text-center" valign="middle">No</th> <!-- Added column for row number -->
                                        
                                        <th class="text-center" valign="middle">Nama Kategori Wisata (in)</th>
                                        <th class="text-center" valign="middle">Nama Kategori Wisata (en)</th>
                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (count($all_data_kategori_wisata) > 0): ?>
                                        <?php $no = 1; ?> <!-- Initialize row number counter -->
                                        <?php foreach ($all_data_kategori_wisata as $kategori_wisata): ?>
                                            <tr>
                                                <td class="text-center" valign="middle"><?= esc($no++) ?></td> <!-- Display row number -->
                                                
                                                <td class="text-center" valign="middle"><?= esc($kategori_wisata->nama_kategori_wisata) ?></td>
                                                <td class="text-center" valign="middle"><?= esc($kategori_wisata->nama_kategori_wisata_en) ?></td>
                                                <td valign="middle">
                                                    <div class="text-center">
                                                        <a href="<?= base_url('admin/kategori_wisata/edit/' . $kategori_wisata->id_kategori_wisata) ?>" class="btn btn-warning">Ubah</a>
                                                        <a href="<?= base_url('admin/kategori_wisata/delete/' . $kategori_wisata->id_kategori_wisata) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori wisata ini?')">Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data kategori wisata</td> <!-- Adjusted colspan -->
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//tab-pane-->
        </div><!--//container-fluid-->
    </div><!--//app-content-->
</div><!--//app-wrapper-->

<?= $this->endSection('content') ?>
