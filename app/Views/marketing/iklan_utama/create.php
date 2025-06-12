<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>
<?php $role = session()->get('role'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="app-page-title mb-0">Tambah Iklan Utama</h1>
            <a href="<?= base_url($role . '/artikel/artikel_beriklan') ?>" class="btn btn-outline-secondary">
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

                            <!-- Paket Iklan Secti  on -->
                            <div class="mb-4">


                                <h5 class="mb-3 border-bottom pb-2">
                                    <i class="fas fa-tags me-2"></i>Paket Iklan
                                </h5>
                                <div class="alert alert-info mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <div>
                                            <strong>Perhatian:</strong> Gambar di bawah menunjukkan posisi iklan Anda akan ditampilkan
                                        </div>
                                    </div>
                                </div>
                                <img id="previewImage" src="" style="width: 100%; display: block; margin: 0 auto;" alt="Preview Iklan" class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jenis</label>
                                    <select class="form-control form-control-lg" id="jenis" name="jenis" onchange="filterPaketIklan();">
                                        <option value="">-- Pilih Jenis --</option>
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

                            <div class="mb-4">
                                <label class="form-label fw-bold mb-2">Upload Thumbnail Iklan</label>
                                <div class="border rounded p-3 bg-light">
                                    <!-- Input File dengan Styling Lebih Baik -->
                                    <div class="file-upload-wrapper">
                                        <input type="file"
                                            class="form-control"
                                            id="thumbnailInput"
                                            name="thumbnail_iklan"
                                            accept="image/*"
                                            required
                                            onchange="previewImage(this)">
                                    </div>

                                    <!-- Preview Container dengan Feedback Lebih Baik -->
                                    <div class="image-preview-container mt-3 text-center">
                                        <div id="noPreview" class="text-muted py-4">
                                            <i class="bi bi-image fs-1"></i>
                                            <p class="mb-0">Belum ada gambar dipilih</p>
                                        </div>
                                        <img id="thumbnailPreview"
                                            src="#"
                                            alt="Preview Gambar"
                                            class="img-thumbnail d-none"
                                            style="max-width: 100%; max-height: 300px; object-fit: contain;">
                                    </div>

                                    <!-- Informasi File -->
                                    <div id="fileInfo" class="small text-muted mt-2 d-none">
                                        <i class="bi bi-info-circle"></i>
                                        <span id="fileName"></span>
                                        <span id="fileSize"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- Informasi Tambahan -->
                            <div class="mb-4">
                                <h5 class="mb-3 border-bottom pb-2">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                                </h5>

                                <div class="mb-3">
                                        <label class="form-label fw-semibold">No Telepon Klien <span class="text-danger">*</span></label>
                                        <div class="card border">
                                            <div class="card-body py-2">
                                                <input
                                                    type="text"
                                                    name="no_pengaju"
                                                    class="form-control border-0"
                                                    placeholder="Masukkan nomor telepon"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

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


<style>
    .file-upload-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .form-control[type="file"] {
        padding: 0.375rem 0.75rem;
        cursor: pointer;
    }

    .image-preview-container {
        border: 2px dashed #dee2e6;
        border-radius: 5px;
        background-color: #f8f9fa;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .image-preview-container:hover {
        border-color: #adb5bd;
    }

    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        transition: all 0.2s ease-in-out;
    }

    .img-thumbnail:hover {
        transform: scale(1.02);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>

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
        const jenisSelect = document.getElementById("jenis");
        const jenisTerpilih = jenisSelect.value;
        const paketSelect = document.getElementById("id_tipe_iklan_utama");
        const options = document.querySelectorAll("#id_tipe_iklan_utama  option");
        const img = document.getElementById("previewImage");

        const imageMap = {
            "Beranda": "wireframe_beranda.png",
            "Artikel": "wireframe_artikel.png",
            "Wisata": "wireframe_wisata.png",
            "Oleh-Oleh": "wireframe_oleholeh.png" // <== yang benar
        };

        if (jenisTerpilih && imageMap[jenisTerpilih]) {
            // Aktifkan dropdown
            paketSelect.disabled = false;

            // Filter opsi
            options.forEach(option => {
                const jenis = option.getAttribute('data-jenis');
                option.style.display = (!jenis || jenis === jenisTerpilih) ? '' : 'none';
            });

            // Tampilkan gambar dari mapping
            img.src = "<?= base_url('assets/images/') ?>" + imageMap[jenisTerpilih];
            img.style.display = "block";

        } else {
            // Reset kalau belum pilih
            paketSelect.disabled = true;
            paketSelect.value = '';
            options.forEach(option => option.style.display = 'none');
            img.src = ""; // Kosongin atau kasih default
            img.style.display = "none";
        }
    }

    function previewImage(input) {
        const preview = document.getElementById('thumbnailPreview');
        const noPreview = document.getElementById('noPreview');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                noPreview.classList.add('d-none');

                // Tampilkan info file
                fileName.textContent = file.name;
                fileSize.textContent = ' (' + formatFileSize(file.size) + ')';
                fileInfo.classList.remove('d-none');
            }

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.classList.add('d-none');
            noPreview.classList.remove('d-none');
            fileInfo.classList.add('d-none');
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>

<?= $this->endSection('content'); ?>