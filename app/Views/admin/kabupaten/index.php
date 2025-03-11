<?= $this->extend('admin/template/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2>Daftar Kabupaten</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <a href="<?= base_url('admin/kabupaten/tambah') ?>" class="btn btn-primary mb-3">Tambah Kabupaten</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Kabupaten</th>
                <th>Provinsi</th>
                <th>Nama Kabupaten (in)</th>
                <th>Nama Kabupaten (en)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($all_data_kabupaten) > 0): ?>
                <?php foreach ($all_data_kabupaten as $kabupaten): ?>
                    <tr>
                        <td><?= esc($kabupaten['id_kotakabupaten']) ?></td>
                        <td><?= esc($kabupaten['nama_provinsi']) ?></td>
                        <td><?= esc($kabupaten['nama_kotakabupaten']) ?></td>
                        <td><?= esc($kabupaten['nama_kotakabupaten_eng']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/kabupaten/delete/'.$kabupaten['id_kotakabupaten']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kabupaten ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data kabupaten</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
