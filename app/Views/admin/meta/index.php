<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>


<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Data Meta</h1>
            </div>
            </br>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?php echo base_url() . "admin/meta/tambah" ?>" class="btn btn-primary me-md-2"> + Tambah Meta</a>
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
                                        <th class="text-center" valign="middle">No</th>
                                        <th class="text-center" valign="middle">Nama Halaman</th>
                                        <th class="text-center" valign="middle">Meta Title (ID)</th>
                                        <th class="text-center" valign="middle">Meta Description (ID)</th>
                                        <th class="text-center" valign="middle">Meta Title (EN)</th>
                                        <th class="text-center" valign="middle">Meta Description (EN)</th>

                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($all_data_meta as $tampilMeta) : ?>
                                        <tr>
                                            <td class="text-center" valign="middle"><?php echo $i; ?></td>
                                            <td class="text-center" valign="middle"><?= $tampilMeta->nama_halaman ?></td>
                                            <td class="text-center" valign="middle"><?= $tampilMeta->meta_title_id ?></td>
                                            <td class="text-center" valign="middle"><?= $tampilMeta->meta_description_id ?></td>
                                            <td class="text-center" valign="middle"><?= $tampilMeta->meta_title_en ?></td>
                                            <td class="text-center" valign="middle"><?= $tampilMeta->meta_description_en ?></td>
                                            <td valign="middle">
                                                <div class="text-center">
                                                    <a href="<?= base_url('admin/meta/delete') . '/' . $tampilMeta->id_seo ?>" class="btn btn-danger">Hapus</a>
                                                    <a href="<?= base_url('admin/meta/edit') . '/' . $tampilMeta->id_seo ?>" class="btn btn-primary">Ubah</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
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