<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-gift me-2 text-white"></i> Kelola Oleh-Oleh</h1>
                    <p class="mb-0 opacity-75">Kelola semua produk oleh-oleh di website Anda</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= base_url('admin/oleh_oleh/tambah') ?>" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm text-info">
                        <i class="fas fa-plus me-1"></i>Tambah Oleh-Oleh
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter & Search Form -->
<div class="card border-0 mb-4">
    <div class="card-body p-4">
        <div class="row g-3 align-items-end">
            <!-- Category Filter -->
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">KATEGORI</label>
                <select id="kategoriFilter" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php
                    $uniqueCategories = [];
                    foreach ($data_oleh_oleh as $item) {
                        if (!in_array($item['nama_kategori_oleholeh'], $uniqueCategories)) {
                            $uniqueCategories[] = $item['nama_kategori_oleholeh'];
                            echo '<option value="' . esc($item['nama_kategori_oleholeh']) . '">' . esc($item['nama_kategori_oleholeh']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Location Filter -->
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">LOKASI</label>
                <select id="lokasiFilter" class="form-select">
                    <option value="">Semua Lokasi</option>
                    <?php
                    $uniqueLocations = [];
                    foreach ($data_oleh_oleh as $item) {
                        if (!in_array($item['nama_kotakabupaten'], $uniqueLocations)) {
                            $uniqueLocations[] = $item['nama_kotakabupaten'];
                            echo '<option value="' . esc($item['nama_kotakabupaten']) . '">' . esc($item['nama_kotakabupaten']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Search Field -->
            <div class="col-md-4">
                <label class="form-label small text-muted mb-1">CARI OLEH-OLEH</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Nama, lokasi...">
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Oleh-Oleh Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($data_oleh_oleh)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-gift fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada oleh-oleh</h5>
                        <p class="text-muted mb-3">Mulai dengan menambahkan oleh-oleh baru</p>
                        <a href="<?= base_url('admin/oleh_oleh/tambah') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Oleh-Oleh
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="olehOlehTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th>Nama Oleh-Oleh</th>
                                    <th width="150">Kategori</th>
                                    <th width="150">Lokasi</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = $pager->getCurrentPage('oleholeh');
                                $offset = ($page - 1) * 10;
                                $i = $offset + 1;
                                foreach ($data_oleh_oleh as $item): ?>
                                    <tr class="table-row"
                                        data-category="<?= esc($item['nama_kategori_oleholeh']) ?>"
                                        data-location="<?= esc($item['nama_kotakabupaten']) ?>"
                                        data-search="<?= strtolower(esc($item['nama_oleholeh'] . ' ' . $item['nama_oleholeh_eng'] . ' ' . $item['nama_kotakabupaten'])) ?>">
                                        <td class="text-center text-muted"><?= $i++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <img src="<?= base_url('assets-baru/img/foto_oleholeh/' . ($item['foto_oleholeh'] ?? 'default.jpg')) ?>"
                                                        class="rounded"
                                                        width="40"
                                                        height="40"
                                                        alt="<?= $item['nama_oleholeh'] ?>">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-medium text-truncate" style="max-width: 300px;"><?= esc($item['nama_oleholeh']) ?></div>
                                                    <small class="text-muted text-truncate d-block" style="max-width: 300px;"><?= esc($item['nama_oleholeh_eng']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10">
                                                <?= esc($item['nama_kategori_oleholeh']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                                </div>
                                                <div class="flex-grow-1 text-truncate" style="max-width: 120px;">
                                                    <?= esc($item['nama_kotakabupaten']) ?>
                                                </div>
                                            </div>
                                            <small class="text-muted d-block">
                                                <?= $item['oleholeh_latitude'] ?>, <?= $item['oleholeh_longitude'] ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="<?= base_url('admin/oleh_oleh/detail/' . $item['slug_oleholeh']) ?>"
                                                    class="btn btn-sm btn-outline-primary" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/oleh_oleh/edit/' . $item['id_oleholeh']) ?>"
                                                    class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger delete-btn"
                                                    title="Hapus"
                                                    data-id="<?= $item['id_oleholeh'] ?>"
                                                    data-name="<?= esc($item['nama_oleholeh']) ?>">
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

            <!-- Pagination -->
            <?php if (!empty($data_oleh_oleh)): ?>
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Menampilkan <?= $offset + 1 ?>-<?= min($offset + 10, count($data_oleh_oleh)) ?> dari <?= count($data_oleh_oleh) ?> data
                        </div>

                        <?= $pager->links('oleholeh', 'bootstrap_full') ?>
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
                <p class="mb-0">Apakah Anda yakin ingin menghapus <strong id="oleholehName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-sm btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling */
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
        $('#olehOlehTable').DataTable({
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
                    targets: [4]
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
            var name = $(this).data('name');
            var url = '<?= base_url("admin/oleh_oleh/delete/") ?>' + id;
            $('#oleholehName').text(name);
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
            const category = $('#kategoriFilter').val();
            const location = $('#lokasiFilter').val();
            const searchTerm = $('#searchInput').val().toLowerCase();

            $('.table-row').each(function() {
                const rowCategory = $(this).data('category');
                const rowLocation = $(this).data('location');
                const rowSearch = $(this).data('search');

                // Category filter
                const categoryPass = !category || rowCategory === category;

                // Location filter
                const locationPass = !location || rowLocation === location;

                // Search filter
                const searchPass = !searchTerm || rowSearch.includes(searchTerm);

                // Show/hide based on filters
                if (categoryPass && locationPass && searchPass) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Apply filter when inputs change
        $('#kategoriFilter, #lokasiFilter').on('change', applyFilters);
        $('#searchInput').on('keyup', applyFilters);
    });
</script>

<?= $this->endSection('content'); ?>