<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Komisi</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/komisi/proses_edit/' . $komisi['id']) ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <!-- Dropdown Nama Komisi -->
                                    <div class="mb-3">
                                        <label class="form-label">Nama Komisi</label>
                                        <select class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" required>
                                            <option value="">Pilih Nama Komisi</option>
                                            <option value="beautyofindonesia" <?= old('nama', $komisi['nama']) == 'beautyofindonesia' ? 'selected' : '' ?>>Beauty of Indonesia</option>
                                            <option value="penulis" <?= old('nama', $komisi['nama']) == 'penulis' ? 'selected' : '' ?>>Penulis</option>
                                            <option value="marketing" <?= old('nama', $komisi['nama']) == 'marketing' ? 'selected' : '' ?>>Marketing</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama'); ?>
                                        </div>
                                    </div>

                                    <!-- Komisi -->
                                    <div class="mb-3">
                                        <label class="form-label">Komisi</label>
                                        <input type="number" class="form-control <?= ($validation->hasError('komisi')) ? 'is-invalid' : ''; ?>" id="komisi" name="komisi" value="<?= old('komisi', $komisi['komisi']) ?>" required>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('komisi'); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col d-flex gap-2">
                                    <a href="<?= base_url('admin/komisi') ?>" class="btn btn-secondary">Kembali</a>
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

<?= $this->endSection(); ?>
