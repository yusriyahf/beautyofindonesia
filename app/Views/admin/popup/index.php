<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header with Gradient -->
        <div class="dashboard-header bg-gradient-primary rounded-4 p-4 mb-4 text-white shadow">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2 text-white"><i class="fas fa-window-restore me-2 text-white"></i> Daftar Popup</h1>
                    <p class="mb-0 opacity-75">Kelola semua popup yang muncul di website</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?php echo base_url() . "admin/popup/tambah" ?>" class="btn btn-light">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Popup
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
                <?php if (empty($all_data_popup)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-window-restore fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum ada popup</h5>
                        <p class="text-muted mb-3">Tidak ada popup yang perlu ditampilkan</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="popupTable" class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40" class="text-center">No</th>
                                    <th class="text-center">Nama Popup</th>
                                    <th class="text-center">Judul Popup</th>
                                    <th class="text-center">Link</th>
                                    <th class="text-center">Tombol</th>
                                    <th class="text-center">Gambar</th>
                                    <th width="140" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($all_data_popup as $popup) : ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $i++ ?></td>
                                        <td class="text-center">
                                            <?= isset($popup['nama_popup']) ? esc($popup['nama_popup']) : 'N/A' ?>
                                        </td>
                                        <td class="text-center">
                                            <?= isset($popup['title_popup']) ? esc($popup['title_popup']) : 'N/A' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($popup['link_popup'])) : ?>
                                                <a href="<?= esc($popup['link_popup']) ?>" target="_blank" class="text-primary">
                                                    <i class="fas fa-external-link-alt me-1"></i> Link
                                                </a>
                                            <?php else : ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?= isset($popup['nama_tombol']) ? esc($popup['nama_tombol']) : 'N/A' ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <div class="popup-thumbnail" 
                                                     style="background-image: url('<?= base_url() . 'uploads/popups/' . (isset($popup['foto_popup']) ? esc($popup['foto_popup']) : 'default.jpg') ?>');"
                                                     data-bs-toggle="modal" 
                                                     data-bs-target="#imageModal<?= $popup['id_popup'] ?>">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="<?= base_url('admin/popup/edit') . '/' . $popup['id_popup'] ?>" 
                                                   class="btn btn-sm btn-primary"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal<?= $popup['id_popup'] ?>"
                                                        title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Image Preview Modal -->
                                    <div class="modal fade" id="imageModal<?= $popup['id_popup'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Preview Gambar Popup</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="<?= base_url() . 'uploads/popups/' . (isset($popup['foto_popup']) ? esc($popup['foto_popup']) : 'default.jpg') ?>" 
                                                         class="img-fluid rounded" 
                                                         alt="Popup Image">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $popup['id_popup'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $popup['id_popup'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $popup['id_popup'] ?>">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda yakin ingin menghapus popup ini?</p>
                                                    <ul class="mb-3">
                                                        <li>Nama: <strong><?= esc($popup['nama_popup'] ?? 'N/A') ?></strong></li>
                                                        <li>Judul: <strong><?= esc($popup['title_popup'] ?? 'N/A') ?></strong></li>
                                                    </ul>
                                                    <p class="text-danger">Aksi ini tidak dapat dibatalkan!</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <a href="<?= base_url('admin/popup/delete') . '/' . $popup['id_popup'] ?>" class="btn btn-danger">
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
    
    .popup-thumbnail {
        width: 80px;
        height: 80px;
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
        border: 1px solid #e0e0e0;
    }
    
    .popup-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        $('#popupTable').DataTable({
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
                targets: [5, 6] // Disable sorting for image and action columns
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