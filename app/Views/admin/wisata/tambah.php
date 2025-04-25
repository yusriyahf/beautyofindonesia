<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambah Tempat Wisata</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/tempat_wisata/proses_tambah') ?>" method="POST"  enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="row">
                                <div class="col">
                                    <!-- Nama Wisata -->
                                    <div class="mb-3">
                                        <label for="nama_wisata_ind" class="form-label">Nama Wisata</label>
                                        <input type="text" class="form-control" id="nama_wisata_ind" name="nama_wisata_ind" required>
                                        <div class="invalid-feedback">
                                            Nama wisata wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Nama Wisata (En) -->
                                    <div class="mb-3">
                                        <label for="nama_wisata_eng" class="form-label">Nama Wisata (En)</label>
                                        <input type="text" class="form-control" id="nama_wisata_eng" name="nama_wisata_eng" required>
                                        <div class="invalid-feedback">
                                            Nama wisata wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Deskripsi Wisata -->
                                    <div class="mb-3">
                                        <label for="deskripsi_wisata_ind" class="form-label">Deskripsi Wisata</label>
                                        <input type="text" class="form-control" id="deskripsi_wisata_ind" name="deskripsi_wisata_ind" required>
                                        <div class="invalid-feedback">
                                            Nama wisata wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Deskripsi Wisata (En) -->
                                    <div class="mb-3">
                                        <label for="deskripsi_wisata_eng" class="form-label">Deskripsi Wisata (En)</label>
                                        <input type="text" class="form-control" id="deskripsi_wisata_eng" name="deskripsi_wisata_eng" required>
                                        <div class="invalid-feedback">
                                            Nama wisata wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Kategori Wisata -->
                                    <div class="mb-3">
                                        <label for="id_kategori_wisata" class="form-label">Kategori Wisata</label>
                                        <select class="form-select" id="id_kategori_wisata" name="id_kategori_wisata" required>
                                            <option value="" selected disabled>Pilih kategori Wisata</option>
                                            <?php foreach ($kategori_wisata as $kategori) : ?>
                                                <option value="<?= $kategori->id_kategori_wisata ?>"><?= $kategori->nama_kategori_wisata ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Pilih kategori Wisata.
                                        </div>
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

                                    <!-- Foto Wisata -->
                                    <div class="mb-3">
                                        <label class="form-label">Foto Wisata</label>
                                        <input class="form-control <?= ($validation->hasError('foto_wisata')) ? 'is-invalid' : '' ?>"
                                            type="file" id="foto_wisata" name="foto_wisata">
                                        <div>
                                            <img id="image-preview" style="max-width: 100%; margin-top: 10px;" />
                                        </div>
                                        <?= $validation->getError('foto_wisata') ?>
                                    </div>

                                    <!-- <div class="mb-3">
                                        <label for="foto_wisata" class="form-label">Foto Wisata</label>
                                        <input type="file" class="form-control" id="foto_wisata" name="foto_wisata" accept="image/*" onchange="previewFoto()" required>
                                        <img id="preview" src="#" alt="Preview Foto" class="img-fluid mt-3" style="display: none; max-height: 200px;">
                                        <div class="invalid-feedback">
                                            Pilih foto wisata.
                                        </div>
                                    </div>
                                    <script>
                                        function previewFoto() {
                                            const input = document.getElementById('foto_wisata');
                                            const preview = document.getElementById('preview');
                                            if (input.files && input.files[0]) {
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    preview.src = e.target.result;
                                                    preview.style.display = 'block';
                                                };
                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        }
                                    </script> -->



                                    <!-- Sumber Foto -->
                                    <div class="mb-3">
                                        <label for="sumber_foto" class="form-label">Sumber Foto</label>
                                        <input type="text" class="form-control" id="sumber_foto" name="sumber_foto" required>
                                        <div class="invalid-feedback">
                                            Sumber Foto oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Wisata Latitude-->
                                    <div class="mb-3">
                                        <label for="wisata_latitude" class="form-label">Wisata Latitude</label>
                                        <input type="text" class="form-control" id="wisata_latitude" name="wisata_latitude" required>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Wisata Longitude-->
                                    <div class="mb-3">
                                        <label for="wisata_longitude" class="form-label">Wisata Longitude</label>
                                        <input type="text" class="form-control" id="wisata_longitude" name="wisata_longitude" required>
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

                                    <!-- Meta Deskription id-->
                                    <div class="mb-3">
                                        <label for="meta_deskription_id" class="form-label">Meta Deskription id</label>
                                        <input type="text" class="form-control" id="meta_deskription_id" name="meta_deskription_id" required>
                                        <div class="invalid-feedback">
                                            Nama oleh-oleh wajib diisi.
                                        </div>
                                    </div>

                                    <!-- Meta Deskription en-->
                                    <div class="mb-3">
                                        <label for="meta_description_en" class="form-label">Meta Deskription en</label>
                                        <input type="text" class="form-control" id="meta_description_en" name="meta_description_en" required>
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