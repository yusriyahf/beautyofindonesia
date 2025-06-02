<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-book me-2 text-white"></i> Daftar Artikel</h1>
                    <p class="mb-0 opacity-75">Kelola konten artikel Anda dengan mudah</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <?php $role = session()->get('role'); ?>
                    <?php if (in_array($role, ['admin', 'penulis'])): ?>
                    <a href="<?= base_url($role . "/artikel/tambah") ?>" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-info">
                        <i class="fas fa-plus me-1"></i>Tambah Artikel
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Modern Filter Section -->
        <div class="card border-0 mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end"> <!-- Changed to align-items-end -->
                    <!-- Date Filter -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">TANGGAL PUBLISH</label>
                        <div class="input-group">
                            <input type="date" id="publish_date" class="form-control flatpickr-input" placeholder="Pilih tanggal">
                            <span class="input-group-text bg-transparent">
                                <i class="far fa-calendar-alt text-muted"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">KATEGORI</label>
                        <select id="kategoriFilter" class="form-select">
                            <option value="">Semua Kategori</option>
                            <?php
                            $uniqueCategories = [];
                            foreach ($all_data_artikel as $tampilArtikel) {
                                if (!in_array($tampilArtikel['nama_kategori'], $uniqueCategories)) {
                                    $uniqueCategories[] = $tampilArtikel['nama_kategori'];
                                    echo '<option value="' . esc($tampilArtikel['nama_kategori']) . '">' . esc($tampilArtikel['nama_kategori']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Search Field -->
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">CARI ARTIKEL</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Judul, penulis...">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-2 d-flex">
                        <button type="button" id="resetFilter" class="btn btn-outline-secondary me-2 flex-grow-1">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <button type="button" id="applyFilter" class="btn btn-info flex-grow-1 text-white">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($all_data_artikel)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-newspaper fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada artikel</h5>
                        <p class="text-muted mb-3">Mulai dengan membuat artikel baru</p>
                        <a href="<?= base_url($role ."/artikel/tambah") ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Artikel
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="artikelTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Judul Artikel</th>
                                    <th width="150">Kategori</th>
                                    <th width="120" class="text-center">Status</th>
                                    <th width="120">Penulis</th>
                                    <th width="120" class="text-center">Tanggal</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = $pager->getCurrentPage('artikel');
                                $offset = ($page - 1) * 10;
                                $i = $offset + 1;
                                foreach ($all_data_artikel as $tampilArtikel):
                                    $tglPublish = $tampilArtikel['tgl_publish'];
                                ?>
                                    <tr class="table-row"
                                        data-date="<?= date('Y-m-d', strtotime($tglPublish)) ?>"
                                        data-category="<?= esc($tampilArtikel['nama_kategori']) ?>"
                                        data-search="<?= strtolower(esc($tampilArtikel['judul_artikel'] . ' ' . $tampilArtikel['judul_artikel_en'] . ' ' . $tampilArtikel['nama_penulis'])) ?>">
                                        <td class="text-center text-muted"><?= $i++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($tampilArtikel['gambar_artikel'])): ?>
                                                    <div class="flex-shrink-0 me-2">
                                                        <img src="<?= base_url('uploads/artikel/' . $tampilArtikel['gambar_artikel']) ?>"
                                                            alt="Thumbnail" class="rounded" width="40" height="40">
                                                    </div>
                                                <?php endif; ?>
                                                <div class="flex-grow-1">
                                                    <div class="fw-medium text-truncate" style="max-width: 300px;"><?= esc($tampilArtikel['judul_artikel']) ?></div>
                                                    <small class="text-muted text-truncate d-block" style="max-width: 300px;"><?= esc($tampilArtikel['judul_artikel_en']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10">
                                                <?= esc($tampilArtikel['nama_kategori']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10">
                                                <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i>
                                                Published
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <span class="avatar-initials bg-light text-dark rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 24px; height: 24px; font-size: 10px;">
                                                        <?= strtoupper(substr($tampilArtikel['nama_penulis'] ?? 'P', 0, 1)) ?>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1 text-truncate" style="max-width: 100px;">
                                                    <?= esc($tampilArtikel['nama_penulis']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="text-dark fw-medium"><?= date('d', strtotime($tglPublish)) ?></div>
                                                <div class="text-muted small"><?= date('M Y', strtotime($tglPublish)) ?></div>
                                            </div>
                                        </td>
                                        
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="<?= base_url($role . '/artikel/detail/' . $tampilArtikel['id_artikel'] . '/' . $tampilArtikel['slug']) ?>"
                                                    class="btn btn-sm btn-outline-primary" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if (in_array($role, ['admin', 'penulis'])): ?>
                                                <a href="<?= base_url($role . '/artikel/edit/' . $tampilArtikel['id_artikel']) ?>"
                                                    class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger delete-btn"
                                                    title="Hapus" data-id="<?= $tampilArtikel['id_artikel'] ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if (!empty($all_data_artikel)): ?>
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan <?= $offset + 1 ?>-<?= min($offset + 10, count($all_data_artikel)) ?> dari <?= count($all_data_artikel) ?> data
                        </div>
                        <?= $pager->links('artikel', 'bootstrap_full') ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus artikel ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-sm btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling for the filter section */
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }

    .form-control,
    .form-select {
        border: 1px solid #e0e0e0;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4d90fe;
        box-shadow: 0 0 0 2px rgba(77, 144, 254, 0.2);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #e0e0e0;
    }

    .btn {
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }

    label {
        font-weight: 500;
    }

    .btn-sm {
        padding: 0.4rem 1rem;
        border-radius: 8px;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%,rgb(100, 181, 201) 100%);
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

    .badge {
        font-weight: 500;
        padding: 4px 8px;
    }

    .avatar-initials {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    .pagination {
        margin: 0;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .page-link {
        font-size: 14px;
        padding: 6px 12px;
    }

    @media (max-width: 768px) {
        .card-footer {
            flex-direction: column;
            gap: 10px;
        }

        .table td,
        .table th {
            padding: 8px 12px;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable (without paging to keep CI pagination)
        $('#artikelTable').DataTable({
            responsive: true,
            searching: false, // Disable DataTables search since we have custom search
            ordering: true,
            paging: false,
            info: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                    orderable: false,
                    targets: [6]
                } // Disable sorting for action column
            ],
            initComplete: function() {
                $('[title]').tooltip({
                    trigger: 'hover',
                    placement: 'top'
                });
            }
        });

        // Delete button handler
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            var url = '<?= base_url($role . "/artikel/delete/") ?>' + id;
            $('#confirmDelete').attr('href', url);
            $('#deleteModal').modal('show');
        });

        // Initialize tooltips
        $('[title]').tooltip({
            trigger: 'hover',
            placement: 'top'
        });

        // Filter functionality
        function applyFilters() {
            const dateFilter = $('#publish_date').val();
            const category = $('#kategoriFilter').val();
            const searchTerm = $('#searchInput').val().toLowerCase();

            $('.table-row').each(function() {
                const rowDate = $(this).data('date');
                const rowCategory = $(this).data('category');
                const rowSearch = $(this).data('search');

                // Date filter
                const datePass = !dateFilter || rowDate === dateFilter;

                // Category filter
                const categoryPass = !category || rowCategory === category;

                // Search filter
                const searchPass = !searchTerm || rowSearch.includes(searchTerm);

                // Show/hide based on filters
                if (datePass && categoryPass && searchPass) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Apply filter button
        $('#applyFilter').on('click', applyFilters);

        // Reset filter button
        $('#resetFilter').on('click', function() {
            $('#publish_date').val('');
            $('#kategoriFilter').val('');
            $('#searchInput').val('');
            applyFilters();
        });

        // Auto-apply filter when inputs change
        $('#publish_date, #kategoriFilter').on('change', applyFilters);
        $('#searchInput').on('keyup', applyFilters);

        // Initialize date picker
        flatpickr("#publish_date", {
            dateFormat: "Y-m-d",
            allowInput: true,
            onChange: function() {
                applyFilters();
            }
        });
    });
</script>

<?= $this->endSection('content'); ?>