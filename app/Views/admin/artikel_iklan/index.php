<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Daftar Tampil Iklan</h1>
            </div>
        </div>

        <div class="col">
            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="tab-content" id="orders-table-tab-content">
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead class="atas">
                                    <tr>
                                        <th class="text-center" valign="middle">No</th>
                                        <th class="text-center" valign="middle">Artikel</th>
                                        <th class="text-center" valign="middle">Iklan</th>
                                        <th class="text-center" valign="middle">User</th>
                                        <th class="text-center" valign="middle">Tgl Mulai</th>
                                        <th class="text-center" valign="middle">Tgl Selesai</th>
                                        <th class="text-center" valign="middle">Status</th>
                                        <th class="text-center" valign="middle">Kontak</th>
                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_artikeliklan as $artikelIklan) : ?>
                                        <tr>
                                            <td class="text-center" valign="middle"><?= $i++ ?></td>
                                            <td class="text-center" valign="middle"><?= isset($artikelIklan['judul_artikel']) ? $artikelIklan['judul_artikel'] : 'Nama Popup Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($artikelIklan['nama_iklan']) ? $artikelIklan['nama_iklan'] : 'Nama Popup Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($artikelIklan['username']) ? $artikelIklan['username'] : 'Link Popup Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($artikelIklan['tanggal_mulai']) ? $artikelIklan['tanggal_mulai'] : 'Nama Tombol Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($artikelIklan['tanggal_selesai']) ? $artikelIklan['tanggal_selesai'] : 'Nama Tombol Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><?= isset($artikelIklan['status']) ? $artikelIklan['status'] : 'Nama Tombol Tidak Tersedia' ?></td>

                                            <td class="text-center" valign="middle"><a href="https://wa.me/<?= isset($artikelIklan['kontak']) ? $artikelIklan['kontak'] : 'Nama Tombol Tidak Tersedia' ?>" target="_blank">
                                                    Whatsapp
                                                </a>
                                            </td>

                                            <td valign="middle">
                                                <div class="d-grid gap-2">

                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#accModal<?= $artikelIklan['id'] ?>">
                                                        Acc
                                                    </button>

                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal<?= $artikelIklan['id'] ?>">
                                                        Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Acc-->
                                        <div class="modal fade" id="accModal<?= $artikelIklan['id'] ?>" tabindex="-1" aria-labelledby="accModalLabel<?= $artikelIklan['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="<?= base_url('admin/artikeliklan/ubahStatus') ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id" value="<?= $artikelIklan['id'] ?>">
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <input type="hidden" name="nama_iklan" value="<?= $artikelIklan['nama_iklan'] ?>">
                                                        <input type="hidden" name="id_artikel" value="<?= $artikelIklan['id_artikel'] ?>">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="accModalLabel<?= $artikelIklan['id'] ?>">Konfirmasi Acc</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin acc data ini?
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success text-white">Acc</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Modal Tolak-->
                                        <div class="modal fade" id="tolakModal<?= $artikelIklan['id'] ?>" tabindex="-1" aria-labelledby="tolakModalLabel<?= $artikelIklan['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="<?= base_url('admin/artikeliklan/ubahStatus') ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id" value="<?= $artikelIklan['id'] ?>">
                                                        <input type="hidden" name="status" value="ditolak">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tolakModalLabel<?= $artikelIklan['id'] ?>">Konfirmasi Tolak</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin tolak data ini?
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger text-white">Tolak</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//tab-pane-->
        </div><!--//tab-content-->
    </div><!--//container-xl-->
</div><!--//app-content-->

<?= $this->endSection('content') ?>