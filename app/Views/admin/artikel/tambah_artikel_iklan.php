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
                    <form method="post" action="<?= base_url('/admin/artikel/proses_tambah') ?>">
                        <?= csrf_field() ?>

                        <!-- Dropdown Tipe Konten -->
                        <div class="mb-3">
                            <label for="tipe_content" class="form-label">Tipe Konten</label>
                            <select id="tipe_content" name="tipe_content" class="form-control" onchange="resetKonten(); loadKonten();">
                                <option value="">-- Pilih Tipe Konten --</option>
                                <option value="artikel" <?= esc($_GET['tipe_content'] ?? '') == 'artikel' ? 'selected' : '' ?>>Artikel</option>
                                <option value="wisata" <?= esc($_GET['tipe_content'] ?? '') == 'wisata' ? 'selected' : '' ?>>Wisata</option>
                                <option value="oleh_oleh" <?= esc($_GET['tipe_content'] ?? '') == 'oleh_oleh' ? 'selected' : '' ?>>Oleh-oleh</option>
                            </select>
                        </div>

                        <!-- Dropdown Tipe Iklan -->
                        <div class="mb-3">
                            <label for="id_iklan" class="form-label">Pilih Tipe Iklan</label>
                            <select name="id_harga_iklan" id="id_iklan" class="form-select" required onchange="hitungTotalHarga(); loadKonten();">
                                <option value="">-- Pilih Harga Iklan --</option>
                                <?php foreach ($harga_iklan as $h): ?>
                                    <option value="<?= $h['id_harga_iklan'] ?>" data-harga="<?= $h['harga'] ?>">
                                        <?= esc($h['nama']) ?> - Rp<?= number_format($h['harga'], 0, ',', '.') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Dropdown Konten -->
                        <div class="mb-3">
                            <label for="id_konten" class="form-label">Pilih Konten</label>
                            <select name="id_konten" id="id_konten" class="form-select" required disabled>
                                <option value="">-- Pilih Konten --</option>
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

                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengajuan</label>
                            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
                        </div>

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
    const semuaArtikel = <?= json_encode($artikel) ?>;
    const semuaWisata = <?= json_encode($wisata) ?>;
    const semuaOlehOleh = <?= json_encode($oleholeh) ?>;

    function resetKonten() {
        document.getElementById('id_konten').innerHTML = '<option value="">-- Pilih Konten --</option>';
        document.getElementById('id_konten').disabled = true;
    }

    function loadKonten() {
        const tipeContent = document.getElementById('tipe_content').value;
        const kontenDropdown = document.getElementById('id_konten');

        // Reset isi
        kontenDropdown.innerHTML = '<option value="">-- Pilih Konten --</option>';
        kontenDropdown.disabled = true;

        if (!tipeContent) {
            return;
        }

        let data = [];
        let valueKey = '';
        let textKey = '';

        if (tipeContent === 'artikel') {
            data = semuaArtikel;
            valueKey = 'id_artikel';
            textKey = 'judul_artikel';
        } else if (tipeContent === 'wisata') {
            data = semuaWisata;
            valueKey = 'id_wisata';
            textKey = 'nama_wisata_ind';
        } else if (tipeContent === 'oleh_oleh') {
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
        totalHargaInput.value = totalHarga ? "Rp" + totalHarga.toLocaleString('id-ID') : "";
    }
</script>

<?= $this->endSection('content'); ?>