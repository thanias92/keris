<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h3 class="mb-3">Kelola Permission - <?= ucfirst($role->name) ?></h3>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('rbac/role/update-permissions/' . $role->id) ?>">
    <?= csrf_field() ?>

    <?php foreach ($groupedPermissions as $module => $perms): ?>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold text-uppercase"><?= $module ?></span>
                <input type="checkbox" onclick="toggleModule(this,'<?= $module ?>')">
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($perms as $perm): ?>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="permissions[]"
                                    value="<?= $perm->id ?>"
                                    data-module="<?= $module ?>"
                                    <?= in_array($perm->id, $rolePermissionIds) ? 'checked' : '' ?>>
                                <label class="form-check-label"><?= $perm->name ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <button class="btn btn-primary">Simpan</button>
</form>

<script>
    function toggleModule(source, module) {
        document.querySelectorAll('[data-module="' + module + '"]').forEach(cb => cb.checked = source.checked)
    }
</script>

<?= $this->endSection() ?>