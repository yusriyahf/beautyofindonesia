<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Edit Tipe Iklan</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= base_url('admin/tipeiklanutama') ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="col">
            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
        </div>

        <form action="<?= base_url('admin/tipeiklanutama/update/' . $iklan['id_tipe_iklan_utama']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Tipe Iklan</label>
                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama', esc($iklan['nama'])) ?>" required>
                <div class="invalid-feedback">
                    <?= $validation->getError('nama') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga Tipe Iklan</label>
                <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>" id="harga" name="harga" value="<?= old('harga', esc($iklan['harga'])) ?>" required>
                <div class="invalid-feedback">
                    <?= $validation->getError('harga') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select <?= ($validation->hasError('status')) ? 'is-invalid' : '' ?>" id="status" name="status" required>
                    <option value="ada" <?= ($iklan['status'] == 'ada') ? 'selected' : '' ?>>Ada</option>
                    <option value="tidak" <?= ($iklan['status'] == 'tidak') ? 'selected' : '' ?>>Tidak Ada</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('status') ?>
                </div>
            </div>

           

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection('content');?>