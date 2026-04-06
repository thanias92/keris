<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Manajemen Role</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateRole">+ Tambah Role</button>
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
            <th>Nama Role</th>
            <th width="220">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($roles as $role): ?>
            <tr>
                <td>
                    <span class="badge bg-info"><?= ucfirst($role->name) ?></span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?= site_url('rbac/role/permissions/' . $role->id) ?>" class="btn btn-sm btn-primary">Permission</a>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $role->id ?>">Edit</button>
                        <?php if ($role->id != 1): ?>
                            <form method="post" action="<?= site_url('rbac/role/delete/' . $role->id) ?>" onsubmit="return confirm('Yakin hapus role ini?')">
                                <?= csrf_field() ?>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php foreach ($roles as $role): ?>
    <div class="modal fade" id="modalEdit<?= $role->id ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="<?= site_url('rbac/role/update/' . $role->id) ?>">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Role</label>
                            <input type="text" name="name" value="<?= $role->name ?>" class="form-control" required>
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

<div class="modal fade" id="modalCreateRole" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= site_url('rbac/role/store') ?>">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Role</label>
                        <input type="text" name="name" class="form-control" required>
                        <small class="text-muted">Contoh: auditor, kepala_bidang</small>
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