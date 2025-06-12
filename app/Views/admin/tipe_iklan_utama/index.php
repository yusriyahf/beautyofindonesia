<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-ad me-2 text-white"></i>Manajemen Tipe Iklan Utama</h1>
                    <p class="mb-0 opacity-75">Kelola semua tipe iklan utama di sini</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button type="button" class="btn btn-light text-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Tipe Iklan
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div><?= session()->getFlashdata('success') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Data Table Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($tipeiklanutama)) : ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-ad fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada tipe iklan</h5>
                        <p class="text-muted mb-3">Tidak ada tipe iklan utama yang tersedia</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Tipe Iklan
                        </button>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table id="tipeIklanTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Tipe Iklan</th>
                                    <th width="150" class="text-end">Harga</th>
                                    <th width="120" class="text-center">Status</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($tipeiklanutama as $tipe) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-container bg-primary-soft text-primary me-3">
                                                    <i class="fas fa-ad"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= esc($tipe['nama']) ?></h6>
                                                    <small class="text-muted">ID: TI-<?= str_pad($tipe['id_tipe_iklan_utama'], 4, '0', STR_PAD_LEFT) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold">
                                            Rp<?= number_format($tipe['harga'], 0, ',', '.') ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($tipe['status'] == 'ada') : ?>
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10">
                                                    <i class="fas fa-check-circle me-1"></i> Ada Slot Iklan
                                                </span>
                                            <?php else : ?>
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10">
                                                    <i class="fas fa-times-circle me-1"></i> Tidak ada Slot Iklan
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal<?= $tipe['id_tipe_iklan_utama'] ?>"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal<?= $tipe['id_tipe_iklan_utama'] ?>"
                                                    title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Menampilkan <span class="fw-bold"><?= count($tipeiklanutama) ?></span> dari <span class="fw-bold"><?= $totalItems ?? count($tipeiklanutama) ?></span> entri
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Selanjutnya</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Tipe Iklan Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/tipeiklanutama/proses_tambah') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3 d-flex gap-3">
                        <div>
                            <label for="jenis_konten" class="form-label">Jenis Konten</label>
                            <select class="form-select" name="jenis_konten" id="jenis_konten">
                                <option disabled <?= old('jenis_konten') ? '' : 'selected' ?>>Pilih Jenis Konten</option>
                                <option value="Beranda" <?= old('jenis_konten') == 'Beranda' ? 'selected' : '' ?>>Beranda</option>
                                <option value="Artikel" <?= old('jenis_konten') == 'Artikel' ? 'selected' : '' ?>>Artikel</option>
                                <option value="Wisata" <?= old('jenis_konten') == 'Wisata' ? 'selected' : '' ?>>Wisata</option>
                                <option value="Oleh-Oleh" <?= old('jenis_konten') == 'Oleh-Oleh' ? 'selected' : '' ?>>Oleh-Oleh</option>
                            </select>
                        </div>
                        <div>
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" name="kategori" id="kategori">
                                <option disabled selected>Pilih Kategori</option>
                                <?php foreach (['Artikel' => $kategori, 'Wisata' => $wisata, 'Oleh-Oleh' => $oleholeh] as $jenis => $list): ?>
                                    <?php foreach ($list as $item): ?>
                                        <?php
                                        $nama_kolom = 'nama_kategori';
                                        if ($jenis === 'Wisata') $nama_kolom = 'nama_kategori_wisata';
                                        if ($jenis === 'Oleh-Oleh') $nama_kolom = 'nama_kategori_oleholeh';
                                        $nilai = $item->$nama_kolom;
                                        ?>
                                        <option value="<?= esc($nilai) ?>" data-jenis="<?= $jenis ?>"
                                            <?= old('kategori') == $nilai ? 'selected' : '' ?>>
                                            <?= esc($nilai) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="tipe" class="form-label">Tipe Iklan</label>
                            <select class="form-select" name="tipe" id="tipe">
                                <option disabled <?= old('tipe') ? '' : 'selected' ?>>Pilih Tipe Iklan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="harga" value="<?= old('harga') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="" disabled selected>Pilih status</option>
                            <option value="ada" <?= old('status') == 'ada' ? 'selected' : '' ?>>Aktif</option>
                            <option value="tidak" <?= old('status') == 'tidak' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modals -->
