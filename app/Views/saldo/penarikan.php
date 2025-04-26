<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Penarikan Saldo</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="card-body">
                        <form action="<?= base_url('admin/saldo/proses_penarikan') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row">
                                <div class="col">
                                    <input type="hidden" name="status" value="diproses">
                                    <input type="hidden" name="tanggal_pengajuan" value="<?= date('Y-m-d H:i:s') ?>">

                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah Saldo yang Ingin Ditarik</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="jumlah"
                                            name="jumlah"
                                            min="1"
                                            max="50000"
                                            placeholder="Masukkan jumlah saldo"
                                            value="<?= old('jumlah') ?>"
                                            required>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Tarik Saldo</button>
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