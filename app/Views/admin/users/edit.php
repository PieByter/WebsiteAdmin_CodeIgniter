<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="my-3">Edit User</h1>

    <div class="card">
        <div class="card-body">
            <?php if (session()->has('validation')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session('validation')->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <form action="<?= site_url('admin/users/update/' . $user['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?= old('username', $user['username']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?= old('email', $user['email'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah password</div>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user" <?= (old('role', $user['role']) == 'user') ? 'selected' : '' ?>>User
                        </option>
                        <option value="admin" <?= (old('role', $user['role']) == 'admin') ? 'selected' : '' ?>>Admin
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="is_active" class="form-label">Status</label>
                    <select class="form-select" id="is_active" name="is_active">
                        <option value="1" <?= (old('is_active', $user['is_active'] ?? 1) == 1) ? 'selected' : '' ?>>
                            Aktif</option>
                        <option value="0" <?= (old('is_active', $user['is_active'] ?? 1) == 0) ? 'selected' : '' ?>>
                            Non-aktif</option>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= site_url('admin/users') ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>