<?php foreach ($tipeiklanutama as $tipe) : ?>
    <div class="modal fade" id="editModal<?= $tipe['id_tipe_iklan_utama'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Tipe Iklan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/tipeiklanutama/update/' . $tipe['id_tipe_iklan_utama']) ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3 d-flex gap-3">
                            <div class="mb-3">
                                <label class="form-label">Jenis Konten</label>
                                <select class="form-select jenis-konten-edit" name="jenis_konten" required>
                                    <option disabled>Pilih Jenis Konten</option>
                                    <?php foreach (['Beranda', 'Artikel', 'Wisata', 'Oleh-Oleh'] as $jk): ?>
                                        <option value="<?= $jk ?>" <?= ($tipe['jenis_konten'] === $jk) ? 'selected' : '' ?>><?= $jk ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select kategori-edit" name="kategori" <?= $tipe['jenis_konten'] === 'Beranda' ? 'disabled' : 'required' ?>>
                                    <option disabled>Pilih Kategori</option>
                                    <?php
                                    $field = '';
                                    $kategoriList = [];

                                    if ($tipe['jenis_konten'] === 'Artikel') {
                                        $kategoriList = $kategori;
                                        $field = 'nama_kategori';
                                    } elseif ($tipe['jenis_konten'] === 'Wisata') {
                                        $kategoriList = $wisata;
                                        $field = 'nama_kategori_wisata';
                                    } elseif ($tipe['jenis_konten'] === 'Oleh-Oleh') {
                                        $kategoriList = $oleholeh;
                                        $field = 'nama_kategori_oleholeh';
                                    }

                                    foreach ($kategoriList as $item):
                                        $value = $item->$field;
                                        $selected = ($value === $tipe['kategori']) ? 'selected' : '';
                                    ?>
                                        <option value="<?= esc($value) ?>" <?= $selected ?>><?= esc($value) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipe Iklan</label>
                                <select class="form-select tipe-edit" name="tipe" required>
                                    <option disabled>Pilih Tipe</option>
                                    <?php
                                    $opsi = ($tipe['jenis_konten'] === 'Beranda') ? ['1', '2', '3'] : ['Header', 'Sidebar', 'Footer'];
                                    foreach ($opsi as $t):
                                        $selected = ($t === $tipe['tipe']) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $t ?>" <?= $selected ?>><?= $t ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="harga" value="<?= old('harga', esc($tipe['harga'])) ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="ada" <?= ($tipe['status'] == 'ada') ? 'selected' : '' ?>>Aktif</option>
                                <option value="tidak" <?= ($tipe['status'] == 'tidak') ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Delete Modals -->
<?php foreach ($tipeiklanutama as $tipe) : ?>
    <div class="modal fade" id="deleteModal<?= $tipe['id_tipe_iklan_utama'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center px-4">
                    <div class="icon-container bg-danger-soft text-danger mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <h5 class="modal-title mb-3">Konfirmasi Penghapusan</h5>
                    <p class="mb-0">Anda akan menghapus tipe iklan:</p>
                    <h6 class="mb-3">"<?= esc($tipe['nama']) ?>"</h6>
                    <p class="text-muted small">Tindakan ini tidak dapat dibatalkan. Pastikan data yang dihapus benar.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('admin/tipeiklanutama/delete/' . $tipe['id_tipe_iklan_utama']) ?>" class="btn btn-danger px-4">
                        <i class="fas fa-trash-alt me-2"></i>Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<style>
    /* Dashboard Header */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, rgb(100, 181, 201) 100%);
    }

    /* Icon Container */
    .icon-container {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-primary-soft {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1);
    }

    /* Table Styling */
    .table {
        font-size: 14px;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        color: #6c757d;
        background-color: #f8f9fa;
        padding: 12px 16px;
        border-bottom: 1px solid #e9ecef;
    }

    .table td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }

    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Badge Styling */
    .badge {
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 20px;
    }

    /* Button Styling */
    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 6px;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    /* Modal Styling */
    .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
    }

    /* Form Styling */
    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }

    .input-group-text {
        background-color: #f8f9fa;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#tipeIklanTable').DataTable({
            responsive: true,
            searching: true,
            ordering: true,
            paging: false,
            info: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                orderable: false,
                targets: [4] // Disable sorting for action column
            }],
            initComplete: function() {
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });

        // Initialize tooltips
        $('[title]').tooltip({
            trigger: 'hover',
            placement: 'top'
        });

        <?php if (isset($validation)) : ?>
            <?php if ($validation->hasError('nama') || $validation->hasError('harga') || $validation->hasError('status')) : ?>
                var addModal = new bootstrap.Modal(document.getElementById('addModal'));
                addModal.show();
            <?php endif; ?>
        <?php endif; ?>
    });

    document.addEventListener('DOMContentLoaded', function() {
        const jenisKonten = document.getElementById('jenis_konten');
        const tipe = document.getElementById('tipe');
        const kategori = document.getElementById('kategori');

        const tipeBeranda = ['1', '2', '3'];
        const tipeLain = ['Header', 'Sidebar', 'Footer'];

        function updateJenisKonten() {
            const jenis = jenisKonten.value;

            let options = '<option disabled selected>Pilih Tipe Iklan</option>';
            const tipeList = jenis === 'Beranda' ? tipeBeranda : tipeLain;
            tipeList.forEach(val => {
                const selected = (val === "<?= old('tipe') ?>") ? 'selected' : '';
                options += `<option value="${val}" ${selected}>${val}</option>`;
            });
            tipe.innerHTML = options;

            let kategoriChanged = false;
            Array.from(kategori.options).forEach(opt => {
                if (!opt.value) return;
                const isMatch = opt.getAttribute('data-jenis') === jenis;
                opt.hidden = !isMatch;

                if (!isMatch && opt.selected) {
                    kategoriChanged = true;
                    opt.selected = false;
                }
            });

            if (jenis === 'Beranda') {
                kategori.selectedIndex = 0;
                kategori.disabled = true;
                kategori.required = false;
            } else {
                kategori.disabled = false;
                kategori.required = true;
                if (kategoriChanged || kategori.selectedIndex < 0) {
                    kategori.selectedIndex = 0;
                }
            }
        }

        updateJenisKonten();
        jenisKonten.addEventListener('change', updateJenisKonten);
    });
</script>

<?= $this->endSection('content'); ?>