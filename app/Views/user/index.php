<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Manajemen User</h3>
    <button class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modalCreateUser">
        + Tambah User
    </button>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['name']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td>
                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'secondary' ?>">
                        <?= esc($user['role']) ?>
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditUser<?= $user['id'] ?>">
                        Edit
                    </button>

                    <?php if ($user['id'] != session('user_id')): ?>
                        <form action="<?= site_url('manajemen-user/delete/' . $user['id']) ?>"
                            method="post"
                            style="display:inline;"
                            onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<!-- ========================= -->
<!-- MODAL EDIT (DI LUAR TABLE) -->
<!-- ========================= -->
<?php foreach ($users as $user): ?>
    <div class="modal fade" id="modalEditUser<?= $user['id'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post"
                    action="<?= site_url('manajemen-user/update/' . $user['id']) ?>">
                    <?= csrf_field() ?>

                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text"
                                name="name"
                                value="<?= esc($user['name']) ?>"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Password (Kosongkan jika tidak diganti)</label>
                            <input type="password"
                                name="password"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" class="form-select">
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="operator" <?= $user['role'] == 'operator' ? 'selected' : '' ?>>Operator</option>
                            </select>
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


<!-- ========================= -->
<!-- MODAL CREATE -->
<!-- ========================= -->
<div class="modal fade" id="modalCreateUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= site_url('manajemen-user/store') ?>">
                <?= csrf_field() ?>

                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-select">
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                        </select>
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