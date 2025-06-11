<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="app-page-title mb-0">Buat Iklan Baru</h1>
            <?php $role = session()->get('role'); ?>
            <a href="<?= base_url($role . '/daftariklankonten') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-header mb-4">
                        <h4 class="app-card-title text-primary">
                            <i class="fas fa-plus-circle me-2"></i>Formulir Iklan Baru
                        </h4>
                    </div>

                    <div class="app-card-body">
                        <form method="post" action="<?= base_url($role . '/daftariklankonten/proses_tambah') ?>" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <?= csrf_field() ?>

                            <!-- Step 1: Paket Iklan -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">1</div>
                                    <h5 class="mb-0">Paket Iklan</h5>
                                </div>

                                <div class="ps-5">
                                    <div class="alert alert-info mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>Perhatian:</strong> Gambar di bawah menunjukkan posisi iklan Anda akan ditampilkan
                                            </div>
                                        </div>
                                    </div>

                                    <img src="<?= base_url('assets/images/layout-iklan.png'); ?>" class="img-fluid rounded border mb-4" alt="Layout Iklan">

                                    <div class="mb-3">
                                        <label for="id_iklan" class="form-label fw-semibold">Pilih Paket <span class="text-danger">*</span></label>
                                        <select name="id_harga_iklan" id="id_iklan" class="form-select" required onchange="hitungTotalHarga()">
                                            <option value="" selected disabled>-- Pilih paket iklan --</option>
                                            <?php foreach ($harga_iklan as $h): ?>
                                                <option value="<?= $h['id_harga_iklan'] ?>" data-harga="<?= $h['harga'] ?>">
                                                    <?= esc($h['nama']) ?> - Rp<?= number_format($h['harga'], 0, ',', '.') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Silakan pilih paket iklan</div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Durasi (Bulan) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="rentang_bulan" name="rentang_bulan" min="1" required oninput="hitungTotalHarga()">
                                            <div class="invalid-feedback">Silakan isi durasi iklan</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Total Biaya</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white">Rp</span>
                                                <input type="text" name="total_harga" class="form-control fw-bold text-success" id="total_harga" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Pilih Konten -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">2</div>
                                    <h5 class="mb-0">Pilih Konten</h5>
                                </div>

                                <div class="ps-5">
                                    <div class="mb-3">
                                        <label for="tipe_content" class="form-label fw-semibold">Jenis Konten <span class="text-danger">*</span></label>
                                        <select id="tipe_content" name="tipe_content" class="form-select" required onchange="resetKonten(); loadKonten();">
                                            <option value="" selected disabled>-- Pilih Jenis Konten --</option>
                                            <option value="artikel">Artikel</option>
                                            <option value="tempatwisata">Wisata</option>
                                            <option value="oleholeh">Oleh-oleh</option>
                                        </select>
                                        <div class="invalid-feedback">Silakan pilih jenis konten</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="id_konten" class="form-label fw-semibold">Judul Konten <span class="text-danger">*</span></label>
                                        <select name="id_content" id="id_konten" class="form-select" required disabled>
                                            <option value="" selected disabled>-- Pilih konten --</option>
                                        </select>
                                        <div class="invalid-feedback">Silakan pilih konten</div>
                                    </div>
                                </div>
                            </div>



                            <!-- Step 3: Upload Gambar -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">3</div>
                                    <h5 class="mb-0">Gambar Iklan</h5>
                                </div>

                                <div class="ps-5">
                                    <div class="alert alert-light border mb-4">
                                        <small class="d-block text-muted mb-2"><strong>Rekomendasi:</strong></small>
                                        <small class="d-block mb-1"><i class="fas fa-check-circle text-success me-2"></i>Ukuran ideal: 1200x630 piksel</small>
                                        <small class="d-block mb-1"><i class="fas fa-check-circle text-success me-2"></i>Format: JPG, PNG (maks. 2MB)</small>
                                        <small class="d-block"><i class="fas fa-check-circle text-success me-2"></i>Gambar jelas dan relevan dengan konten</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="thumbnail_iklan" class="form-label fw-semibold">Upload Gambar <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="thumbnail_iklan" name="thumbnail_iklan" accept="image/*" required>
                                        <div class="invalid-feedback">Silakan upload gambar iklan</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Preview Gambar</label>
                                        <div class="border rounded p-3 text-center bg-light" style="min-height: 150px;">
                                            <img id="thumbnail_preview" src="<?= base_url('assets/images/default-image-icon.jpg') ?>" alt="Preview Gambar" class="img-fluid" style="max-height: 200px;">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="link_iklan" class="form-label fw-semibold mb-2">Kontak/Link Iklan <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control px-3 py-2 border-2 rounded-lg"
                                            id="link_iklan"
                                            name="link_iklan"
                                            placeholder="Contoh: https://wa.me/628123456789 atau https://instagram.com/username"
                                            pattern="^(https?:\/\/)?(wa\.me\/\d+|instagram\.com\/\w+|[\w\.-]+\.[a-z]{2,}\/?.*)$"
                                            required
                                            style="border-color: #e2e8f0; transition: border-color 0.3s;">
                                        <div class="mt-1 text-sm text-muted">
                                            Format yang diterima:
                                            <ul class="list-unstyled mt-1">
                                                <li><i class="bi bi-whatsapp me-1"></i> WhatsApp: <code>https://wa.me/628123456789</code></li>
                                                <li><i class="bi bi-instagram me-1"></i> Instagram: <code>https://instagram.com/username</code></li>
                                                <li><i class="bi bi-link me-1"></i> Website: <code>https://contoh.com</code></li>
                                            </ul>
                                        </div>
                                        <div class="invalid-feedback text-red-500 mt-1 text-sm">
                                            Harap masukkan format yang valid: wa.me/nomor, instagram.com/username, atau URL website
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Informasi Tambahan -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">4</div>
                                    <h5 class="mb-0">Informasi Tambahan</h5>
                                </div>

                                <div class="ps-5">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">No Telepon Pengaju <span class="text-danger">*</span></label>
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
                                        <label class="form-label fw-semibold">Pemohon</label>
                                        <div class="card border">
                                            <div class="card-body py-2">
                                                <input type="hidden" name="id_marketing" value="<?= session()->get('id_user') ?>">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-user-circle fs-3 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div class="fw-semibold"><?= esc(session()->get('username')) ?></div>
                                                        <small class="text-muted">ID: <?= session()->get('id_user') ?> • Tanggal: <?= date('d/m/Y') ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="catatan_admin" class="form-label fw-semibold">Catatan Tambahan</label>
                                        <textarea name="catatan_admin" id="catatan_admin" rows="3" class="form-control" placeholder="Masukkan catatan atau instruksi khusus (opsional)"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pt-4 border-top">
                                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                    <i class="fas fa-times me-2"></i> Batalkan
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
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
                            <i class="fas fa-lightbulb me-2"></i>Panduan & Tips
                        </h4>
                    </div>
                    <div class="app-card-body">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 text-primary">Proses Pembuatan Iklan</h6>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">1</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <small class="fw-semibold d-block">Pilih Konten</small>
                                    <small class="text-muted">Pilih konten yang ingin dipromosikan</small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">2</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <small class="fw-semibold d-block">Pilih Paket</small>
                                    <small class="text-muted">Tentukan durasi dan lihat biaya</small>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">3</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <small class="fw-semibold d-block">Upload Gambar</small>
                                    <small class="text-muted">Gambar menarik meningkatkan klik</small>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">4</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <small class="fw-semibold d-block">Konfirmasi</small>
                                    <small class="text-muted">Periksa kembali sebelum mengajukan</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning border">
                            <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Penting!</h6>
                            <ul class="small mt-2 ps-3 mb-0">
                                <li class="mb-1">Pastikan data sudah benar sebelum submit</li>
                                <li class="mb-1">Gambar harus sesuai ketentuan</li>
                                <li class="mb-1">Durasi minimal 1 bulan</li>
                                <li>Iklan akan aktif setelah diverifikasi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tetap menggunakan script yang sama seperti sebelumnya
    const semuaArtikel = <?= json_encode($artikel) ?>;
    const semuaWisata = <?= json_encode($wisata) ?>;
    const semuaOlehOleh = <?= json_encode($oleholeh) ?>;

    function resetKonten() {
        document.getElementById('id_konten').innerHTML = '<option value="" selected disabled>-- Pilih konten --</option>';
        document.getElementById('id_konten').disabled = true;
    }

    function loadKonten() {
        const tipeContent = document.getElementById('tipe_content').value;
        const kontenDropdown = document.getElementById('id_konten');

        kontenDropdown.innerHTML = '<option value="" selected disabled>-- Pilih konten --</option>';
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

    // Preview thumbnail image before upload
    document.getElementById('thumbnail_iklan').addEventListener('change', function(e) {
        const preview = document.getElementById('thumbnail_preview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.maxHeight = "200px";
            }

            reader.readAsDataURL(file);
        }
    });

    // Form validation
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
    })();
</script>

<?= $this->endSection('content'); ?>