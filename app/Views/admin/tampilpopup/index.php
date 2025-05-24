<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-window-restore me-2 text-white"></i> Daftar Tampil Popup</h1>
                    <p class="mb-0 opacity-75">Kelola aturan tampil popup di berbagai halaman website</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?php echo base_url() . "admin/tampilpopup/tambah" ?>" class="btn btn-light">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Tampil Popup
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="col">
            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Data Table Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($all_data_tampilpopup)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-window-restore fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada aturan tampil popup</h5>
                        <p class="text-muted mb-3">Tidak ada aturan tampil popup yang perlu dikelola</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="tampilPopupTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th class="text-center">URL Popup</th>
                                    <th class="text-center">Jenis URL</th>
                                    <th class="text-center">Nama Popup</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($all_data_tampilpopup as $tampilPopup) : ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $i++ ?></td>
                                        <td class="text-center">
                                            <?= isset($tampilPopup['url_tampil_popup']) ? esc($tampilPopup['url_tampil_popup']) : 'N/A' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($tampilPopup['jenis_url_tampil_popup'])) : ?>
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10">
                                                    <?= esc($tampilPopup['jenis_url_tampil_popup']) ?>
                                                </span>
                                            <?php else : ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?= isset($tampilPopup['nama_popup']) ? esc($tampilPopup['nama_popup']) : 'N/A' ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="<?= base_url('admin/tampilpopup/edit') . '/' . $tampilPopup['id_link_tampil_popup'] ?>" 
                                                   class="btn btn-sm btn-primary"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal<?= $tampilPopup['id_link_tampil_popup'] ?>"
                                                        title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $tampilPopup['id_link_tampil_popup'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $tampilPopup['id_link_tampil_popup'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $tampilPopup['id_link_tampil_popup'] ?>">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus aturan tampil popup ini?</p>
                                                    <ul class="mb-3">
                                                        <li>URL: <strong><?= esc($tampilPopup['url_tampil_popup'] ?? 'N/A') ?></strong></li>
                                                        <li>Jenis URL: <strong><?= esc($tampilPopup['jenis_url_tampil_popup'] ?? 'N/A') ?></strong></li>
                                                        <li>Popup: <strong><?= esc($tampilPopup['nama_popup'] ?? 'N/A') ?></strong></li>
                                                    </ul>
                                                    <p class="text-danger">Aksi ini tidak dapat dibatalkan!</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('admin/tampilpopup/delete') . '/' . $tampilPopup['id_link_tampil_popup'] ?>" class="btn btn-danger">
                                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling for the dashboard */
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
    
    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }
    
    /* Enhanced DataTables Styling */
    .dataTables_wrapper {
        padding: 1.5rem;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 6px;
        margin: 0 2px;
    }
    
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
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#tampilPopupTable').DataTable({
            responsive: true,
            searching: true,
            ordering: true,
            paging: true,
            info: true,
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
    });
</script>

<?= $this->endSection('content') ?>