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

                        <!-- Dropdown Harga Iklan -->
                        <div class="mb-3">
                            <label for="id_iklan" class="form-label">Pilih Tipe Iklan</label>
                            <select name="id_harga_iklan" id="id_iklan" class="form-select" required onchange="filterArtikel(); hitungTotalHarga();">
                                <option value="">-- Pilih Harga Iklan --</option>
                                <?php foreach ($harga_iklan as $h): ?>
                                    <option value="<?= $h['id_harga_iklan'] ?>" data-nama="<?= esc($h['nama']) ?>" data-harga="<?= $h['harga'] ?>">
                                        <?= esc($h['nama']) ?> - Rp<?= number_format($h['harga'], 0, ',', '.') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Dropdown Artikel -->
                        <div class="mb-3">
                            <label for="id_artikel" class="form-label">Pilih Artikel</label>
                            <select name="id_artikel" id="id_artikel" class="form-select" required disabled>
                                <option value="">-- Pilih Artikel --</option>
                            </select>
                        </div>

                        <!-- ID Penulis dari Session -->
                        <div class="mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="hidden" name="id_marketing" value="<?= session()->get('id_user') ?>">
                            <input type="text" class="form-control" value="<?= esc(session()->get('username')) ?>" readonly>
                        </div>



                        <div class="mb-3">
                            <label class="form-label">Rentang Bulan</label>
                            <input type="number" class="form-control" id="rentang_bulan" name="rentang_bulan" min="1" required oninput="hitungTotalHarga()">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total_harga" readonly>
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

<script>
    // Semua data artikel
    const semuaArtikel = <?= json_encode($artikel) ?>;

    function filterArtikel() {
        const idIklanSelect = document.getElementById('id_iklan');
        const selectedOption = idIklanSelect.options[idIklanSelect.selectedIndex];
        const tipeIklanNama = selectedOption.getAttribute('data-nama');

        const artikelSelect = document.getElementById('id_artikel');
        artikelSelect.innerHTML = '<option value="">-- Pilih Artikel --</option>'; // Reset artikel

        if (!idIklanSelect.value) {
            artikelSelect.disabled = true; // Disable kalau belum pilih iklan
            return;
        }

        artikelSelect.disabled = false; // Enable setelah pilih iklan

        // Tentukan kolom filter berdasarkan tipe iklan
        let kolomFilter = '';
        if (tipeIklanNama.toLowerCase().includes('banner')) {
            kolomFilter = 'iklan_banner';
        } else if (tipeIklanNama.toLowerCase().includes('sidebar')) {
            kolomFilter = 'iklan_sidebar';
        } else if (tipeIklanNama.toLowerCase().includes('footer')) {
            kolomFilter = 'iklan_footer';
        } else {
            return;
        }

        // Filter artikel yang punya "iya" di kolom yang sesuai
        semuaArtikel.forEach(a => {
            if (a[kolomFilter] === 'tidak') {
                const opt = document.createElement('option');
                opt.value = a.id_artikel;
                opt.textContent = a.judul_artikel;
                artikelSelect.appendChild(opt);
            }
        });
    }

    function hitungTotalHarga() {
        const idIklanSelect = document.getElementById('id_iklan');
        const selectedOption = idIklanSelect.options[idIklanSelect.selectedIndex];
        const hargaIklan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;

        const rentangBulanInput = document.getElementById('rentang_bulan');
        const rentangBulan = parseInt(rentangBulanInput.value) || 0;

        const totalHarga = hargaIklan * rentangBulan;

        const totalHargaInput = document.getElementById('total_harga');
        totalHargaInput.value = totalHarga ? "Rp" + totalHarga.toLocaleString('id-ID') : "";
    }
</script>

<?= $this->endSection('content'); ?>