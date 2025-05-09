<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="app-page-title mb-0">Edit Artikel Beriklan</h1>
            <a href="<?= base_url('admin/daftariklankonten') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-header mb-4">
                        <h4 class="app-card-title text-primary">
                            <i class="fas fa-ad me-2"></i>Form Edit Iklan
                        </h4>
                    </div>

                    <div class="app-card-body">
                        <form method="post" action="<?= base_url('/admin/artikel/proses_edit2/' . $iklan['id_iklan']) ?>">
                            <?= csrf_field() ?>

                            <!-- Paket Iklan Section -->
                            <div class="mb-4">
                                <h5 class="mb-3 border-bottom pb-2">
                                    <i class="fas fa-tags me-2"></i>Paket Iklan
                                </h5>

                                <div class="mb-3">
                                    <label for="id_iklan" class="form-label fw-bold">Pilih Paket</label>
                                    <select name="id_harga_iklan" id="id_iklan" class="form-select" required onchange="hitungTotalHarga()">
                                        <option value="">-- Pilih paket iklan --</option>
                                        <?php foreach ($harga_iklan as $h): ?>
                                            <option value="<?= $h['id_harga_iklan'] ?>"
                                                data-harga="<?= $h['harga'] ?>"
                                                <?= ($h['id_harga_iklan'] == $iklan['id_harga_iklan']) ? 'selected' : '' ?>>
                                                <?= esc($h['nama']) ?> - Rp<?= number_format($h['harga'], 0, ',', '.') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Durasi (Bulan)</label>
                                        <input type="number" class="form-control" id="rentang_bulan" name="rentang_bulan"
                                            min="1" required oninput="hitungTotalHarga()"
                                            value="<?= $iklan['rentang_bulan'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Total Biaya</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">Rp</span>
                                            <input type="text" name="total_harga" class="form-control fw-bold text-success"
                                                id="total_harga" readonly value="<?= number_format($iklan['total_harga'], 0, ',', '.') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Konten Section -->
                            <div class="mb-4">
                                <h5 class="mb-3 border-bottom pb-2">
                                    <i class="fas fa-file-alt me-2"></i>Konten Iklan
                                </h5>

                                <div class="mb-3">
                                    <label for="tipe_content" class="form-label fw-bold">Jenis Konten</label>
                                    <select id="tipe_content" name="tipe_content" class="form-select" disabled>
                                        <option value="">-- Pilih Jenis Konten --</option>
                                        <option value="artikel" <?= ($iklan['tipe_content'] == 'artikel') ? 'selected' : '' ?>>Artikel</option>
                                        <option value="tempatwisata" <?= ($iklan['tipe_content'] == 'tempatwisata') ? 'selected' : '' ?>>Wisata</option>
                                        <option value="oleholeh" <?= ($iklan['tipe_content'] == 'oleholeh') ? 'selected' : '' ?>>Oleh-oleh</option>
                                    </select>
                                    <input type="hidden" name="tipe_content" value="<?= $iklan['tipe_content'] ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="id_konten" class="form-label fw-bold">Konten Terpilih</label>
                                    <select name="id_content" id="id_konten" class="form-select" disabled>
                                        <option value="<?= $iklan['id_content'] ?>">
                                            <?php
                                            if ($iklan['tipe_content'] == 'artikel') {
                                                echo esc($artikel_terpilih['judul_artikel'] ?? 'Artikel tidak ditemukan');
                                            } elseif ($iklan['tipe_content'] == 'tempatwisata') {
                                                echo esc($wisata_terpilih['nama_wisata_ind'] ?? 'Wisata tidak ditemukan');
                                            } else {
                                                echo esc($oleholeh_terpilih['nama_oleholeh'] ?? 'Oleh-oleh tidak ditemukan');
                                            }
                                            ?>
                                        </option>
                                    </select>
                                    <input type="hidden" name="id_content" value="<?= $iklan['id_content'] ?>">
                                </div>

                                <!-- New Image Upload Section -->
                                <div class="mb-3">
                                    <!-- Current Image Preview -->
                                    <div class="mb-3">
                                        <label class="form-label">Gambar Saat Ini</label>
                                        <div class="card border-0 bg-light p-3">
                                            <?php if (!empty($iklan['gambar_iklan'])): ?>
                                                <img src="<?= base_url('uploads/iklan/' . $iklan['gambar_iklan']) ?>"
                                                    class="img-fluid rounded mb-2"
                                                    style="max-height: 200px; object-fit: contain;"
                                                    alt="Gambar Iklan Saat Ini">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="hapus_gambar" id="hapusGambar" value="1">
                                                    <label class="form-check-label text-danger" for="hapusGambar">
                                                        Hapus gambar saat ini
                                                    </label>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center py-4 text-muted">
                                                    <i class="fas fa-image fa-3x mb-2"></i>
                                                    <p class="mb-0">Tidak ada gambar</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- New Image Upload -->
                                    <div class="mb-3">
                                        <label for="gambar_iklan" class="form-label">Unggah Gambar Baru</label>
                                        <input type="file" class="form-control" id="gambar_iklan" name="gambar_iklan" accept="image/*">
                                        <div class="form-text">
                                            Format: JPG, PNG (Maksimal 2MB). Ukuran disarankan: 1200x630 piksel.
                                        </div>
                                    </div>

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3 d-none">
                                        <label class="form-label">Pratinjau Gambar Baru</label>
                                        <div class="card border-0 bg-light p-3">
                                            <img id="previewImg" src="#"
                                                class="img-fluid rounded"
                                                style="max-height: 200px; object-fit: contain;"
                                                alt="Pratinjau Gambar Baru">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Iklan -->
                            <div class="mb-4">
                                <h5 class="mb-3 border-bottom pb-2">
                                    <i class="fas fa-info-circle me-2"></i>Status Iklan
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status Saat Ini</label>
                                    <div class="card border-0 bg-light">
                                        <div class="card-body py-2">
                                            <div class="d-flex align-items-center">
                                                <?php
                                                // Mapping warna ikon berdasarkan status
                                                $status = $iklan['status_iklan'];
                                                $statusColor = match ($status) {
                                                    'diajukan' => 'text-warning',
                                                    'diterima' => 'text-primary',
                                                    'ditolak' => 'text-danger',
                                                    'berjalan' => 'text-success',
                                                    'selesai' => 'text-secondary',
                                                    default => 'text-muted'
                                                };
                                                ?>
                                                <i class="fas fa-info-circle me-3 fs-4 <?= $statusColor ?>"></i>
                                                <div>
                                                    <div class="fw-semibold text-capitalize"><?= $status ?></div>
                                                    <small class="text-muted">Mulai: <?= date('d/m/Y', strtotime($iklan['tanggal_mulai'])) ?></small>
                                                    <?php if (in_array($status, ['berjalan', 'selesai'])): ?>
                                                        <small class="text-muted ms-2">Selesai: <?= date('d/m/Y', strtotime($iklan['tanggal_akhir'])) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                            <input type="hidden" name="id_marketing" value="<?= $iklan['id_marketing'] ?>">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-circle me-3 fs-4 text-muted"></i>
                                                <div>
                                                    <div class="fw-semibold"><?= esc($marketing['username']) ?></div>
                                                    <small class="text-muted">Tanggal: <?= date('d/m/Y', strtotime($iklan['tanggal_pengajuan'])) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="catatan_admin" class="form-label fw-bold">Catatan Admin</label>
                                    <textarea name="catatan_admin" id="catatan_admin" rows="3" class="form-control"
                                        placeholder="Masukkan catatan atau instruksi khusus..."><?= esc($iklan['catatan_admin']) ?></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                <a href="<?= base_url('admin/daftariklankonten') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
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
                            <i class="fas fa-question-circle me-2"></i>Panduan Edit Iklan
                        </h4>
                    </div>
                    <div class="app-card-body">
                        <div class="alert alert-light border">
                            <h6 class="fw-bold mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Perhatian</h6>
                            <p class="small">Anda tidak dapat mengubah jenis konten atau konten spesifik yang sudah dipilih. Jika ingin mengubah konten, buat iklan baru.</p>

                            <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-tags me-2"></i>Tentang Paket</h6>
                            <p class="small">Anda dapat mengubah paket iklan dan durasi. Total biaya akan otomatis terhitung ulang.</p>

                        </div>

                        <div class="alert alert-info border mt-4">
                            <h6 class="fw-bold"><i class="fas fa-history me-2"></i>Riwayat Iklan</h6>
                            <ul class="small mt-2 ps-3 mb-0">
                                <li>Dibuat: <?= date('d/m/Y H:i', strtotime($iklan['dibuat_pada'])) ?></li>
                                <li>Terakhir diupdate: <?= date('d/m/Y H:i', strtotime($iklan['diperbarui_pada'])) ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Image Preview Functionality
    document.getElementById('gambar_iklan').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('d-none');
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
        }
    });

    // Disable delete checkbox if no file selected
    document.getElementById('gambar_iklan').addEventListener('change', function() {
        const deleteCheckbox = document.getElementById('hapusGambar');
        if (this.files.length > 0 && deleteCheckbox) {
            deleteCheckbox.checked = false;
        }
    });

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

    // Hitung total harga saat pertama kali load
    document.addEventListener('DOMContentLoaded', function() {
        hitungTotalHarga();
    });
</script>

<?= $this->endSection('content'); ?>