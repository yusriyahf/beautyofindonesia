<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Tempat Wisata</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/tempat_wisata/proses_edit/' . $wisata['id_wisata']) ?>" method="POST" class="needs-validation" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="row">
                            <div class="col">
                                <!-- Nama Wisata -->
                                <div class="mb-3">
                                    <label for="nama_wisata_ind" class="form-label">Nama Wisata</label>
                                    <input type="text" class="form-control" id="nama_wisata_ind" name="nama_wisata_ind" value="<?= $wisata['nama_wisata_ind'] ?>" required>
                                    <div class="invalid-feedback">
                                        Nama wisata wajib diisi.
                                    </div>
                                </div>

                                <!-- Nama Wisata -->
                                <div class="mb-3">
                                    <label for="nama_wisata_eng" class="form-label">Nama Wisata (EN)</label>
                                    <input type="text" class="form-control" id="nama_wisata_eng" name="nama_wisata_eng" value="<?= $wisata['nama_wisata_eng'] ?>" required>
                                    <div class="invalid-feedback">
                                        Nama wisata wajib diisi.
                                    </div>
                                </div>



                                <div class="mb-3">
                                    <label for="id_kategori_wisata" class="form-label">Kategori wisata</label>
                                    <select class="form-select" id="id_kategori_wisata" name="id_kategori_wisata" required>
                                        <option value="" disabled>Pilih kategori wisata</option>
                                        <?php foreach ($kategori_wisata as $kategori) : ?>
                                            <option value="<?= $kategori->id_kategori_wisata ?>" <?= ($kategori->id_kategori_wisata == $wisata['id_kategori_wisata']) ? 'selected' : '' ?>><?= $kategori->nama_kategori_wisata ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Pilih kategori wisata.</div>
                                </div>

                                <!-- Foto Wisata -->

                                <div class="mb-3">
                                    <label class="form-label">Foto Wisata</label>
                                    <input class="form-control" type="file" id="foto_wisata" name="foto_wisata">
                                    <small>Unggah file gambar baru jika ingin mengganti foto.</small>
                                    <div>
                                        <img id="image-preview" src="<?= base_url('asset-user/uploads/foto_wisata/' . $wisata['foto_wisata']) ?>" style="max-width: 200px;" alt="Preview Foto">
                                    </div>
                                </div>

                                <!-- Deskripsi Wisata -->
                                <div class="mb-3">
                                    <label for="deskripsi_wisata_ind" class="form-label">Deskripsi Wisata</label>
                                    <textarea class="form-control" id="deskripsi_wisata_ind" name="deskripsi_wisata_ind" rows="3" required><?= $wisata['deskripsi_wisata_ind'] ?></textarea>
                                    <div class="invalid-feedback">
                                        Deskripsi wisata wajib diisi.
                                    </div>
                                </div>

                                <!-- Deskripsi Wisata EN -->
                                <div class="mb-3">
                                    <label for="deskripsi_wisata_eng" class="form-label">Deskripsi Wisata (EN)</label>
                                    <textarea class="form-control" id="deskripsi_wisata_eng" name="deskripsi_wisata_eng" rows="3" required><?= $wisata['deskripsi_wisata_eng'] ?></textarea>
                                    <div class="invalid-feedback">
                                        Deskripsi wisata wajib diisi.
                                    </div>
                                </div>

                                <!-- Sumber Foto -->
                                <div class="mb-3">
                                    <label for="sumber_foto" class="form-label">Sumber Foto</label>
                                    <input type="text" class="form-control" id="sumber_foto" name="sumber_foto" value="<?= $wisata['sumber_foto'] ?>" required>
                                    <div class="invalid-feedback">
                                        Sumber foto wajib diisi.
                                    </div>
                                </div>


                                <!-- Latitude -->
                                <div class="mb-3">
                                    <label for="wisata_latitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control" id="wisata_latitude" name="wisata_latitude" value="<?= $wisata['wisata_latitude'] ?>" required>
                                    <div class="invalid-feedback">Latitude wajib diisi.</div>
                                </div>

                                <!-- Longitude -->
                                <div class="mb-3">
                                    <label for="wisata_longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control" id="wisata_longitude" name="wisata_longitude" value="<?= $wisata['wisata_longitude'] ?>" required>
                                    <div class="invalid-feedback">Longitude wajib diisi.</div>
                                </div>

                                <!-- Meta Title (Indonesian) -->
                                <div class="mb-3">
                                    <label for="meta_title_id" class="form-label">Meta Title (ID)</label>
                                    <input type="text" class="form-control" id="meta_title_id" name="meta_title_id" value="<?= $wisata['meta_title_id'] ?>" required>
                                    <div class="invalid-feedback">Meta Title ID wajib diisi.</div>
                                </div>

                                <!-- Meta Title (English) -->
                                <div class="mb-3">
                                    <label for="meta_title_en" class="form-label">Meta Title (EN)</label>
                                    <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" value="<?= $wisata['meta_title_en'] ?>" required>
                                    <div class="invalid-feedback">Meta Title EN wajib diisi.</div>
                                </div>

                                <!-- Meta Description (Indonesian) -->
                                <div class="mb-3">
                                    <label for="meta_deskription_id" class="form-label">Meta Description (ID)</label>
                                    <input type="text" class="form-control" id="meta_deskription_id" name="meta_deskription_id" value="<?= $wisata['meta_deskription_id'] ?>" required>
                                    <div class="invalid-feedback">Meta Description ID wajib diisi.</div>
                                </div>

                                <!-- Meta Description (English) -->
                                <div class="mb-3">
                                    <label for="meta_description_en" class="form-label">Meta Description (EN)</label>
                                    <input type="text" class="form-control" id="meta_description_en" name="meta_description_en" value="<?= $wisata['meta_description_en'] ?>" required>
                                    <div class="invalid-feedback">Meta Description EN wajib diisi.</div>
                                </div>

                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                            </div>
                    </div>

                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    </form>
                </div>
            </div><!--//app-card-->
        </div>
    </div><!--//row-->
    <hr class="my-4">
</div><!--//container-xl-->
</div><!--//app-content-->

<?= $this->endSection('content') ?>