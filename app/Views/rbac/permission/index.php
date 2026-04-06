<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Manajemen Permission</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">+ Tambah</button>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>Permission</th>
            <th>Module</th>
            <th width="220">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($permissions as $p): ?>
            <tr>
                <td><?= $p->name ?></td>
                <td><span class="badge bg-secondary"><?= $p->module ?></span></td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $p->id ?>">Edit</button>
                        <form method="post" action="<?= site_url('rbac/permission/delete/' . $p->id) ?>" onsubmit="return confirm('Hapus permission ini?')">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php foreach ($permissions as $p): ?>
    <div class="modal fade" id="edit<?= $p->id ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="<?= site_url('rbac/permission/update/' . $p->id) ?>">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" value="<?= $p->name ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Module</label>
                            <input type="text" name="module" value="<?= $p->module ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= site_url('rbac/permission/store') ?>">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" placeholder="contoh: create_user" required>
                    </div>
                    <div class="mb-3">
                        <label>Module</label>
                        <input type="text" name="module" class="form-control" placeholder="contoh: user" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>