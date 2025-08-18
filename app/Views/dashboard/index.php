<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<div class="container-fluid">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75">Selamat Datang</div>
                            <div class="text-lg fw-bold"><?= session('username') ?></div>
                        </div>
                        <i class="bi bi-person-circle display-5"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= site_url('profile') ?>">View Profile</a>
                    <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
                </div>
            </div>
        </div>

        <?php if (session('role') == 'user'): ?>
            <div class="col-md-4 mb-4">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75">Lihat Produk</div>
                                <div class="text-lg fw-bold">Katalog Barang</div>
                            </div>
                            <i class="bi bi-eye display-5"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="<?= site_url('barang') ?>">View Products</a>
                        <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session('role') == 'admin'): ?>
            <div class="col-md-4 mb-4">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75">Kelola Barang</div>
                                <div class="text-lg fw-bold">Manajemen Inventori</div>
                            </div>
                            <i class="bi bi-box display-5"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="<?= site_url('admin/barang') ?>">View Items</a>
                        <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75">Aktivitas Sistem</div>
                                <div class="text-lg fw-bold">Log & Riwayat</div>
                            </div>
                            <i class="bi bi-list-check display-5"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="<?= site_url('admin/logs') ?>">View Logs</a>
                        <div class="small text-white"><i class="bi bi-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Informasi Tambahan -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card mb-4 h-100">
                <div class="card-header">
                    <i class="bi bi-info-circle me-1"></i>
                    Informasi Sistem
                </div>
                <div class="card-body">
                    <p>Selamat datang di dashboard administrator. Anda dapat mengelola berbagai fitur sistem melalui
                        menu yang tersedia.</p>
                    <p>Role: <strong><?= session('role') ?></strong></p>
                    <p>Login terakhir: <strong><?= date('d-m-Y H:i:s') ?></strong></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4 h-100">
                <div class="card-header">
                    <i class="bi bi-link-45deg me-1"></i>
                    Pintasan
                </div>
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-xl-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="<?= site_url('profile') ?>">Edit Profil</a></li>
                                <?php if (session('role') == 'admin'): ?>
                                    <li><a href="<?= site_url('admin/barang/create') ?>">Tambah Barang</a></li>
                                    <li><a href="<?= site_url('admin/users') ?>">Kelola Pengguna</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div> -->
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= site_url('profile') ?>" class="btn btn-primary">
                            <i class="bi bi-person"></i> Edit Profil
                        </a>
                        <?php if (session('role') == 'admin'): ?>
                            <a href="<?= site_url('admin/barang/create') ?>" class="btn btn-warning text-white">
                                <i class="bi bi-plus-circle"></i> Tambah Barang
                            </a>
                            <a href="<?= site_url('admin/users') ?>" class="btn btn-success">
                                <i class="bi bi-people"></i> Kelola Pengguna
                            </a>
                            <a href="<?= site_url('admin/logs') ?>" class="btn btn-info text-white">
                                <i class="bi bi-list-check"></i> Kelola Logs
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card mb-4 h-100">
                <div class="card-header">
                    <i class="bi bi-calendar-event me-1"></i>
                    Kalender Kegiatan
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="loginToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-primary text-white">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong class="me-auto">Login Berhasil</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Anda telah berhasil login ke dashboard.
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Cek parameter URL untuk notifikasi login
    const urlParams = new URLSearchParams(window.location.search);
    const loginStatus = urlParams.get('login');

    if (loginStatus === 'success') {
        // Tampilkan toast notifikasi
        const toastElement = document.getElementById('loginToast');
        const toast = new bootstrap.Toast(toastElement, {
            delay: 3000 // 3 detik
        });
        toast.show();

        // Hapus parameter dari URL setelah notifikasi muncul
        setTimeout(() => {
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        }, 500);
    }

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 400,
                events: [
                    // Contoh event statis, bisa diganti dari backend
                    {
                        title: 'Meeting',
                        start: '<?= date('Y-m-d') ?>'
                    },
                    {
                        title: 'Deadline',
                        start: '<?= date('Y-m-d', strtotime('+3 days')) ?>'
                    }
                ]
            });
            calendar.render();
        }
    });
</script>
<?= $this->endSection() ?>