<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
	<div class="container-xl">
		<h1 class="app-page-title">Tentang</h1>
		<div class="row gy-4">
			<div class="col-12 col-lg-6 mb-4">
				<div class="app-card app-card-account shadow-sm d-flex flex-column align-items-startmb-4 mt-4">
					<div class="app-card-body px-4 w-100">

						<?php if (!empty(session()->getFlashdata('error'))) : ?>
							<div class="alert alert-danger" role="alert">
								<h4>Error</h4>
								<p><?php echo session()->getFlashdata('error'); ?></p>
							</div>
						<?php endif; ?>

						<form action="<?= base_url('admin/tentang/edit'); ?>" method="post" enctype="multipart/form-data">
							<?= csrf_field() ?>
							<div class="mb-3">
								<label for="nama_tentang" class="form-label mt-4">Nama Tentang</label>
								<input type="text" class="form-control" id="nama_tentang" name="nama_tentang" value="<?= $tentang_pengguna[0]['nama_tentang']; ?>">
							</div>
							<div class="mb-3">
								<label for="slogan" class="form-label mt-4">Slogan</label>
								<input type="text" class="form-control" id="slogan" name="slogan" value="<?= $tentang_pengguna[0]['slogan']; ?>">
							</div>
							<div class="mb-3">
								<label for="deskripsi_tentang" class="form-label">Deskripsi Tentang</label>
								<textarea type="text" class="form-control tiny" id="deskripsi_tentang" name="deskripsi_tentang" rows="5"><?= $tentang_pengguna[0]['deskripsi_tentang']; ?></textarea>
							</div>
							<div class="mb-3">
								<label for="deskripsi_tentang" class="form-label">Deskripsi Tentang (English)</label>
								<textarea type="text" class="form-control tiny" id="deskripsi_tentang_en" name="deskripsi_tentang_en" rows="5"><?= $tentang_pengguna[0]['deskripsi_tentang_en']; ?></textarea>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label mt-4">Alamat</label>
								<input type="text" class="form-control" id="alamat" name="alamat" value="<?= $tentang_pengguna[0]['alamat']; ?>">
							</div>
							<div class="mb-3">
								<label for="password" class="form-label mt-4">No Telp / Hp</label>
								<input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $tentang_pengguna[0]['no_telp']; ?>">
							</div>
							<div class="mb-3">
								<label for="password" class="form-label mt-4">Email</label>
								<input type="text" class="form-control" id="email" name="email" value="<?= $tentang_pengguna[0]['email']; ?>">
							</div>
							<div class="mb-3">
								<label for="password" class="form-label mt-4">Instagram</label>
								<input type="text" class="form-control" id="instagram" name="instagram" value="<?= $tentang_pengguna[0]['instagram']; ?>">
								<small class="text-muted">* Masukkan link URL.</small>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label mt-4">Tiktok</label>
								<input type="text" class="form-control" id="tiktok" name="tiktok" value="<?= $tentang_pengguna[0]['tiktok']; ?>">
								<small class="text-muted">* Masukkan link URL.</small>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label mt-4">Youtube</label>
								<input type="text" class="form-control" id="youtube" name="youtube" value="<?= $tentang_pengguna[0]['youtube']; ?>">
								<small class="text-muted">* Masukkan link URL.</small>
							</div>
							<div class="mb-3">
								<label for="nama_tentang" class="form-label mt-4">Footer</label>
								<input type="text" class="form-control" id="footer" name="footer" value="<?= $tentang_pengguna[0]['footer']; ?>">
								<small>*Template ini gratis selama Anda tetap menyimpan credit link/attribution link/backlink penulis footernya. Jika Anda ingin menggunakan templat tanpa tautan kredit/tautan atribusi/tautan balik penulis footer, Anda dapat membeli Lisensi Penghapusan Kredit dari <a href="https://htmlcodex.com/credit-removal">"https://htmlcodex.com/credit-removal"</a>. Terima kasih atas dukungan Anda.</small>
							</div>
							<div class="mb-3">
								<label for="username" class="form-label mt-4">User Name</label>
								<input type="text" class="form-control" id="username" name="username" value="<?= $tentang_pengguna[0]['username']; ?>">
								<small class="text-muted">* Jika Anda merubah username, silakan login kembali.</small>
							</div>
							<div class="mb-3">
								<label for="password" class="form-label mt-4">Password</label>
								<input type="text" class="form-control" id="password" name="password" value="<?= $tentang_pengguna[0]['password']; ?>">
							</div>
							<div class="mb-3">
								<label for="foto_tentang" class="form-label">Foto Tentang</label>
								<input type="hidden" name="old_foto_tentang" value="<?= $tentang_pengguna[0]['foto_tentang']; ?>">
								<input type="file" class="form-control" id="foto_tentang" name="foto_tentang">
								<img width="150px" class="img-thumbnail" src="<?= base_url('assets-baru/img/' . $tentang_pengguna[0]['foto_tentang']); ?>">
							</div>
							<!-- Tambahkan kolom lain yang perlu diubah sesuai dengan struktur tabel tb_profil -->
							<div class="mt-4">
								<button type="submit" class="btn btn-primary">Simpan</button>
								<!-- <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-secondary">Kembali</a> -->
							</div>
						</form>
					</div><!--//app-card-body-->
				</div><!--//app-card-->
			</div><!--//col-->
		</div><!--//row-->
	</div><!--//container-xl-->
</div><!--//app-content-->

<?= $this->endSection('content') ?>