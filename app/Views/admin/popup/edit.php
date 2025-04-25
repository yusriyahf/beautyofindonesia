<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Tampil Popup</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/popup/proses_edit/' . $popup->id_popup) ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Popup</label>
                                        <input type="text" class="form-control" id="nama_popup" name="nama_popup" value="<?= $popup->nama_popup; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Title Popup</label>
                                        <textarea class="form-control" id="title_popup" name="title_popup" rows="3" required><?= $popup->title_popup; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Link Popup</label>
                                        <input type="text" class="form-control" id="link_popup" name="link_popup" value="<?= $popup->link_popup; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Tombol</label>
                                        <input type="text" class="form-control" id="nama_tombol" name="nama_tombol" value="<?= $popup->nama_tombol; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Foto Popup</label>
                                        <input type="file" class="form-control" id="foto_popup" name="foto_popup">
                                        <img width="150px" class="img-thumbnail" src="<?= base_url("uploads/popups/" . $popup->foto_popup); ?>">
                                        <?= $validation->getError('foto_popup') ?>
                                    </div>
                                    <p>*Ukuran foto minimal 572x572 pixels</p>
                                    <p>*Foto harus berekstensi jpg/png/jpeg</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex gap-2">
                                    <a href="<?= base_url('admin/popup') ?>" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>

                                </div>
                                <div class="col">
                                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <?= session()->getFlashdata('success') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-4">
    </div>
</div>

<?= $this->endSection('content') ?>