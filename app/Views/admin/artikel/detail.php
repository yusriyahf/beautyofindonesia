<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <!-- Header Section -->
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <div class="page-header">
                    <h1 class="app-page-title mb-2 fw-bold">Detail Artikel</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item small"><a href="<?= base_url('admin/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item small"><a href="<?= base_url('admin/artikel') ?>" class="text-decoration-none">Manajemen Artikel</a></li>
                            <li class="breadcrumb-item small active" aria-current="page">Detail Artikel</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="<?= base_url('admin/artikel/edit/' . $artikel['id_artikel']) ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit Artikel
                    </a>
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item small" href="#"><i class="fas fa-edit me-1"></i> Edit Artikel</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item small text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash-alt me-2"></i> Hapus
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row g-4">
    <div class="col-lg-8">
        <!-- Main Article Card -->
        <div class="app-card app-card-detail shadow-sm mb-4">
            <div class="app-card-header px-4 py-3">
                <h4 class="app-card-title mb-0 fw-semibold">Informasi Utama</h4>
            </div>
            <div class="app-card-body p-4">
                <!-- Article Image -->
                <div class="article-image mb-4 text-center">
                    <img src="<?= base_url('uploads/artikel/' . $artikel['foto_artikel']) ?>" 
                         class="img-fluid rounded-3 shadow-sm" 
                         alt="<?= esc($artikel['judul_artikel']) ?>"
                         style="max-height: 400px; object-fit: cover;">
                    <div class="image-source mt-2 text-muted small">
                        Sumber Foto: <?= !empty($artikel['sumber_foto']) ? esc($artikel['sumber_foto']) : '-' ?>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- Judul Artikel -->
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label class="form-label text-uppercase text-muted small fw-bold mb-1">Judul (ID)</label>
                            <p class="fw-bold mb-0"><?= esc($artikel['judul_artikel']) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label class="form-label text-uppercase text-muted small fw-bold mb-1">Judul (EN)</label>
                            <p class="fw-bold mb-0"><?= esc($artikel['judul_artikel_en']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deskripsi Artikel Accordion -->
        <div class="app-card app-card-detail shadow-sm mb-4">
            <div class="accordion" id="descAccordionid">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="headingOneid">
                        <button class="accordion-button bg-light fw-semibold px-4 py-3" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#collapseOneid" 
                                aria-expanded="true" aria-controls="collapseOneid">
                            Deskripsi Artikel (ID)
                        </button>
                    </h2>
                    <div id="collapseOneid" class="accordion-collapse collapse" 
                         aria-labelledby="headingOneid" data-bs-parent="#descAccordionid">
                        <div class="accordion-body px-4 py-3">
                            <div class="article-content" style="font-size: 0.95rem; line-height: 1.7;">
                                <?= $artikel['deskripsi_artikel'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deskripsi Artikel Accordion -->
        <div class="app-card app-card-detail shadow-sm mb-4">
            <div class="accordion" id="descAccordionen">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="headingOneen">
                        <button class="accordion-button bg-light fw-semibold px-4 py-3" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#collapseOneen" 
                                aria-expanded="true" aria-controls="collapseOneen">
                            Deskripsi Artikel (EN)
                        </button>
                    </h2>
                    <div id="collapseOneen" class="accordion-collapse collapse" 
                         aria-labelledby="headingOneen" data-bs-parent="#descAccordionen">
                        <div class="accordion-body px-4 py-3">
                            <div class="article-content" style="font-size: 0.95rem; line-height: 1.7;">
                                <?= $artikel['deskripsi_artikel'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tags Card -->
        <div class="app-card app-card-detail shadow-sm mb-4">
            <div class="app-card-header px-4 py-3">
                <h4 class="app-card-title mb-0 fw-semibold">Tag Artikel</h4>
            </div>
            <div class="app-card-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label text-uppercase text-muted small fw-bold mb-2">Tag (Indonesia)</label>
                        <div class="tags mb-3">
                            <?php if (!empty($artikel['tags'])): ?>
                                <?php foreach (explode(',', $artikel['tags']) as $tag): ?>
                                    <span class="badge bg-light text-dark me-1 mb-1 px-2 py-1 small">
                                        <i class="fas fa-tag me-1"></i><?= esc(trim($tag)) ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted small">Tidak ada tag</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-uppercase text-muted small fw-bold mb-2">Tag (English)</label>
                        <div class="tags">
                            <?php if (!empty($artikel['tags_en'])): ?>
                                <?php foreach (explode(',', $artikel['tags_en']) as $tag): ?>
                                    <span class="badge bg-light text-dark me-1 mb-1 px-2 py-1 small">
                                        <i class="fas fa-tag me-1"></i><?= esc(trim($tag)) ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted small">No tags</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Column -->
    <div class="col-lg-4">
        <!-- Metadata Card -->
        <div class="app-card app-card-detail shadow-sm mb-4">
            <div class="app-card-header px-4 py-3">
                <h4 class="app-card-title mb-0 fw-semibold">Metadata Artikel</h4>
            </div>
            <div class="app-card-body p-4">
                <div class="metadata-list">
                    <div class="metadata-item d-flex mb-3">
                        <div class="metadata-icon me-3 text-primary">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <div>
                            <div class="text-muted small">ID Artikel</div>
                            <div class="fw-semibold small"><?= esc($artikel['id_artikel']) ?></div>
                        </div>
                    </div>

                    <div class="metadata-item d-flex mb-3">
                        <div class="metadata-icon me-3 text-primary">
                            <i class="fas fa-folder"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Kategori</div>
                            <div class="fw-semibold small"><?= esc($kategori['nama_kategori'] ?? '-') ?></div>
                        </div>
                    </div>

                    <div class="metadata-item d-flex mb-3">
                        <div class="metadata-icon me-3 text-primary">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Penulis</div>
                            <div class="fw-semibold small"><?= esc($penulis['nama'] ?? '-') ?></div>
                        </div>
                    </div>

                    <div class="metadata-item d-flex mb-3">
                        <div class="metadata-icon me-3 text-primary">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Tanggal Publish</div>
                            <div class="fw-semibold small">
                                <?= date('d M Y H:i', strtotime($artikel['tgl_publish'])) ?>
                            </div>
                        </div>
                    </div>

                    <div class="metadata-item d-flex">
                        <div class="metadata-icon me-3 text-primary">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Views</div>
                            <div class="fw-semibold small">
                                <?= number_format($artikel['views'], 0, ',', '.') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Information Card -->
        <div class="app-card app-card-detail shadow-sm mb-4">
            <div class="accordion" id="seoAccordion">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="headingSEO">
                        <button class="accordion-button bg-light fw-semibold px-4 py-3 collapsed" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#collapseSEO" 
                                aria-expanded="false" aria-controls="collapseSEO">
                            <i class="fas fa-search me-2"></i>Informasi SEO
                        </button>
                    </h2>
                    <div id="collapseSEO" class="accordion-collapse collapse" 
                         aria-labelledby="headingSEO" data-bs-parent="#seoAccordion">
                        <div class="accordion-body px-4 py-3">
                            <div class="mb-3">
                                <label class="form-label small fw-bold mb-1">Slug (ID)</label>
                                <div class="p-2 bg-light rounded small font-monospace">
                                    <?= esc($artikel['slug']) ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold mb-1">Meta Title (ID)</label>
                                <div class="p-2 bg-light rounded small">
                                    <?= esc($artikel['meta_title_id']) ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold mb-1">Meta Description (ID)</label>
                                <div class="p-2 bg-light rounded small">
                                    <?= esc($artikel['meta_description_id']) ?>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label small fw-bold mb-1">Slug (EN)</label>
                                <div class="p-2 bg-light rounded small font-monospace">
                                    <?= esc($artikel['slug_en']) ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold mb-1">Meta Title (EN)</label>
                                <div class="p-2 bg-light rounded small">
                                    <?= esc($artikel['meta_title_en']) ?>
                                </div>
                            </div>
                            <div>
                                <label class="form-label small fw-bold mb-1">Meta Description (EN)</label>
                                <div class="p-2 bg-light rounded small">
                                    <?= esc($artikel['meta_description_en']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- [Iklan Status and Quick Actions cards remain the same] -->
    </div>
</div>

<!-- [Rest of the code remains the same] -->

<style>
    /* Improved styling */
    .metadata-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .metadata-item:last-child {
        border-bottom: none;
    }
    
    .metadata-icon {
        width: 24px;
        text-align: center;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #333;
    }
    
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,0.1);
    }
    
    .font-monospace {
        font-family: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
    }
    
    .tags .badge {
        transition: all 0.2s;
    }
    
    .tags .badge:hover {
        background-color: #e9ecef !important;
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.25rem;
        margin: 0.5rem 0;
    }
</style>
<?= $this->endSection(); ?>