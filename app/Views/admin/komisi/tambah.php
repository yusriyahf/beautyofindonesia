<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambah Komisi</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/komisi/proses_tambah') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">

                                    <!-- Dropdown Nama Komisi dengan pilihan ENUM -->
                                    <div class="mb-3">
                                        <label class="form-label">Nama Komisi</label>
                                        <select class="form-control" id="nama" name="nama" required>
                                            <option value="">Pilih Nama Komisi</option>
                                            <option value="beautyofindonesia" <?= old('nama') == 'beautyofindonesia' ? 'selected' : '' ?>>Beauty of Indonesia</option>
                                            <option value="penulis" <?= old('nama') == 'penulis' ? 'selected' : '' ?>>Penulis</option>
                                            <option value="marketing" <?= old('nama') == 'marketing' ? 'selected' : '' ?>>Marketing</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Komisi</label>
                                        <input type="number" class="form-control" id="komisi" name="komisi" value="<?= old('komisi') ?>" required>
                                    </div>

                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col">
                                    <a href="<?= base_url('admin/komisi') ?>" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div><!--//card-body-->
                </div><!--//app-card-->
            </div>
        </div>
        <hr class="my-4">
    </div>
</div>

<?= $this->endSection(); ?>
