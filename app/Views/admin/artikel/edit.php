<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Artikel</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/artikel/proses_edit/' . $artikelData->id_artikel) ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Judul Artikel</label>
                                        <input type="text" class="form-control" id="judul_artikel" name="judul_artikel" value="<?= $artikelData->judul_artikel; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Judul Artikel (English)</label>
                                        <input type="text" class="form-control" id="judul_artikel_en" name="judul_artikel_en" value="<?= $artikelData->judul_artikel_en; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_artikel" class="form-label">Deskripsi Artikel</label>
                                        <textarea class="form-control tiny" id="deskripsi_artikel" name="deskripsi_artikel"><?= $artikelData->deskripsi_artikel; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_artikel_en" class="form-label">Deskripsi Artikel (English)</label>
                                        <textarea class="form-control tiny" id="deskripsi_artikel_en" name="deskripsi_artikel_en"><?= $artikelData->deskripsi_artikel_en; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tags</label>
                                        <input type="text" class="form-control" id="tags" name="tags" value="<?= $artikelData->tags; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tags (English)</label>
                                        <input type="text" class="form-control" id="tags_en" name="tags_en" value="<?= $artikelData->tags_en; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Meta Title (ID)</label>
                                        <input type="text" class="form-control" id="meta_title_id" name="meta_title_id" value="<?= $artikelData->meta_title_id ?? ''; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Meta Title (EN)</label>
                                        <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" value="<?= $artikelData->meta_title_en ?? ''; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Meta Deskripsi (ID)</label>
                                        <input type="text" class="form-control" id="meta_description_id" name="meta_description_id" value="<?= $artikelData->meta_description_id ?? ''; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Meta Deskripsi (EN)</label>
                                        <input type="text" class="form-control" id="meta_description_en" name="meta_description_en" value="<?= $artikelData->meta_description_en ?? ''; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Publish</label>
                                        <input type="date" class="form-control" id="tgl_publish" name="tgl_publish" value="<?= old('tgl_publish') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Foto Artikel</label>
                                        <input type="file" class="form-control" id="foto_artikel" name="foto_artikel">
                                        <img width="150px" class="img-thumbnail" src="<?= base_url("assets-baru/img/" . $artikelData->foto_artikel); ?>">
                                        <?= $validation->getError('foto_artikel') ?>
                                    </div>
                                    <p>*Ukuran foto minimal 572x572 pixels</p>
                                    <p>*Foto harus berekstensi jpg/png/jpeg</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
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
