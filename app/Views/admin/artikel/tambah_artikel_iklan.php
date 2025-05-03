<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="app-page-title mb-0">Tambah Artikel Beriklan</h1>
            <a href="<?= base_url('admin/artikel/artikel_beriklan') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-header mb-4">
                        <h4 class="app-card-title text-primary">
                            <i class="fas fa-ad me-2"></i>Form Pengajuan Iklan Baru
                        </h4>
                    </div>

                    <div class="app-card-body">
                        <form method="post" action="<?= base_url('/admin/artikel/proses_tambah2') ?>">
                            <?= csrf_field() ?>

                            <!-- Paket Iklan Section -->
                            <div class="mb-4">
                                <h5 class="mb-3 border-bottom pb-2">
                                    <i class="fas fa-tags me-2"></i>Paket Iklan
                                </h5>
                                <img src="<?= base_url('assets/images/layout iklan.png'); ?>" style="width: 100%; display: block; margin: 0 auto;" alt="">


                                <div class="mb-3">
                                    <label for="id_iklan" class="form-label fw-bold">Pilih Paket</label>
                                    <select name="id_harga_iklan" id="id_iklan" class="form-select" required onchange="hitungTotalHarga(); loadKonten();">
                                        <option value="">-- Pilih paket iklan --</option>
                                        <?php foreach ($harga_iklan as $h): ?>
                                            <option value="<?= $h['id_harga_iklan'] ?>" data-harga="<?= $h['harga'] ?>">
                                                <?= esc($h['nama']) ?> - Rp<?= number_format($h['harga'], 0, ',', '.') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Durasi (Bulan)</label>
                                        <input type="number" class="form-control" id="rentang_bulan" name="rentang_bulan" min="1" required oninput="hitungTotalHarga()">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Total Biaya</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">Rp</span>
                                            <input type="text" name="total_harga" class="form-control fw-bold text-success" id="total_harga" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Konten Section -->
                            <div class="mb-4">
                                <h5 class="mb-3 border-bottom pb-2">
                                    <i class="fas fa-file-alt me-2"></i>Pilih Konten
                                </h5>

                                <div class="mb-3">
                                    <label for="tipe_content" class="form-label fw-bold">Jenis Konten</label>
                                    <select id="tipe_content" name="tipe_content" class="form-select" onchange="resetKonten(); loadKonten();">
                                        <option value="">-- Pilih Jenis Konten --</option>
                                        <option value="artikel" <?= esc($_GET['tipe_content'] ?? '') == 'artikel' ? 'selected' : '' ?>>Artikel</option>
                                        <option value="tempatwisata" <?= esc($_GET['tipe_content'] ?? '') == 'tempatwisata' ? 'selected' : '' ?>>Wisata</option>
                                        <option value="oleholeh" <?= esc($_GET['tipe_content'] ?? '') == 'oleholeh' ? 'selected' : '' ?>>Oleh-oleh</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="id_konten" class="form-label fw-bold">Pilih Konten Spesifik</label>
                                    <select name="id_content" id="id_konten" class="form-select" required disabled>
                                        <option value="">-- Pilih konten terlebih dahulu --</option>
                                    </select>
                                </div>
                            </div>


                            <!-- Informasi Tambahan -->
                            <div class="mb-4">
                                <h5 class="mb-3 border-bottom pb-2">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pemohon</label>
                                    <div class="card border-0 bg-light">
                                        <div class="card-body py-2">
                                            <input type="hidden" name="id_marketing" value="<?= session()->get('id_user') ?>">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-circle me-3 fs-4 text-muted"></i>
                                                <div>
                                                    <div class="fw-semibold"><?= esc(session()->get('username')) ?></div>
                                                    <small class="text-muted">Tanggal: <?= date('d/m/Y') ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="catatan_admin" class="form-label fw-bold">Catatan Tambahan</label>
                                    <textarea name="catatan_admin" id="catatan_admin" rows="3" class="form-control" placeholder="Masukkan catatan atau instruksi khusus..."></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                <a href="<?= base_url('admin/artikel/artikel_beriklan') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-paper-plane me-2"></i> Ajukan Iklan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Panduan Section -->
            <div class="col-12 col-lg-4">
                <div class="app-card app-card-settings shadow-sm p-4 h-100">
                    <div class="app-card-header mb-4">
                        <h4 class="app-card-title text-primary">
                            <i class="fas fa-question-circle me-2"></i>Panduan Singkat
                        </h4>
                    </div>
                    <div class="app-card-body">
                        <div class="alert alert-light border">
                            <h6 class="fw-bold mb-3"><i class="fas fa-file-alt me-2"></i>Tentang Konten</h6>
                            <p class="small">Pilih konten yang ingin dipromosikan dari daftar artikel, wisata, atau oleh-oleh yang tersedia.</p>

                            <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-tags me-2"></i>Tentang Paket</h6>
                            <p class="small">Setiap paket memiliki durasi dan harga berbeda. Total biaya akan otomatis terhitung berdasarkan durasi yang dipilih.</p>

                            <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-clock me-2"></i>Proses Verifikasi</h6>
                            <p class="small">Pengajuan akan diproses dalam 1-2 hari kerja setelah dikirim.</p>
                        </div>

                        <div class="alert alert-warning border mt-4">
                            <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Perhatian</h6>
                            <ul class="small mt-2 ps-3 mb-0">
                                <li>Pastikan semua data benar sebelum mengajukan</li>
                                <li>Durasi minimal 1 bulan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const semuaArtikel = <?= json_encode($artikel) ?>;
    const semuaWisata = <?= json_encode($wisata) ?>;
    const semuaOlehOleh = <?= json_encode($oleholeh) ?>;

    function resetKonten() {
        document.getElementById('id_konten').innerHTML = '<option value="">-- Pilih konten terlebih dahulu --</option>';
        document.getElementById('id_konten').disabled = true;
    }

    function loadKonten() {
        const tipeContent = document.getElementById('tipe_content').value;
        const kontenDropdown = document.getElementById('id_konten');

        kontenDropdown.innerHTML = '<option value="">-- Pilih konten terlebih dahulu --</option>';
        kontenDropdown.disabled = true;

        if (!tipeContent) return;

        let data = [];
        let valueKey = '';
        let textKey = '';

        if (tipeContent === 'artikel') {
            data = semuaArtikel;
            valueKey = 'id_artikel';
            textKey = 'judul_artikel';
        } else if (tipeContent === 'tempatwisata') {
            data = semuaWisata;
            valueKey = 'id_wisata';
            textKey = 'nama_wisata_ind';
        } else if (tipeContent === 'oleholeh') {
            data = semuaOlehOleh;
            valueKey = 'id_oleholeh';
            textKey = 'nama_oleholeh';
        }

        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item[valueKey];
            option.textContent = item[textKey];
            kontenDropdown.appendChild(option);
        });

        kontenDropdown.disabled = false;
    }

    function hitungTotalHarga() {
        const idIklanSelect = document.getElementById('id_iklan');
        const selectedOption = idIklanSelect.options[idIklanSelect.selectedIndex];
        const hargaIklan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;

        const rentangBulanInput = document.getElementById('rentang_bulan');
        const rentangBulan = parseInt(rentangBulanInput.value) || 0;

        const totalHarga = hargaIklan * rentangBulan;

        const totalHargaInput = document.getElementById('total_harga');
        totalHargaInput.value = totalHarga ? totalHarga.toLocaleString('id-ID') : "";
    }
</script>

<?= $this->endSection('content'); ?>