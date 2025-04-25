<<?= $this->extend('user/template/template') ?>
<?= $this->Section('content'); ?>

    <!-- News With Sidebar Start -->
    <div class="container-fluid pt-5 mb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- News Detail Start -->
                    <div class="position-relative mb-3">
                        <img class="img-fluid w-100" src="<?= base_url('assets-baru') ?>/img/<?= $ebook->foto_ebook; ?>" style="object-fit: cover;">
                        <div class="bg-white border border-top-0 p-4">
                            <h1 class="mb-3 text-secondary text-uppercase font-weight-bold"><?= $ebook->nama_ebook; ?></h1>
                            <p><?= $ebook->sinopsis; ?></p>
                        </div>
                        <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                            <div class="d-flex align-items-center">
                                <span><?= $ebook->nama_penulis; ?></span>
                            </div>
                            <div class="d-flex align-items-center">
                                <a class="h7 m-0 text-black" href="<?= base_url('assets-baru') ?>/file/<?= $ebook->file_ebook; ?>" download>Download E-Book</a>
                            </div>
                        </div>
                    </div>
                    <!-- News Detail End -->
                </div>
                <div class="col-lg-4">
                        <div class="mb-3">
                            <div class="section-title mb-0">
                                <h4 class="m-0 text-uppercase font-weight-bold">Ebook Lainnya</h4>
                            </div>
                            <div class="bg-white border border-top-0 p-3">
                                <?php foreach ($ebook_lain as $ebook_item) : ?>
                                    <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                        <img class="img-fluid" style="width: 110px; height: 110px;" src="<?= base_url('assets-baru') ?>/img/<?= $ebook_item['foto_ebook']; ?>" alt="">
                                        <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                            <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="<?= base_url('/ebook/detail/' . $ebook_item['id_ebook']) ?>"><?= $ebook_item['nama_ebook']; ?></a>
                                            <div class="mb-2">
                                                <a class="text-body" href="<?= base_url('/ebook/detail/' . $ebook_item['id_ebook']) ?>"><?= substr($ebook_item['sinopsis'], 0, 30) ?>...</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->


<?= $this->endSection('content'); ?>