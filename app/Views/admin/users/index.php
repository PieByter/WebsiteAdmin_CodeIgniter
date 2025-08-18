<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen User</h1>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <a href="<?= site_url('admin/users/create') ?>" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Tambah User Baru
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?? '-' ?></td>
                                <td>
                                    <span class="badge <?= $user['role'] == 'admin' ? 'bg-danger' : 'bg-info' ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['is_active'] ?? 1): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <?php if ($user['id'] != session('user_id')): ?>
                                        <a href="<?= site_url('admin/users/delete/' . $user['id']) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data user</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>