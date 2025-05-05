    <?= $this->extend('admin/template/template'); ?>
    <?= $this->Section('content'); ?>

    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="app-page-title mb-0">Tambah Artikel Baru</h1>
                <a href="<?= base_url('admin/artikel') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="row g-4">
                <!-- Main Form Column -->
                <div class="col-12 col-md-8">
                    <div class="app-card app-card-settings shadow-sm p-4">
                        <div class="app-card-header mb-4">
                            <h4 class="app-card-title">
                                <i class="fas fa-plus-circle me-2"></i>Form Tambah Artikel
                            </h4>
                        </div>

                        <div class="app-card-body">
                            <form action="<?= base_url('admin/artikel/proses_tambah') ?>" method="POST" enctype="multipart/form-data">
                                <?= csrf_field(); ?>

                                <!-- Tab Navigation -->
                                <ul class="nav nav-tabs mb-4" id="artikelTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                            <i class="fas fa-info-circle me-1"></i> Informasi Dasar
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab">
                                            <i class="fas fa-align-left me-1"></i> Konten
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab">
                                            <i class="fas fa-tags me-1"></i> SEO & Media
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content" id="artikelTabContent">
                                    <!-- Basic Info Tab -->
                                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Kategori</label>
                                                <select class="form-select" name="id_kategori" id="id_kategori">
                                                    <?php foreach ($all_data_kategori as $kategori) : ?>
                                                        <option value="<?= $kategori->id_kategori; ?>"><?= $kategori->nama_kategori; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Penulis</label>
                                                <select class="form-select" name="id_penulis" id="id_penulis">
                                                    <?php foreach ($all_data_penulis as $penulis) : ?>
                                                        <option value="<?= $penulis->id_penulis; ?>"><?= $penulis->nama_penulis; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Judul Artikel</label>
                                            <input type="text" class="form-control form-control-lg" id="judul_artikel" name="judul_artikel" value="<?= old('judul_artikel') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Judul Artikel (English)</label>
                                            <input type="text" class="form-control form-control-lg" id="judul_artikel_en" name="judul_artikel_en" value="<?= old('judul_artikel_en') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tanggal Publish</label>
                                            <input type="date" class="form-control" id="tgl_publish" name="tgl_publish" value="<?= old('tgl_publish') ?>">
                                        </div>
                                    </div>

                                    <!-- Content Tab -->
                                    <div class="tab-pane fade" id="content" role="tabpanel">
                                        <div class="mb-3">
                                            <label for="deskripsi_artikel" class="form-label fw-bold">Deskripsi Artikel</label>
                                            <textarea class="form-control tiny" id="deskripsi_artikel" name="deskripsi_artikel" rows="10"><?= old('deskripsi_artikel') ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi_artikel_en" class="form-label fw-bold">Deskripsi Artikel (English)</label>
                                            <textarea class="form-control tiny" id="deskripsi_artikel_en" name="deskripsi_artikel_en" rows="10"><?= old('deskripsi_artikel_en') ?></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Tags</label>
                                                <input type="text" class="form-control" id="tags" name="tags" value="<?= old('tags') ?>">
                                                <small class="text-muted">Pisahkan dengan koma (contoh: teknologi,berita,update)</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Tags (English)</label>
                                                <input type="text" class="form-control" id="tags_en" name="tags_en" value="<?= old('tags_en') ?>">
                                                <small class="text-muted">Separate with commas (ex: technology,news,update)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SEO & Media Tab -->
                                    <div class="tab-pane fade" id="seo" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Sumber Foto</label>
                                            <input type="text" class="form-control" id="sumber_foto" name="sumber_foto" value="<?= old('sumber_foto') ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Foto Artikel</label>
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body">
                                                    <input class="form-control <?= ($validation->hasError('foto_artikel')) ? 'is-invalid' : '' ?>" type="file" id="foto_artikel" name="foto_artikel">
                                                    <?= $validation->getError('foto_artikel') ?>
                                                    <div class="alert alert-light mt-3 mb-0">
                                                        <small>
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            <strong>Persyaratan:</strong><br>
                                                            - Ukuran minimal 572×572 pixels<br>
                                                            - Format: JPG, PNG, atau JPEG
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Meta Title (ID)</label>
                                                <input type="text" class="form-control" id="meta_title_id" name="meta_title_id" value="<?= old('meta_title_id') ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Meta Title (EN)</label>
                                                <input type="text" class="form-control" id="meta_title_en" name="meta_title_en" value="<?= old('meta_title_en') ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Meta Deskripsi (ID)</label>
                                                <textarea class="form-control" id="meta_description_id" name="meta_description_id" rows="3"><?= old('meta_description_id') ?></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Meta Deskripsi (EN)</label>
                                                <textarea class="form-control" id="meta_description_en" name="meta_description_en" rows="3"><?= old('meta_description_en') ?></textarea>
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
                                        <i class="fas fa-save me-2"></i> Simpan Artikel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Help Column -->
                <div class="col-12 col-md-4">
                    <div class="app-card app-card-settings shadow-sm p-4 h-100">
                        <div class="app-card-header mb-4">
                            <h4 class="app-card-title">
                                <i class="fas fa-lightbulb me-2"></i>Panduan
                            </h4>
                        </div>
                        <div class="app-card-body">
                            <div class="alert alert-info">
                                <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Tips Menulis Artikel</h5>
                                <ul class="mb-0 ps-3">
                                    <li>Gunakan judul yang menarik dan deskriptif</li>
                                    <li>Periksa ejaan dan tata bahasa</li>
                                    <li>Gunakan gambar berkualitas tinggi</li>
                                    <li>Tambahkan tags yang relevan</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Penting!</h5>
                                <ul class="mb-0 ps-3">
                                    <li>Pastikan semua field wajib diisi</li>
                                    <li>Format tanggal: MM-DD-YYYY</li>
                                    <li>Simpan draft secara berkala</li>
                                    <li>Isi semua field terlebih dahulu baru klik <strong>"Simpan Artikel"</strong></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection('content'); ?>