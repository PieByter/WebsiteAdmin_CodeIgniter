<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pengaturan Akun</h1>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pengaturan Profil</h5>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <h6 class="mb-1">Username:</h6>
                        <p class="text-muted"><?= $user['username'] ?></p>
                    </div>

                    <div class="mb-3">
                        <h6 class="mb-1">Email:</h6>
                        <p class="text-muted"><?= $user['email'] ?? '-' ?></p>
                    </div>

                    <div class="mb-3">
                        <h6 class="mb-1">Role:</h6>
                        <p class="text-muted"><?= ucfirst($user['role']) ?></p>
                    </div>

                    <div class="mt-4">
                        <a href="<?= site_url('profile/edit') ?>" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card  h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Akun</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-xl bg-primary text-white rounded-circle">
                                <?= strtoupper(substr($user['username'], 0, 1)) ?>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0"><?= $user['username'] ?></h5>
                            <p class="text-muted mb-0"><?= ucfirst($user['role']) ?></p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="mb-1">Terakhir Login:</h6>
                        <p class="text-muted"><?= date('d-m-Y H:i:s') ?></p>
                    </div>

                    <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>