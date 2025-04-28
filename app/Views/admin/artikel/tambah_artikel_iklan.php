<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row mb-4">
            <div class="col">
                <h1 class="app-page-title">Tambah Artikel Beriklan</h1>
            </div>
        </div>

        <div class="row g-4 settings-section">
            <div class="col-12">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <form method="post" action="<?= base_url('admin/artikel/simpan_iklan') ?>">
                        <?= csrf_field() ?>

                        <!-- Dropdown Artikel -->
                        <div class="mb-3">
                            <label for="id_artikel" class="form-label">Pilih Artikel</label>
                            <select name="id_artikel" id="id_artikel" class="form-select" required>
                                <option value="">-- Pilih Artikel --</option>
                                <?php foreach ($artikel as $a): ?>
                                    <option value="<?= $a->id_artikel ?>"><?= esc($a->judul_artikel) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ID Penulis dari Session -->
                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="hidden" name="id_penulis" value="<?= session()->get('id_user') ?>">
                            <input type="text" class="form-control" value="<?= esc(session()->get('username')) ?>" readonly>
                        </div>

                        <!-- Dropdown Harga Iklan -->
                        <div class="mb-3">
                            <label for="id_iklan" class="form-label">Pilih Tipe Iklan</label>
                            <select name="id_iklan" id="id_iklan" class="form-select" required>
                                <option value="">-- Pilih Harga Iklan --</option>
                                <?php foreach ($harga_iklan as $h): ?>
                                    <option value="<?= $h['id_harga_iklan'] ?>">
                                        <?= esc($h['nama']) ?> - Rp<?= number_format($h['harga'], 0, ',', '.') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rentang Bulan</label>
                            <input type="number" class="form-control" name="rentang_bulan" min="1" required>
                        </div>


                        <!-- Tanggal Pengajuan (otomatis) -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengajuan</label>
                            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
                        </div>

                        <!-- Catatan Admin -->
                        <div class="mb-3">
                            <label for="catatan_admin" class="form-label">Catatan Admin (Opsional)</label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Ajukan Iklan</button>
                            <a href="<?= base_url('admin/artikel/artikel_beriklan') ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div><!--//app-card-->
            </div>
        </div><!--//row-->
    </div><!--//container-xl-->
</div><!--//app-content-->

<?= $this->endSection('content'); ?>