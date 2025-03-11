<<?= $this->extend('user/template/template') ?>
<?= $this->Section('content'); ?>

    <!-- News With Sidebar Start -->
    <div class="container-fluid pt-5 mb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- News Detail Start -->
                    <div class="position-relative mb-3">
                        <img class="img-fluid w-100" src="<?= base_url('assets-baru') ?>/img/<?= $penulis->foto_penulis; ?>" style="object-fit: cover;">
                        <div class="bg-white border border-top-0 p-4">
                            <h1 class="mb-3 text-secondary text-uppercase font-weight-bold"><?= $penulis->nama_penulis; ?></h1>
                            <p><?= $penulis->deskripsi_penulis; ?></p>
                        </div>
                        <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                        </div>
                    </div>
                    <!-- News Detail End -->
                </div>
                <div class="col-lg-4">
                        <div class="mb-3">
                                <div class="section-title mb-0">
                                    <h4 class="m-0 text-uppercase font-weight-bold">Artikel Penulis</h4>
                                </div>
                                <div class="bg-white border border-top-0 p-3">
                                <?php if (!empty($artikel)) : ?>
                                <?php foreach ($artikel as $artikel_item) : ?>
                                    <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                        <img class="img-fluid" style="width: 110px; height: 110px;" src="<?= base_url('assets-baru') ?>/img/<?= $artikel_item['foto_artikel']; ?>" alt="">
                                        <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                            <div class="mb-2">
                                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="<?= base_url('kategori/' . $artikel_item['id_kategori']) ?>"><?= $artikel_item['nama_kategori']; ?></a>
                                                <a class="text-body" href="<?= base_url('/artikel/detail/' . $artikel_item['id_artikel'] . '/' . $artikel_item['slug']) ?>"><small><?= date('d F Y', strtotime($artikel_item['created_at']));  ?></small></a>
                                            </div>
                                            <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="<?= base_url('/artikel/detail/' . $artikel_item['id_artikel'] . '/' . $artikel_item['slug']) ?>"><?= $artikel_item['judul_artikel']; ?></a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php else : ?>
                                    <p>Tidak ada artikel terkait.</p>
                                <?php endif; ?>
                                <a class="m-0 text-uppercase text-center" href="<?= base_url('/penulis/artikel_penulis/' . $penulis->id_penulis) ?>">Lihat Semua</a>
                                </div>
                        </div>
                        <div class="mb-3">
                            <div class="section-title mb-0">
                                <h4 class="m-0 text-uppercase font-weight-bold">Penulis Lainnya</h4>
                            </div>
                            <div class="bg-white border border-top-0 p-3">
                                <?php foreach ($penulis_lain as $penulis_item) : ?>
                                    <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                        <img class="img-fluid" style="width: 110px; height: 110px;" src="<?= base_url('assets-baru') ?>/img/<?= $penulis_item['foto_penulis']; ?>" alt="">
                                        <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                            <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="<?= base_url('/penulis/detail/' . $penulis_item['id_penulis']) ?>"><?= $penulis_item['nama_penulis']; ?></a>
                                            <div class="mb-2">
                                                <a class="text-body" href="<?= base_url('/penulis/detail/' . $penulis_item['id_penulis']) ?>"><?= substr($penulis_item['deskripsi_penulis'], 0, 30) ?>...</a>
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