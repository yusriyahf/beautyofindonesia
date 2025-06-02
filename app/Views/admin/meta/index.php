<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header dengan Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-tags me-2 text-white"></i> Manajemen Meta</h1>
                    <p class="mb-0 opacity-75">Kelola meta title dan description untuk berbagai halaman website</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?php echo base_url() . "admin/meta/tambah" ?>" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm">
                        <i class="fas fa-plus me-2"></i> Tambah Meta
                    </a>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card stat-card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Halaman</h6>
                                <h3 class="mb-0"><?= count($all_data_meta) ?></h3>
                            </div>
                            <div class="stat-icon bg-primary-light rounded-4">
                                <i class="fas fa-file-alt text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Meta Bahasa Indonesia</h6>
                                <h3 class="mb-0"><?= count($all_data_meta) ?></h3>
                            </div>
                            <div class="stat-icon bg-success-light rounded-4">
                                <i class="fas fa-language text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Meta Bahasa Inggris</h6>
                                <h3 class="mb-0"><?= count($all_data_meta) ?></h3>
                            </div>
                            <div class="stat-icon bg-info-light rounded-4">
                                <i class="fas fa-globe text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>
                        <strong>Sukses!</strong> <?= session()->getFlashdata('success') ?>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>
                        <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tabel Meta -->
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
            <div class="card-header bg-white p-4 border-0">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0"><i class="fas fa-tags text-primary me-2"></i> Data Meta</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2">
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text bg-light border-0 rounded-start-pill"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control border-0 bg-light rounded-end-pill" id="searchInput" placeholder="Cari...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="metaTable" class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="40">No</th>
                                <th>Nama Halaman</th>
                                <th>Meta Title (ID)</th>
                                <th>Meta Description (ID)</th>
                                <th>Meta Title (EN)</th>
                                <th>Meta Description (EN)</th>
                                <th width="140" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($all_data_meta as $tampilMeta) : ?>
                                <tr>
                                    <td class="text-muted"><?= $i ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="transaction-icon bg-primary-light text-primary rounded-3 p-2 me-3">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?= esc($tampilMeta->nama_halaman) ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= esc($tampilMeta->meta_title_id) ?></small>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= esc($tampilMeta->meta_description_id) ?></small>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= esc($tampilMeta->meta_title_en) ?></small>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= esc($tampilMeta->meta_description_en) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/meta/edit') . '/' . $tampilMeta->id_seo ?>" class="btn btn-sm btn-outline-primary rounded-pill me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteMetaModal<?= $tampilMeta->id_seo ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Hapus Meta -->
                                <div class="modal fade" id="deleteMetaModal<?= $tampilMeta->id_seo ?>" tabindex="-1" aria-labelledby="deleteMetaModalLabel<?= $tampilMeta->id_seo ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header bg-danger text-white rounded-top-4">
                                                <h5 class="modal-title" id="deleteMetaModalLabel<?= $tampilMeta->id_seo ?>">
                                                    <i class="fas fa-trash me-2"></i> Hapus Meta
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?= base_url('admin/meta/delete') . '/' . $tampilMeta->id_seo ?>" method="POST">
                                                <div class="modal-body">
                                                    <?= csrf_field(); ?>
                                                    <p>Anda yakin ingin menghapus meta untuk halaman <strong><?= esc($tampilMeta->nama_halaman) ?></strong>?</p>
                                                    <div class="alert alert-warning mt-3 rounded-4">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        Penghapusan meta akan mempengaruhi SEO halaman ini.
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Gradient Header */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Stat Cards */
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1) !important;
    }

    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.1) !important;
    }

    /* Transaction Table */
    .transaction-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Empty State */
    .empty-state {
        opacity: 0.6;
    }

    /* Rounded Elements */
    .rounded-4 {
        border-radius: 1rem !important;
    }

    /* Enhanced Table Styling */
    .table {
        font-size: 14px;
        margin-bottom: 0;
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

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .dashboard-header {
            text-align: center;
        }

        .dashboard-header .text-md-end {
            text-align: center !important;
            margin-top: 1rem;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }

    .dataTables_wrapper .dataTables_length label {
        font-weight: normal;
        text-align: left;
        white-space: nowrap;
        padding: 2% 3%;
    }

    .dataTables_wrapper .dataTables_info {
        padding: 3%;
    }

    .dataTables_wrapper .dataTables_paginate ul.pagination {
        margin: 2px 3% !important;
        white-space: nowrap;
        justify-content: flex-end;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#metaTable').DataTable({
            responsive: true,
            searching: false,
            ordering: true,
            paging: true,
            info: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                orderable: false,
                targets: [6] // Disable sorting for action column
            }],
            initComplete: function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });

        // Search functionality
        $('#searchInput').keyup(function() {
            $('#metaTable').DataTable().search($(this).val()).draw();
        });

        // Auto close alerts after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    });
</script>

<?= $this->endSection('content') ?>