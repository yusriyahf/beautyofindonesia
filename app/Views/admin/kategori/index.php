<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-tags me-2 text-white"></i> Daftar Kategori Artikel</h1>
                    <p class="mb-0 opacity-75">Kelola kategori untuk mengorganisir konten Anda</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <?php $role = session()->get('role'); ?>
                    <?php if (in_array($role, ['admin', 'penulis'])): ?>
                        <button class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-info" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                            <i class="fas fa-plus me-1"></i>Tambah Kategori
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Category Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <?php if (empty($all_data_kategori)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-tags fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada kategori</h5>
                        <p class="text-muted mb-3">Mulai dengan membuat kategori baru</p>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                            <i class="fas fa-plus me-1"></i>Tambah Kategori
                        </button>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="kategoriTable" class="table table-hover w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th width="60" class="text-center">No</th>
                                    <th>Kategori (Indonesia)</th>
                                    <th>Kategori (English)</th>
                                    <?php if (in_array($role, ['admin', 'penulis'])): ?>
                                        <th width="120" class="text-center">Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($all_data_kategori as $tampilKategori) : ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $i++; ?></td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3 py-2">
                                                <?= esc($tampilKategori->nama_kategori) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10 px-3 py-2">
                                                <?= esc($tampilKategori->nama_kategori_en) ?>
                                            </span>
                                        </td>
                                        <?php if (in_array($role, ['admin', 'penulis'])): ?>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button class="btn btn-sm btn-outline-primary edit-btn"
                                                        data-id="<?= $tampilKategori->id_kategori ?>"
                                                        data-nama="<?= esc($tampilKategori->nama_kategori) ?>"
                                                        data-nama-en="<?= esc($tampilKategori->nama_kategori_en) ?>"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger delete-btn"
                                                        data-id="<?= $tampilKategori->id_kategori ?>"
                                                        title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title" id="tambahKategoriModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url($role . '/kategori/tambah') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label small text-muted mb-1">NAMA KATEGORI (INDONESIA)</label>
                        <input type="text" class="form-control py-2" id="nama_kategori" name="nama_kategori" required placeholder="Contoh: Teknologi">
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori_en" class="form-label small text-muted mb-1">NAMA KATEGORI (ENGLISH)</label>
                        <input type="text" class="form-control py-2" id="nama_kategori_en" name="nama_kategori_en" required placeholder="Contoh: Technology">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title" id="editKategoriModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_kategori" class="form-label small text-muted mb-1">NAMA KATEGORI (INDONESIA)</label>
                        <input type="text" class="form-control py-2" id="edit_nama_kategori" name="nama_kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama_kategori_en" class="form-label small text-muted mb-1">NAMA KATEGORI (ENGLISH)</label>
                        <input type="text" class="form-control py-2" id="edit_nama_kategori_en" name="nama_kategori_en" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-exclamation-circle fa-3x text-danger"></i>
                </div>
                <h5 class="mb-3">Konfirmasi Hapus</h5>
                <p class="text-muted mb-0">Apakah Anda yakin ingin menghapus kategori ini?</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-danger rounded-pill px-4">Ya, Hapus</a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, rgb(100, 181, 201) 100%);
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
    }

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
        border-bottom: 1px solid #e9ecef;
    }

    .table td {
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }

    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge {
        font-weight: 500;
        border-radius: 8px;
    }

    .form-control {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        border: 1px solid #e0e0e0;
    }

    .form-control:focus {
        border-color: #4d90fe;
        box-shadow: 0 0 0 2px rgba(77, 144, 254, 0.2);
    }

    .btn {
        border-radius: 8px;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 12px;
    }

    .btn-outline-primary,
    .btn-outline-danger {
        border-width: 1px;
    }

    .modal-content {
        border-radius: 12px;
    }

    .modal-header {
        border-radius: 12px 12px 0 0;
    }

    /* DataTables custom styling */
    .dataTables_wrapper .dataTables_length select {
        border-radius: 6px;
        padding: 4px 8px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 6px;
        padding: 4px 8px;
        border: 1px solid #dee2e6;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 6px !important;
        margin: 0 2px;
        padding: 4px 10px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #0d6efd !important;
        color: white !important;
        border: none !important;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            text-align: center;
        }

        .dashboard-header .text-md-end {
            text-align: center !important;
            margin-top: 1rem;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            text-align: left !important;
            margin-bottom: 1rem;
        }
    }

    /* Mencegah scroll horizontal */
    #kategoriTable {
        width: 100% !important;
        table-layout: auto;
    }

    .dataTables_wrapper .dataTables_scroll {
        overflow-x: hidden;
    }

    /* Optional: pastikan container tidak menyumbang scroll */
    .table-responsive {
        overflow-x: hidden;
    }
</style>

<script>
    $(document).ready(function() {
        $(document).ready(function() {
            // Cek apakah kolom aksi ada
            var hasActionColumn = <?= in_array($role, ['admin', 'penulis']) ? 'true' : 'false' ?>;
            var columnDefs = [{
                    orderable: false,
                    targets: [0] // Kolom No selalu tidak bisa di-sort
                },
                {
                    className: "text-center",
                    targets: [0] // Kolom No selalu di tengah
                },
                {
                    width: "60px",
                    targets: 0
                }
            ];

            // Tambahkan pengaturan untuk kolom aksi jika ada
            if (hasActionColumn) {
                columnDefs.push({
                    orderable: false,
                    targets: [3] // Kolom aksi
                }, {
                    className: "text-center",
                    targets: [3] // Kolom aksi di tengah
                }, {
                    width: "120px",
                    targets: 3 // Lebar kolom aksi
                });
            }

            // Initialize DataTable
            var table = $('#kategoriTable').DataTable({
                responsive: true,
                dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>><"clear">>',
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                columnDefs: columnDefs,
                initComplete: function() {
                    $('.dataTables_length select').addClass('form-select-sm');
                    $('.dataTables_filter input').addClass('form-control-sm');
                    $('[title]').tooltip({
                        trigger: 'hover',
                        placement: 'top'
                    });
                }
            });
        });

        // Handle edit button click (using event delegation for dynamic content)
        $('#kategoriTable').on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var nama_en = $(this).data('nama-en');

            $('#edit_nama_kategori').val(nama);
            $('#edit_nama_kategori_en').val(nama_en);
            $('#editForm').attr('action', '<?= base_url($role . "/kategori/edit") ?>/' + id);

            $('#editKategoriModal').modal('show');
        });

        // Handle delete button click (using event delegation for dynamic content)
        $('#kategoriTable').on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            var url = '<?= base_url($role . "/kategori/delete") ?>/' + id;
            $('#confirmDelete').attr('href', url);
            $('#deleteModal').modal('show');
        });

        // Reinitialize tooltips when DataTable redraws
        table.on('draw', function() {
            $('[title]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
        });
    });
</script>

<?= $this->endSection('content') ?>