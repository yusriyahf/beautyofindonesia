<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Kategori Oleh-Oleh</h1>
            </div>
            <br>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= base_url('admin/kategori_oleholeh/tambah') ?>" class="btn btn-primary me-md-2">+ Tambah Kategori Oleh-Oleh</a>
            </div>
        </div>

        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <!-- Tampilkan pesan sukses -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Tampilkan tabel data -->
                        <div class="table-responsive">
                            <table class="table app-table-hover table-bordered mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="text-center" valign="middle">No</th> <!-- Added column for row number -->
                                        
                                        <th class="text-center" valign="middle">Nama Kategori Oleh-Oleh (in)</th>
                                        <th class="text-center" valign="middle">Nama Kategori Oleh-Oleh (en)</th>
                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($all_data_kategori_oleholeh) > 0): ?>
                                        <?php $no = 1; ?> <!-- Initialize row number counter -->
                                        <?php foreach ($all_data_kategori_oleholeh as $kategori): ?>
                                            <tr>
                                                <td class="text-center" valign="middle"><?= esc($no++) ?></td> <!-- Display row number -->
                                                
                                                <td class="text-center" valign="middle"><?= esc($kategori->nama_kategori_oleholeh) ?></td>
                                                <td class="text-center" valign="middle"><?= esc($kategori->nama_kategori_oleholeh_en) ?></td>
                                                <td valign="middle">
                                                    <div class="text-center">
                                                        <a href="<?= base_url('admin/kategori_oleholeh/edit/' . $kategori->id_kategori_oleholeh) ?>" class="btn btn-warning">Edit</a>
                                                        <a href="<?= base_url('admin/kategori_oleholeh/delete/' . $kategori->id_kategori_oleholeh) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data kategori oleh-oleh</td>
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

<?= $this->endSection('content'); ?>
