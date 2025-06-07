<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-map-marked-alt me-2 text-white"></i> Kelola Tempat Wisata</h1>
                    <p class="mb-0 opacity-75">Kelola semua tujuan wisata di website Anda</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <?php $role = session()->get('role'); ?>
                    <?php if (in_array($role, ['admin', 'penulis'])): ?>
                    <a href="<?= base_url($role . '/tempat_wisata/tambah') ?>" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-info">
                        <i class="fas fa-plus me-1"></i>Tambah Wisata
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Modern Filter Section -->
        <div class="card border-0 mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <!-- Location Filter -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">LOKASI</label>
                        <select id="locationFilter" class="form-select">
                            <option value="">Semua Lokasi</option>
                            <?php
                            $uniqueLocations = [];
                            foreach ($wisata as $item) {
                                if (!in_array($item['nama_kotakabupaten'], $uniqueLocations)) {
                                    $uniqueLocations[] = $item['nama_kotakabupaten'];
                                    echo '<option value="' . esc($item['nama_kotakabupaten']) . '">' . esc($item['nama_kotakabupaten']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">KATEGORI</label>
                        <select id="kategoriFilter" class="form-select">
                            <option value="">Semua Kategori</option>
                            <?php
                            $uniqueCategories = [];
                            foreach ($wisata as $item) {
                                if (!in_array($item['nama_kategori_wisata'], $uniqueCategories)) {
                                    $uniqueCategories[] = $item['nama_kategori_wisata'];
                                    echo '<option value="' . esc($item['nama_kategori_wisata']) . '">' . esc($item['nama_kategori_wisata']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Search Field -->
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">CARI TEMPAT WISATA</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Nama wisata...">
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

        <!-- Tourism Places Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($wisata)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-map-marked-alt fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada tempat wisata</h5>
                        <p class="text-muted mb-3">Mulai dengan menambahkan tempat wisata baru</p>
                        <a href="<?= base_url($role . '/tempat_wisata/tambah') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Wisata
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="wisataTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Nama Tempat Wisata</th>
                                    <th width="150">Kategori</th>
                                    <th width="150">Lokasi</th>
                                    <th width="120" class="text-center">Status</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = $pager->getCurrentPage('tempatwisata');
                                $offset = ($page - 1) * 10;
                                $i = $offset + 1;
                                foreach ($wisata as $w): ?>
                                    <tr class="table-row"
                                        data-location="<?= esc($w['nama_kotakabupaten']) ?>"
                                        data-category="<?= esc($w['nama_kategori_wisata']) ?>"
                                        data-search="<?= strtolower(esc($w['nama_wisata_ind'] . ' ' . $w['nama_wisata_eng'])) ?>">
                                        <td class="text-center text-muted"><?= $i++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <img src="<?= base_url('asset-user/uploads/foto_wisata/' . ($w['foto_wisata'] ?? 'default.jpg')) ?>"
                                                        class="rounded" width="40" height="40"
                                                        alt="<?= $w['nama_wisata_ind'] ?>"
                                                        onerror="this.src='<?= base_url('asset-user/uploads/foto_wisata/default.jpg') ?>'">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-medium text-truncate" style="max-width: 300px;"><?= esc($w['nama_wisata_ind']) ?></div>
                                                    <small class="text-muted text-truncate d-block" style="max-width: 300px;"><?= esc($w['nama_wisata_eng']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10">
                                                <?= esc($w['nama_kategori_wisata']) ?>
                                            </span>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 mt-1 d-block">
                                                <?= esc($w['nama_kategori_wisata_en']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-medium"><?= esc($w['nama_kotakabupaten']) ?></div>
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?= $w['wisata_latitude'] ?>, <?= $w['wisata_longitude'] ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10">
                                                <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i>
                                                Aktif
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="<?= base_url($role . '/tempat_wisata/detail/' . $w['id_wisata']) ?>"
                                                    class="btn btn-sm btn-outline-primary" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if (in_array($role, ['admin', 'penulis'])): ?>
                                                <a href="<?= base_url($role . '/tempat_wisata/edit/' . $w['id_wisata']) ?>"
                                                    class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger delete-btn"
                                                    title="Hapus" data-id="<?= $w['id_wisata'] ?>">
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
            <?php if (!empty($wisata)): ?>
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan <?= $offset + 1 ?>-<?= min($offset + 10, count($wisata)) ?> dari <?= count($wisata) ?> data
                        </div>

                        <?= $pager->links('tempatwisata', 'bootstrap_full') ?>
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
                <p class="mb-0">Apakah Anda yakin ingin menghapus tempat wisata ini?</p>
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
        background: linear-gradient(135deg, #667eea 0%, rgb(100, 181, 201) 100%);
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
        $('#wisataTable').DataTable({
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
                       targets: [5]
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
            var url = '<?= base_url($role . "/tempat_wisata/delete/") ?>' + id;
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
            const location = $('#locationFilter').val();
            const category = $('#kategoriFilter').val();
            const searchTerm = $('#searchInput').val().toLowerCase();

            $('.table-row').each(function () {
                const rowLocation = $(this).data('location');
                const rowCategory = $(this).data('category');
                const rowName = $(this).data('search'); // nama tempat wisata

                // Location filter
                const locationPass = !location || rowLocation === location;

                // Category filter
                const categoryPass = !category || rowCategory === category;

                // Search filter (hanya berdasarkan nama wisata, bukan lokasi)
                const searchPass = !searchTerm || rowName.toLowerCase().includes(searchTerm);

                // Show/hide based on filters
                if (locationPass && categoryPass && searchPass) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Apply filter button
        $('#applyFilter').on('click', applyFilters);

        // Reset filter button
        $('#resetFilter').on('click', function () {
            $('#locationFilter').val('');
            $('#kategoriFilter').val('');
            $('#searchInput').val('');
            applyFilters();
        });

        // Auto-apply filter when inputs change
        $('#locationFilter, #kategoriFilter').on('change', applyFilters);
        $('#searchInput').on('keyup', applyFilters);
    });
</script>

<?= $this->endSection('content'); ?>