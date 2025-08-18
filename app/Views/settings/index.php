<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pengaturan Sistem</h1>
    </div>
    <?php if (session()->getFlashdata('pesan')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('pesan') ?>
    </div>
    <?php endif; ?>

    <?php if (session()->has('validation')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('validation')->getErrors() as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php endif ?>

    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                        type="button" role="tab">Umum</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="display-tab" data-bs-toggle="tab" data-bs-target="#display"
                        type="button" role="tab">Tampilan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance"
                        type="button" role="tab">Pemeliharaan</button>
                </li>
            </ul>

            <form action="<?= site_url('admin/settings/update') ?>" method="post">
                <?= csrf_field() ?>

                <div class="tab-content p-3" id="settingsTabContent">
                    <!-- Tab Umum -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="mb-3">
                            <label for="app_name" class="form-label">Nama Aplikasi</label>
                            <input type="text" class="form-control" id="app_name" name="app_name"
                                value="<?= $settings['app_name'] ?? 'Website Admin' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="app_description" class="form-label">Deskripsi Aplikasi</label>
                            <textarea class="form-control" id="app_description" name="app_description"
                                rows="3"><?= $settings['app_description'] ?? 'Sistem Manajemen Barang dan User' ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="admin_email" class="form-label">Email Administrator</label>
                            <input type="email" class="form-control" id="admin_email" name="admin_email"
                                value="<?= $settings['admin_email'] ?? 'admin@example.com' ?>">
                        </div>
                    </div>

                    <!-- Tab Tampilan -->
                    <div class="tab-pane fade" id="display" role="tabpanel">
                        <div class="mb-3">
                            <label for="items_per_page" class="form-label">Item per Halaman</label>
                            <input type="number" class="form-control" id="items_per_page" name="items_per_page"
                                value="<?= $settings['items_per_page'] ?? '10' ?>" min="5" max="100">
                            <div class="form-text">Jumlah item yang ditampilkan per halaman dalam tabel</div>
                        </div>
                    </div>

                    <!-- Tab Pemeliharaan -->
                    <div class="tab-pane fade" id="maintenance" role="tabpanel">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="maintenance_mode"
                                name="maintenance_mode" value="1"
                                <?= ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="maintenance_mode">Mode Pemeliharaan</label>
                            <div class="form-text">Aktifkan mode pemeliharaan (hanya admin yang dapat mengakses sistem)
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Database Backup</label>
                            <div>
                                <a href="<?= site_url('admin/settings/backup') ?>" class="btn btn-success">
                                    <i class="bi bi-download"></i> Backup Database
                                </a>
                            </div>
                            <div class="form-text">Download backup database dalam format SQL</div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>