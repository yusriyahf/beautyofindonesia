<?= $this->extend('user/template/template') ?>
<?= $this->Section('content'); ?>

<div class="container-fluid pt-5 mb-3">
    <div class="container">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">Penulis</h4>
        </div>
        <div class="row">
            <?php foreach ($penulis as $row) : ?>
                <div class="col-md-4 penulis-item mb-4">
                    <div class="position-relative overflow-hidden" style="height: 400px;">
                        <img class="img-fluid" src="<?= base_url('assets-baru') ?>/img/<?= $row->foto_penulis; ?>" style="object-fit: cover;">
                        <div class="overlay">
                            <div class="mb-2">
                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                    href="<?= base_url('/penulis/detail/' . $row->id_penulis); ?>"><?= substr($row->nama_penulis, 0, 22) ?></a>
                            </div>
                            <a class="h7 m-0 text-white" href="<?= base_url('/penulis/detail/' . $row->id_penulis); ?>"><?= substr($row->deskripsi_penulis, 0, 17) ?>...</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection('content') ?>
