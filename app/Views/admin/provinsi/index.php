<?= $this->extend('admin/template/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <h2>Daftar Provinsi</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <a href="<?= base_url('admin/provinsi/tambah') ?>" class="btn btn-primary mb-3">Tambah Provinsi</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Provinsi</th>
                <th>Nama Provinsi (in)</th>
                <th>Nama Provinsi (en)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($all_data_provinsi) > 0): ?>
                <?php foreach ($all_data_provinsi as $provinsi): ?>
                    <tr>
                        <td><?= esc($provinsi->id_provinsi) ?></td>
                        <td><?= esc($provinsi->nama_provinsi) ?></td>
                        <td><?= esc($provinsi->nama_provinsi_eng) ?></td>
                        <td>
                            <a href="<?= base_url('admin/provinsi/edit/' . $provinsi->id_provinsi) ?>" class="btn btn-warning">Edit</a>
                            <a href="<?= base_url('admin/provinsi/delete/' . $provinsi->id_provinsi) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus provinsi ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data provinsi</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
