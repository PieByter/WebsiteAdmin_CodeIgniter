<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="my-3">Tambah User Baru</h1>

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

            <form action="<?= site_url('admin/users/save') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user" <?= old('role') == 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= site_url('admin/users') ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>