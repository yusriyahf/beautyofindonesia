<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="col-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="app-page-title mb-0">Edit Artikel</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item small"><a href="<?= base_url('admin/dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item small"><a href="<?= base_url('admin/artikel') ?>" class="text-decoration-none">Manajemen Artikel</a></li>
                            <li class="breadcrumb-item small active" aria-current="page">Edit Artikel</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <?php $role = session()->get('role'); ?>
                    <a href="<?= base_url($role . '/artikel') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-8">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-header mb-4">
                        <h4 class="app-card-title">
                            <i class="fas fa-edit me-2"></i>Form Edit Artikel
                        </h4>
                    </div>

                    <div class="app-card-body">
                        <?php $role = session()->get('role'); ?>
                        <form action="<?= base_url($role . '/artikel/proses_edit/' . $artikelData['id_artikel']) ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs mb-4" id="artikelTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="indonesia-tab" data-bs-toggle="tab" data-bs-target="#indonesia" type="button" role="tab">
                                        <i class="fas fa-flag me-1"></i> Indonesia
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button" role="tab">
                                        <i class="fas fa-flag-usa me-1"></i> English
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="meta-tab" data-bs-toggle="tab" data-bs-target="#meta" type="button" role="tab">
                                        <i class="fas fa-tags me-1"></i> SEO & Media
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="artikelTabContent">
                                <!-- Indonesia Tab -->
                                <div class="tab-pane fade show active" id="indonesia" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Judul Artikel</label>
                                        <input type="text" class="form-control form-control-lg" id="judul_artikel" name="judul_artikel" value="<?= $artikelData['judul_artikel']; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi_artikel" class="form-label fw-bold">Deskripsi Artikel</label>
                                        <textarea class="form-control tiny" id="deskripsi_artikel" name="deskripsi_artikel" rows="8"><?= $artikelData['deskripsi_artikel']; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tags</label>
                                        <input type="text" class="form-control" id="tags" name="tags" value="<?= $artikelData['tags']; ?>">
                                        <small class="text-muted">Pisahkan dengan koma (contoh: teknologi,berita,update)</small>
                                    </div>
                                </div>

                                <!-- English Tab -->
                                <div class="tab-pane fade" id="english" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Judul Artikel (English)</label>
                                        <input type="text" class="form-control form-control-lg" id="judul_artikel_en" name="judul_artikel_en" value="<?= $artikelData['judul_artikel_en']; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi_artikel_en" class="form-label fw-bold">Deskripsi Artikel (English)</label>
                                        <textarea class="form-control tiny" id="deskripsi_artikel_en" name="deskripsi_artikel_en" rows="8"><?= $artikelData['deskripsi_artikel_en']; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tags (English)</label>
                                        <input type="text" class="form-control" id="tags_en" name="tags_en" value="<?= $artikelData['tags_en']; ?>">
                                        <small class="text-muted">Separate with commas (ex: technology,news,update)</small>
                                    </div>
                                </div>

                                <!-- SEO & Media Tab -->
                                <div class="tab-pane fade" id="meta" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Meta Title (ID)</label>
                                            <input type="text" class="form-control" id="meta_title_id" name="meta_title_id" value="<?= $artikelData['meta_title_id'] ?? ''; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Meta Title (EN)</label>
                                            <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" value="<?= $artikelData['meta_title_en'] ?? ''; ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Meta Deskripsi (ID)</label>
                                            <textarea class="form-control" id="meta_description_id" name="meta_description_id" rows="3"><?= $artikelData['meta_description_id'] ?? ''; ?></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Meta Deskripsi (EN)</label>
                                            <textarea class="form-control" id="meta_description_en" name="meta_description_en" rows="3"><?= $artikelData['meta_description_en'] ?? ''; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Publish</label>
                                        <input type="date" class="form-control" id="tgl_publish" name="tgl_publish" value="<?= old('tgl_publish') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Foto Artikel</label>
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <img width="150" class="img-thumbnail rounded" src="<?= base_url("assets-baru/img/" . $artikelData['foto_artikel']); ?>">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <input type="file" class="form-control" id="foto_artikel" name="foto_artikel">
                                                        <?= $validation->getError('foto_artikel') ?>
                                                        <div class="mt-2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-info-circle me-1"></i>
                                                                Ukuran foto minimal 572x572 pixels, format JPG/PNG/JPEG
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Footer -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div>
                                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                        <div class="alert alert-success mb-0" role="alert">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <?= session()->getFlashdata('success') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Column -->
            <div class="col-12 col-md-4">
                <div class="app-card app-card-settings shadow-sm p-4 h-100">
                    <div class="app-card-header mb-4">
                        <h4 class="app-card-title">
                            <i class="fas fa-eye me-2"></i>Preview Artikel
                        </h4>
                    </div>
                    <div class="app-card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Perubahan akan terlihat setelah disimpan
                        </div>
                        <div class="card border-0 shadow-sm mb-3">
                            <img src="<?= base_url("assets-baru/img/foto_artikel/" . $artikelData['foto_artikel']); ?>" class="card-img-top" alt="Preview">
                            <div class="card-body">
                                <h5 class="card-title"><?= $artikelData['judul_artikel']; ?></h5>
                                <p class="card-text text-muted small">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?= date('d F Y', strtotime($artikelData['tgl_publish'])); ?>
                                </p>
                                <div class="card-text">
                                    <?= substr(strip_tags($artikelData['deskripsi_artikel']), 0, 150) ?>...
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <?php if (!empty($artikelData['tags'])): ?>
                                <?php $tags = explode(',', $artikelData['tags']); ?>
                                <?php foreach ($tags as $tag): ?>
                                    <span class="badge bg-secondary"><?= trim($tag) ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Style untuk Tab Navigation */
.nav-tabs {
    border-bottom: 2px solid #e9ecef;
    padding: 0;
    margin-bottom: 25px;
}

.nav-tabs .nav-item {
    margin-bottom: -2px;
}

.nav-tabs .nav-link {
    border: none;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 14px;
    color: #6c757d;
    background-color: transparent;
    border-radius: 8px 8px 0 0;
    margin-right: 5px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.nav-tabs .nav-link i {
    margin-right: 8px;
    font-size: 16px;
}

.nav-tabs .nav-link:hover {
    color: #ff8c00;
    background-color: rgba(255, 140, 0, 0.05);
    border-color: transparent;
}

.nav-tabs .nav-link.active {
    color: #ff8c00;
    background-color: #fff;
    border: none;
    position: relative;
}

.nav-tabs .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(135deg, #ff8c00, #ffd700);
    border-radius: 3px 3px 0 0;
}

/* Efek hover yang lebih halus */
.nav-tabs .nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(255, 140, 0, 0.1), rgba(255, 215, 0, 0.05));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.nav-tabs .nav-link:hover::before {
    opacity: 1;
}

/* Responsive design */
@media (max-width: 768px) {
    .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 5px;
    }
    
    .nav-tabs .nav-link {
        padding: 10px 15px;
        font-size: 13px;
    }
    
    .nav-tabs .nav-link i {
        margin-right: 5px;
        font-size: 14px;
    }
}

/* Animasi saat tab aktif berubah */
.tab-content > .tab-pane {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
<?= $this->endSection('content') ?>