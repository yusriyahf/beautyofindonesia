<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambah Kabupaten</h1>
        <hr class="mb-4">
        
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <!-- Tampilkan error validasi -->
                        <?php if ($validation->hasError('nama_kotakabupaten')): ?>
                            <div class="alert alert-danger">
                                <?= $validation->listErrors() ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/kabupaten/proses_tambah') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="nama_kotakabupaten" class="form-label">Nama Kabupaten (in)</label>
                                <input type="text" class="form-control" id="nama_kotakabupaten" name="nama_kotakabupaten" value="<?= old('nama_kotakabupaten') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_kotakabupaten_eng" class="form-label">Nama Kabupaten (en)</label>
                                <input type="text" class="form-control" id="nama_kotakabupaten_eng" name="nama_kotakabupaten_eng" value="<?= old('nama_kotakabupaten_eng') ?>" required>
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

                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="<?= base_url('admin/kabupaten/index') ?>" class="btn btn-secondary">Kembali</a>
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

<?= $this->endSection('content'); ?>
