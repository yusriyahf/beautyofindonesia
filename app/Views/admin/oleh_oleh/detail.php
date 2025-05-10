<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="app-page-title mb-1">
                    <i class="fas fa-gift text-primary me-2"></i>Detail Oleh-Oleh: <?= $oleholeh['nama_oleholeh'] ?>
                </h1>
                <p class="text-muted">Informasi lengkap tentang oleh-oleh</p>
            </div>
            <div>
                <a href="<?= base_url('admin/oleh_oleh/index') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        <!-- Main Info Card -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="p-3 text-center bg-light rounded-start">
                                        <img src="<?= base_url('uploads/oleh_oleh/' . $oleholeh['foto_oleholeh']) ?>" 
                                             class="img-fluid rounded" style="max-height: 250px; width: auto;" 
                                             alt="<?= $oleholeh['nama_oleholeh'] ?>">
                                        <div class="mt-3">
                                            <button class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-eye me-1"></i> <?= $oleholeh['views'] ?> Views
                                            </button>
                                            <button class="btn btn-sm btn-outline-success">
                                                <i class="fab fa-whatsapp me-1"></i> <?= $oleholeh['whatsapp_clicks'] ?> Clicks
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h3 class="card-title mb-1"><?= $oleholeh['nama_oleholeh'] ?></h3>
                                                <h5 class="text-muted mb-3"><?= $oleholeh['nama_oleholeh_eng'] ?></h5>
                                            </div>
                                            <span class="badge bg-primary rounded-pill">
                                                <?= $oleholeh['nama_kategori_oleholeh'] ?>
                                            </span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                            <span class="text-muted">Lokasi: </span>
                                            <?= $oleholeh['nama_kotakabupaten'] ?>, <?= $oleholeh['nama_provinsi'] ?>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-phone-alt text-success me-2"></i>
                                            <span class="text-muted">Telepon: </span>
                                            <?= $oleholeh['nomor_tlp'] ?>
                                        </div>
                                        
                                        <?php if ($oleholeh['link_website']): ?>
                                        <div class="mb-3">
                                            <i class="fas fa-globe text-info me-2"></i>
                                            <span class="text-muted">Website: </span>
                                            <a href="<?= $oleholeh['link_website'] ?>" target="_blank" class="text-decoration-none">
                                                <?= $oleholeh['link_website'] ?>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="d-flex mt-4">
                                            <a href="<?= base_url('admin/oleh_oleh/edit/' . $oleholeh['id_oleholeh']) ?>" class="btn btn-warning me-2">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="fas fa-trash me-1"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs mb-4" id="olehOlehTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="deskripsi-tab" data-bs-toggle="tab" data-bs-target="#deskripsi" type="button" role="tab">
                                    <i class="fas fa-align-left me-1"></i> Deskripsi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="lokasi-tab" data-bs-toggle="tab" data-bs-target="#lokasi" type="button" role="tab">
                                    <i class="fas fa-map-marked-alt me-1"></i> Lokasi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab">
                                    <i class="fas fa-search me-1"></i> SEO
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="olehOlehTabContent">
                            <!-- Deskripsi Tab -->
                            <div class="tab-pane fade show active" id="deskripsi" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-4 border-0 shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <i class="fas fa-font me-1"></i> Deskripsi (Bahasa Indonesia)
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text"><?= $oleholeh['deskripsi_oleholeh'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4 border-0 shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <i class="fas fa-font me-1"></i> Deskripsi (English)
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text"><?= $oleholeh['deskripsi_oleholeh_eng'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lokasi Tab -->
                            <div class="tab-pane fade" id="lokasi" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-4 border-0 shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <i class="fas fa-info-circle me-1"></i> Detail Lokasi
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <h6 class="text-muted">Provinsi</h6>
                                                    <p><?= $oleholeh['nama_provinsi'] ?></p>
                                                </div>
                                                <div class="mb-3">
                                                    <h6 class="text-muted">Kabupaten/Kota</h6>
                                                    <p><?= $oleholeh['nama_kotakabupaten'] ?></p>
                                                </div>
                                                <div class="mb-3">
                                                    <h6 class="text-muted">Koordinat</h6>
                                                    <p>
                                                        Latitude: <?= $oleholeh['oleholeh_latitude'] ?><br>
                                                        Longitude: <?= $oleholeh['oleholeh_longitude'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4 border-0 shadow-sm h-100">
                                            <div class="card-header bg-primary text-white">
                                                <i class="fas fa-map me-1"></i> Peta Lokasi
                                            </div>
                                            <div class="card-body p-0">
                                                <div id="map" style="height: 300px; width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Tab -->
                            <div class="tab-pane fade" id="seo" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-4 border-0 shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <i class="fas fa-heading me-1"></i> Meta Title
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-muted">Bahasa Indonesia</h6>
                                                <p class="mb-3"><?= $oleholeh['meta_title_id'] ?></p>
                                                
                                                <h6 class="text-muted">English</h6>
                                                <p><?= $oleholeh['meta_title_en'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4 border-0 shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <i class="fas fa-paragraph me-1"></i> Meta Description
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-muted">Bahasa Indonesia</h6>
                                                <p class="mb-3"><?= $oleholeh['meta_description_id'] ?></p>
                                                
                                                <h6 class="text-muted">English</h6>
                                                <p><?= $oleholeh['meta_description_en'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus oleh-oleh <strong><?= $oleholeh['nama_oleholeh'] ?></strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-circle me-2"></i>Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="<?= base_url('admin/oleh_oleh/delete/' . $oleholeh['id_oleholeh']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS for Maps -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
    $(document).ready(function() {
        // Initialize map
        const map = L.map('map').setView([<?= $oleholeh['oleholeh_latitude'] ?>, <?= $oleholeh['oleholeh_longitude'] ?>], 13);
        
        // Add tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add custom icon
        const customIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });
        
        // Add marker with custom icon
        L.marker([<?= $oleholeh['oleholeh_latitude'] ?>, <?= $oleholeh['oleholeh_longitude'] ?>], {icon: customIcon})
            .addTo(map)
            .bindPopup(`
                <div class="map-popup">
                    <h6 class="mb-1"><?= addslashes($oleholeh['nama_oleholeh']) ?></h6>
                    <small class="text-muted"><?= addslashes($oleholeh['nama_kotakabupaten']) ?></small>
                </div>
            `)
            .openPopup();
    });
</script>

<style>
    /* Custom styles for detail page */
    .app-card {
        border-radius: 10px;
    }
    
    .app-card-settings {
        border: none;
    }
    
    .card {
        border-radius: 8px;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .nav-tabs .nav-link {
        border: none;
        color: #495057;
        font-weight: 500;
        padding: 12px 20px;
        border-radius: 8px 8px 0 0;
    }
    
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.1);
        border-bottom: 3px solid #0d6efd;
    }
    
    .nav-tabs .nav-link:hover:not(.active) {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .map-popup h6 {
        font-weight: 600;
        color: #0d6efd;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        #map {
            height: 250px;
        }
    }
</style>

<?= $this->endSection('content') ?>