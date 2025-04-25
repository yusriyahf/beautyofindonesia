<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Oleh-Oleh</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/oleh_oleh/proses_edit/' . $oleh_oleh['id_oleholeh']) ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="row">
                                <div class="col">
                                    <!-- Nama Oleh-Oleh -->
                                    <div class="mb-3">
                                        <label for="nama_oleholeh" class="form-label">Nama Oleh-Oleh</label>
                                        <input type="text" class="form-control" id="nama_oleholeh" name="nama_oleholeh" value="<?= $oleh_oleh['nama_oleholeh'] ?>" required>
                                        <div class="invalid-feedback">Nama oleh-oleh wajib diisi.</div>
                                    </div>

                                    <!-- Nama Oleh-Oleh (English) -->
                                    <div class="mb-3">
                                        <label for="nama_oleholeh_eng" class="form-label">Nama Oleh-Oleh (English)</label>
                                        <input type="text" class="form-control" id="nama_oleholeh_eng" name="nama_oleholeh_eng" value="<?= $oleh_oleh['nama_oleholeh_eng'] ?>" required>
                                        <div class="invalid-feedback">Nama oleh-oleh wajib diisi.</div>
                                    </div>

                                    <!-- Kategori Oleh-Oleh -->
                                    <div class="mb-3">
                                        <label for="id_kategori_oleholeh" class="form-label">Kategori Oleh-Oleh</label>
                                        <select class="form-select" id="id_kategori_oleholeh" name="id_kategori_oleholeh" required>
                                            <option value="" disabled>Pilih kategori oleh-oleh</option>
                                            <?php foreach ($kategori_oleh_oleh as $kategori) : ?>
                                                <option value="<?= $kategori->id_kategori_oleholeh ?>" <?= ($kategori->id_kategori_oleholeh == $oleh_oleh['id_kategori_oleholeh']) ? 'selected' : '' ?>><?= $kategori->nama_kategori_oleholeh ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Pilih kategori oleh-oleh.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="id_provinsi" class="form-label">Provinsi</label>
                                        <select class="form-control" id="id_provinsi" name="id_provinsi" required>
                                            <option value="">Pilih Provinsi</option>
                                            <?php foreach ($all_data_provinsi as $provinsi) : ?>
                                                <option value="<?= $provinsi->id_provinsi; ?>"><?= $provinsi->nama_provinsi; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Kabupaten -->
                                    <div class="mb-3">
                                        <label for="id_kotakabupaten" class="form-label">Kabupaten</label>
                                        <select class="form-select" id="id_kotakabupaten" name="id_kotakabupaten" required>
                                            <option value="" selected disabled>Pilih kabupaten</option>
                                            <?php foreach ($kotakabupaten as $kabupaten) : ?>
                                                <option value="<?= $kabupaten['id_kotakabupaten'] ?>"><?= $kabupaten['nama_kotakabupaten'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih kabupaten.
                                        </div>
                                    </div>


                                    <!-- Foto Oleh-Oleh -->
                                    <div class="mb-3">
                                        <label class="form-label">Foto Oleh-Oleh</label>
                                        <input class="form-control" type="file" id="foto_oleholeh" name="foto_oleholeh">
                                        <small>Unggah file gambar baru jika ingin mengganti foto.</small>
                                        <div>
                                            <img id="image-preview" src="<?= base_url('assets-baru/img/foto_oleholeh/' . $oleh_oleh['foto_oleholeh']) ?>" style="max-width: 200px;" alt="Preview Foto">
                                        </div>
                                    </div>
                                    <p>*Ukuran foto harus 1:1</p>
                                    <p>*Foto harus berekstensi jpg/png/jpeg</p>


                                    <!-- Deskripsi Oleh-Oleh -->
                                    <div class="mb-3">
                                        <label for="deskripsi_oleholeh" class="form-label">Deskripsi Oleh-Oleh</label>
                                        <textarea class="form-control" id="deskripsi_oleholeh" name="deskripsi_oleholeh" rows="3" required><?= $oleh_oleh['deskripsi_oleholeh'] ?></textarea>
                                        <div class="invalid-feedback">Deskripsi oleh-oleh wajib diisi.</div>
                                    </div>

                                    <!-- Deskripsi Oleh-Oleh (English) -->
                                    <div class="mb-3">
                                        <label for="deskripsi_oleholeh_eng" class="form-label">Deskripsi Oleh-Oleh (English)</label>
                                        <textarea class="form-control" id="deskripsi_oleholeh_eng" name="deskripsi_oleholeh_eng" rows="3" required><?= $oleh_oleh['deskripsi_oleholeh_eng'] ?></textarea>
                                        <div class="invalid-feedback">Deskripsi oleh-oleh wajib diisi.</div>
                                    </div>

                                    <!-- Sumber Foto -->
                                    <div class="mb-3">
                                        <label for="sumber_foto" class="form-label">Sumber Foto</label>
                                        <input type="text" class="form-control" id="sumber_foto" name="sumber_foto" value="<?= $oleh_oleh['sumber_foto'] ?>">
                                    </div>

                                    <!-- Nomer Telpon -->
                                    <div class="mb-3">
                                        <label for="nomor_tlp" class="form-label">Nomer Telpon</label>
                                        <input type="text" class="form-control" id="nomor_tlp" name="nomor_tlp" value="<?= $oleh_oleh['nomor_tlp'] ?>" required>
                                        <div class="invalid-feedback">Nomer Telpon wajib diisi.</div>
                                    </div>

                                    <!-- Link Web Oleh-Oleh -->
                                    <div class="mb-3">
                                        <label for="link_website" class="form-label">Link Web Oleh-Oleh</label>
                                        <input type="text" class="form-control" id="link_website" name="link_website" value="<?= $oleh_oleh['link_website'] ?>">
                                    </div>

                                    <!-- Latitude -->
                                    <div class="mb-3">
                                        <label for="oleholeh_latitude" class="form-label">Latitude</label>
                                        <input type="text" class="form-control" id="oleholeh_latitude" name="oleholeh_latitude" value="<?= $oleh_oleh['oleholeh_latitude'] ?>" required>
                                        <div class="invalid-feedback">Latitude wajib diisi.</div>
                                    </div>

                                    <!-- Longitude -->
                                    <div class="mb-3">
                                        <label for="oleholeh_longitude" class="form-label">Longitude</label>
                                        <input type="text" class="form-control" id="oleholeh_longitude" name="oleholeh_longitude" value="<?= $oleh_oleh['oleholeh_longitude'] ?>" required>
                                        <div class="invalid-feedback">Longitude wajib diisi.</div>
                                    </div>

                                    <!-- Meta Title (Indonesian) -->
                                    <div class="mb-3">
                                        <label for="meta_title_id" class="form-label">Meta Title (ID)</label>
                                        <input type="text" class="form-control" id="meta_title_id" name="meta_title_id" value="<?= $oleh_oleh['meta_title_id'] ?>" required>
                                        <div class="invalid-feedback">Meta Title ID wajib diisi.</div>
                                    </div>

                                    <!-- Meta Title (English) -->
                                    <div class="mb-3">
                                        <label for="meta_title_en" class="form-label">Meta Title (EN)</label>
                                        <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" value="<?= $oleh_oleh['meta_title_en'] ?>" required>
                                        <div class="invalid-feedback">Meta Title EN wajib diisi.</div>
                                    </div>

                                    <!-- Meta Description (Indonesian) -->
                                    <div class="mb-3">
                                        <label for="meta_description_id" class="form-label">Meta Description (ID)</label>
                                        <input type="text" class="form-control" id="meta_description_id" name="meta_description_id" value="<?= $oleh_oleh['meta_description_id'] ?>" required>
                                        <div class="invalid-feedback">Meta Description ID wajib diisi.</div>
                                    </div>

                                    <!-- Meta Description (English) -->
                                    <div class="mb-3">
                                        <label for="meta_description_en" class="form-label">Meta Description (EN)</label>
                                        <input type="text" class="form-control" id="meta_description_en" name="meta_description_en" value="<?= $oleh_oleh['meta_description_en'] ?>" required>
                                        <div class="invalid-feedback">Meta Description EN wajib diisi.</div>
                                    </div>

                                    <div class="mb-3">
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