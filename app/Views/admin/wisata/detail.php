<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Detail Tempat Wisata</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/tempat_wisata') ?>">Tempat Wisata</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('admin/tempat_wisata/index') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>

        <div class="app-card app-card-orders-table shadow-sm mb-5">
            <div class="app-card-body p-4">
                <div class="row">
                    <!-- Main Information Column -->
                    <div class="col-lg-8">
                        <!-- Basic Information Card -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-semibold text-primary"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Nama Wisata (Indonesian)</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $wisata['nama_wisata_ind'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Nama Wisata (English)</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $wisata['nama_wisata_eng'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Kategori Wisata (Indonesian)</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $kategori->nama_kategori_wisata ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Kategori Wisata (English)</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $kategori->nama_kategori_wisata_en ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Kabupaten</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $kotakabupaten['nama_kotakabupaten'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Sumber Foto</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $wisata['sumber_foto'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Koordinat</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                                Latitude: <?= $wisata['wisata_latitude'] ?>, Longitude: <?= $wisata['wisata_longitude'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Accordion -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-semibold text-primary"><i class="fas fa-align-left me-2"></i>Description</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="accordion accordion-flush" id="descriptionAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingInd">
                                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInd" aria-expanded="false" aria-controls="collapseInd">
                                                <i class="fas fa-flag me-2 text-warning"></i>Indonesian Version
                                            </button>
                                        </h2>
                                        <div id="collapseInd" class="accordion-collapse collapse" aria-labelledby="headingInd" data-bs-parent="#descriptionAccordion">
                                            <div class="accordion-body bg-white p-4">
                                                <div class="description-content border rounded p-3 bg-light">
                                                    <?= $wisata['deskripsi_wisata_ind'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingEng">
                                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEng" aria-expanded="false" aria-controls="collapseEng">
                                                <i class="fas fa-flag-usa me-2 text-info"></i>English Version
                                            </button>
                                        </h2>
                                        <div id="collapseEng" class="accordion-collapse collapse" aria-labelledby="headingEng" data-bs-parent="#descriptionAccordion">
                                            <div class="accordion-body bg-white p-4">
                                                <div class="description-content border rounded p-3 bg-light">
                                                    <?= $wisata['deskripsi_wisata_eng'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Information Card -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-semibold text-primary"><i class="fas fa-search me-2"></i>SEO Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Meta Title (Indonesian)</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $wisata['meta_title_id'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Meta Title (English)</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $wisata['meta_title_en'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Meta Deskripsi (Indonesian)</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $wisata['meta_deskription_id'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="info-item">
                                            <h6 class="info-title">Meta Deskripsi (English)</h6>
                                            <div class="info-content bg-light p-3 rounded">
                                                <?= $wisata['meta_description_en'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image and Actions Column -->
                    <div class="col-lg-4">
                        <!-- Photo Card -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h5 class="mb-0 fw-semibold text-primary"><i class="fas fa-camera me-2"></i>Wisata Photo</h5>
                            </div>
                            <div class="card-body text-center p-4">
                                <div class="image-container rounded overflow-hidden shadow-sm bg-light mb-3" style="height: 250px;">
                                    <img src="<?= base_url('asset-user/uploads/foto_wisata/' . $wisata['foto_wisata']) ?>"
                                        class="img-fluid h-100 w-100 object-fit-cover"
                                        alt="<?= $wisata['nama_wisata_ind'] ?>">
                                </div>
                                <div class="photo-source">
                                    <h6 class="info-title mb-2">Sumber Foto</h6>
                                    <div class="info-content bg-light p-2 rounded text-center">
                                        <?= $wisata['sumber_foto'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Card -->
                        <?php $role = session()->get('role'); ?>
                        <?php if (in_array($role, ['admin', 'penulis'])): ?>
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white py-3 border-bottom">
                                    <h5 class="mb-0 fw-semibold text-primary"><i class="fas fa-tools me-2"></i>Actions</h5>
                                </div>
                                <div class="card-body">

                                    <div class="d-grid gap-3 mb-4">
                                        <a href="<?= base_url('admin/tempat_wisata/edit/' . $wisata['id_wisata']) ?>"
                                            class="btn btn-primary btn-lg py-3 rounded-pill">
                                            <i class="fas fa-edit me-2"></i>Edit Wisata
                                        </a>
                                        <a href="<?= base_url('admin/tempat_wisata/delete/' . $wisata['id_wisata']) ?>"
                                            class="btn btn-outline-danger btn-lg py-3 rounded-pill"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus tempat wisata ini?')">
                                            <i class="fas fa-trash-alt me-2"></i>Delete Wisata
                                        </a>
                                    </div>
                                    <hr class="my-4">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-header {
        background-color: #f8f9fa;
    }

    .info-item {
        margin-bottom: 1.5rem;
    }

    .info-title {
        font-size: 0.85rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .info-subtitle {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .info-content {
        font-size: 1rem;
        font-weight: 500;
        color: #212529;
        word-break: break-word;
    }

    .accordion-button {
        font-weight: 500;
        padding: 1rem 1.25rem;
    }

    .accordion-body {
        padding: 0;
    }

    .description-content {
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .image-container {
        position: relative;
        border: 1px solid #eee;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .btn-lg {
        font-weight: 500;
    }

    .status-info {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
    }

    .rounded-pill {
        border-radius: 50px !important;
    }

    .text-primary {
        color: #0d6efd !important;
    }

    .fw-semibold {
        font-weight: 600;
    }

    .border-bottom {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>