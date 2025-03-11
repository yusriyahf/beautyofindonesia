<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambahkan Artikel</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/artikel/proses_tambah') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="kategori">Kategori</label>
                                        <select class="form-control" name="id_kategori" id="id_kategori">
                                            <?php foreach ($all_data_kategori as $kategori) : ?>
                                                <option value="<?= $kategori->id_kategori; ?>"><?= $kategori->nama_kategori; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="penulis">Penulis</label>
                                        <select class="form-control" name="id_penulis" id="id_penulis">
                                            <?php foreach ($all_data_penulis as $penulis) : ?>
                                                <option value="<?= $penulis->id_penulis; ?>"><?= $penulis->nama_penulis; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Judul Artikel</label>
                                        <input type="text" class="form-control" id="judul_artikel" name="judul_artikel" value="<?= old('judul_artikel') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Judul Artikel (English)</label>
                                        <input type="text" class="form-control" id="judul_artikel_en" name="judul_artikel_en" value="<?= old('judul_artikel_en') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sumber Foto</label>
                                        <input type="text" class="form-control" id="sumber_foto" name="sumber_foto" value="<?= old('sumber_foto') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_artikel" class="form-label">Deskripsi Artikel</label>
                                        <textarea class="form-control tiny" id="deskripsi_artikel" name="deskripsi_artikel"><?= old('deskripsi_artikel') ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_artikel_en" class="form-label">Deskripsi Artikel (English)</label>
                                        <textarea class="form-control tiny" id="deskripsi_artikel_en" name="deskripsi_artikel_en"><?= old('deskripsi_artikel_en') ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tags</label>
                                        <input type="text" class="form-control" id="tags" name="tags" value="<?= old('tags') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tags (English)</label>
                                        <input type="text" class="form-control" id="tags_en" name="tags_en" value="<?= old('tags_en') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Meta Title (ID)</label>
                                        <input type="text" class="form-control" id="meta_title_id" name="meta_title_id" value="<?= old('meta_title_id') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Meta Title (EN)</label>
                                        <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" value="<?= old('meta_title_en') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Meta Deskripsi (ID)</label>
                                        <input type="text" class="form-control" id="meta_deskription_id" name="meta_deskription_id" value="<?= old('meta_deskription_id') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Meta Deskripsi (EN)</label>
                                        <input type="text" class="form-control" id="meta_description_en" name="meta_description_en" value="<?= old('meta_description_en') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Publish</label>
                                        <input type="date" class="form-control" id="tgl_publish" name="tgl_publish" value="<?= old('tgl_publish') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Foto Artikel</label>
                                        <input class="form-control <?= ($validation->hasError('foto_artikel')) ? 'is-invalid' : '' ?>" type="file" id="foto_artikel" name="foto_artikel">
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

                </div><!--//app-card-->

            </div>
        </div><!--//row-->

        <hr class="my-4">
    </div><!--//container-fluid-->
</div><!--//app-content-->

<?= $this->endSection('content'); ?>