<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="app-page-title mb-0">Tambah Iklan Utama</h1>
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
                        <form method="post" action="<?= base_url('/marketing/iklanutama/proses_tambah') ?>" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <!-- Paket Iklan Section -->
                            <div class="mb-4">


                                <h5 class="mb-3 border-bottom pb-2">
                                    <i class="fas fa-tags me-2"></i>Paket Iklan
                                </h5>
                                <img src="<?= base_url('assets\images\iklan\wireframe_beranda.png'); ?>" style="width: 100%; display: block; margin: 0 auto;" alt="" class="mb-3">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jenis</label>
                                    <select class="form-control form-control-lg" id="jenis" name="jenis" onchange="filterPaketIklan();">
                                        <option value="Beranda" <?= old('jenis') == 'Beranda' ? 'selected' : '' ?>>Beranda</option>
                                        <option value="Wisata" <?= old('jenis') == 'Wisata' ? 'selected' : '' ?>>Wisata</option>
                                        <option value="Oleh-Oleh" <?= old('jenis') == 'Oleh-Oleh' ? 'selected' : '' ?>>Oleh-Oleh</option>
                                        <option value="Artikel" <?= old('jenis') == 'Artikel' ? 'selected' : '' ?>>Artikel</option>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="id_tipe_iklan_utama" class="form-label fw-bold">Pilih Paket</label>
                                    <select name="id_tipe_iklan_utama" id="id_tipe_iklan_utama" class="form-select" required onchange="hitungTotalHarga(); loadKonten();">
                                        <option value="">-- Pilih Jenis iklan --</option>
                                        <?php foreach ($listJenisIklanUtama as $item): ?>
                                            <option
                                                value="<?= $item['id_tipe_iklan_utama'] ?>"
                                                data-jenis="<?= explode(' - ', $item['nama'])[0] ?>"
                                                data-harga="<?= $item['harga'] ?>"
                                                style="display: none;">
                                                <?= esc($item['nama']) ?> - Rp<?= number_format($item['harga'], 0, ',', '.') ?> - <?= $item['id_tipe_iklan_utama'] ?>
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
                                        <label class="form-label fw-bold">Total Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">Rp</span>
                                            <input type="text" name="total_harga" class="form-control fw-bold text-success" id="total_harga" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Link Iklan</label>
                                <input type="text" class="form-control" id="link_iklan" name="link_iklan" value="<?= old('link_iklan') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Thumbnail Iklan</label>
                                <input type="file" class="form-control" name="thumbnail_iklan" accept="image/*" required>
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
    function hitungTotalHarga() {
        const selectElement = document.getElementById('id_tipe_iklan_utama');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;

        const rentangBulan = parseInt(document.getElementById('rentang_bulan').value) || 0;
        const totalHarga = harga * rentangBulan;

        // Format angka dengan titik sebagai pemisah ribuan
        document.getElementById('total_harga').value = totalHarga.toLocaleString('id-ID');

        // Tambahkan hidden input untuk nilai numerik
        if (!document.getElementById('total_harga_numeric')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'total_harga_numeric';
            input.id = 'total_harga_numeric';
            input.value = totalHarga;
            document.querySelector('form').appendChild(input);
        } else {
            document.getElementById('total_harga_numeric').value = totalHarga;
        }
    }

    function filterPaketIklan() {
        const jenisTerpilih = document.getElementById('jenis').value;
        const paketSelect = document.getElementById('id_tipe_iklan_utama');
        const options = paketSelect.querySelectorAll('option');
        const img = document.getElementById('previewImage');

        if (jenisTerpilih) {
            // Tampilkan dropdown
            paketSelect.disabled = false;

            // Tampilkan option yang sesuai jenis
            options.forEach(option => {
                const jenis = option.getAttribute('data-jenis');
                option.style.display = (!jenis || jenis === jenisTerpilih) ? '' : 'none';
            });

            // Ubah gambar sesuai jenis
            const fileName = `wireframe_${jenisTerpilih.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z\-]/g, '')}.png`;
            img.src = `<?= base_url('assets/images/iklan/'); ?>${fileName}`;
        } else {
            paketSelect.disabled = true;
            paketSelect.value = '';
            options.forEach(option => option.style.display = 'none');

            // Reset gambar (jika ingin default)
            img.src = '<?= base_url('assets/images/iklan/wireframe_beranda.png'); ?>';
        }
    }
</script>

<?= $this->endSection('content'); ?>