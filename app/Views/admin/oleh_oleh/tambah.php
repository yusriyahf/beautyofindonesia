<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambah Oleh-Oleh</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/oleh_oleh/proses_tambah') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="row">
                                <div class="col">
                                    <!-- Nama Oleh-Oleh -->
                                    <div class="mb-3">
                                        <label for="nama_oleholeh" class="form-label">Nama Oleh-Oleh</label>
                                        <input type="text" class="form-control" id="nama_oleholeh" name="nama_oleholeh" required>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>
                                    <!-- Nama Oleh-Oleh _eng -->
                                    <div class="mb-3">
                                        <label for="nama_oleholeh_eng" class="form-label">Nama Oleh-Oleh_eng</label>
                                        <input type="text" class="form-control" id="nama_oleholeh_eng" name="nama_oleholeh_eng" required>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Kategori Oleh-Oleh -->
                                    <div class="mb-3">
                                        <label for="id_kategori_oleholeh" class="form-label">Kategori Oleh-Oleh</label>
                                        <select class="form-select" id="id_kategori_oleholeh" name="id_kategori_oleholeh" required>
                                            <option value="" selected disabled>Pilih kategori oleh-oleh</option>
                                            <?php foreach ($kategori_oleh_oleh as $kategori) : ?>
                                                <option value="<?= $kategori->id_kategori_oleholeh ?>"><?= $kategori->nama_kategori_oleholeh ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih kategori oleh-oleh.
                                        </div>
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
                                        <input class="form-control <?= ($validation->hasError('foto_oleholeh')) ? 'is-invalid' : '' ?>"
                                            type="file" id="foto_oleholeh" name="foto_oleholeh">
                                        <div>
                                            <img id="image-preview" style="max-width: 100%; margin-top: 10px;" />
                                        </div>
                                        <?= $validation->getError('foto_oleholeh') ?>
                                    </div>
                                    <p>*Ukuran foto harus 1:1</p>
                                    <p>*Foto harus berekstensi jpg/png/jpeg</p>

                                    <!-- Sumber Foto Oleh-Oleh -->
                                    <div class="mb-3">
                                        <label for="sumber_foto" class="form-label">Sumber Foto</label>
                                        <input type="text" class="form-control" id="sumber_foto" name="sumber_foto">
                                    </div>

                                    <!-- Deskripsi Oleh-Oleh -->
                                    <div class="mb-3">
                                        <label for="deskripsi_oleholeh" class="form-label">Deskripsi Oleh-Oleh</label>
                                        <textarea class="form-control" id="deskripsi_oleholeh" name="deskripsi_oleholeh" rows="3" required></textarea>
                                        <div class="invalid-feedback">
                                            Deskripsi oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Deskripsi Oleh-Oleh (En) -->
                                    <div class="mb-3">
                                        <label for="deskripsi_oleholeh_eng" class="form-label">Deskripsi Oleh-Oleh (En)</label>
                                        <textarea class="form-control" id="deskripsi_oleholeh_eng" name="deskripsi_oleholeh_eng" rows="3" required></textarea>
                                        <div class="invalid-feedback">
                                            Deskripsi oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div class="mb-3">
                                        <label for="nomor_tlp" class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="nomor_tlp" name="nomor_tlp" required>
                                        <div class="invalid-feedback">
                                            Nomor telepon wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Link Website -->
                                    <div class="mb-3">
                                        <label for="link_website" class="form-label">Link Website</label>
                                        <input type="text" class="form-control" id="link_website" name="link_website">
                                    </div>

                                    <!-- Oleh-Oleh Latitude-->
                                    <div class="mb-3">
                                        <label for="oleholeh_latitude" class="form-label">Oleh-Oleh Latitude</label>
                                        <input type="text" class="form-control" id="oleholeh_latitude" name="oleholeh_latitude" required>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Oleh-Oleh Longitude-->
                                    <div class="mb-3">
                                        <label for="oleholeh_longitude" class="form-label">Oleh-Oleh Longitude</label>
                                        <input type="text" class="form-control" id="oleholeh_longitude" name="oleholeh_longitude" required>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Meta Title id-->
                                    <div class="mb-3">
                                        <label for="meta_title_id" class="form-label">Meta Title id</label>
                                        <input type="text" class="form-control" id="meta_title_id" name="meta_title_id" required>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Meta Title en-->
                                    <div class="mb-3">
                                        <label for="meta_title_en" class="form-label">Meta Title en</label>
                                        <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" required>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Meta Deskription id -->
                                    <div class="mb-3">
                                        <label for="meta_description_id" class="form-label">Meta Deskription id</label>
                                        <textarea class="form-control" id="meta_description_id" name="meta_description_id" rows="4" required></textarea>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Meta Deskription en -->
                                    <div class="mb-3">
                                        <label for="meta_description_en" class="form-label">Meta Deskription en</label>
                                        <textarea class="form-control" id="meta_description_en" name="meta_description_en" rows="4" required></textarea>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col">
                                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo session()->getFlashdata('success') ?>
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
    </div><!--//container-xl-->
</div><!--//app-content-->


<?= $this->endSection('content') ?>