<?= $this->extend('user/template/template') ?>
<?= $this->Section('content'); ?>
   
    <!-- <div class="container-fluid pt-5 mb-3">
        <div class="container">
            <div class="section-title">
                <h4 class="m-0 text-uppercase font-weight-bold">Ebook</h4>
            </div>
            <div class="penulis-container">
                <?php foreach ($ebook as $row) : ?>
                    <div class="penulis-item">
                        <div class="position-relative overflow-hidden" style="height: 300px;">
                            <img class="img-fluid h-100" src="<?= base_url('assets-baru') ?>/img/<?= $row->foto_ebook; ?>" style="object-fit: cover;">
                            <div class="overlay">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                        href="<?= base_url('/ebook/detail/' . $row->id_ebook); ?>"><?= substr($row->nama_penulis, 0, 22) ?></a>
                                </div>
                                <a class="h7 m-0 text-white" href="<?= base_url('/ebook/detail/' . $row->id_ebook); ?>"><?= $row->nama_ebook; ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div> -->

    <div class="container-fluid mt-5 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h4 class="m-0 text-uppercase font-weight-bold">Ebook</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($ebook as $row) : ?>
                    <div class="col-lg-4">
                        <div class="position-relative mb-3">
                            <img class="img-fluid w-100" style="object-fit: cover;" src="<?= base_url('assets-baru') ?>/img/<?= $row->foto_ebook; ?>" loading="lazy">
                            <div class="bg-white border border-top-0 p-4">
                                <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="<?= base_url('/ebook/detail/' . $row->id_ebook) ?>"><?= $row->nama_ebook; ?></a>
                                <p><?= substr($row->sinopsis, 0, 30) ?>...</p>
                            </div>
                            <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                <div class="d-flex align-items-center">
                                    <small><?= $row->nama_penulis; ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?= $this->endSection('content') ?>