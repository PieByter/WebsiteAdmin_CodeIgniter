<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<!-- <style>
    /* Modal edit event lebih ke tengah layar */
    #editEventModal .modal-dialog {
        margin-top: 10vh;
        /* Geser modal ke bawah, bisa ubah nilai sesuai selera */
    }

    @media (min-width: 576px) {
        #editEventModal .modal-dialog {
            margin-top: 15vh;
        }
    }
</style> -->

<style>
    /* Modal edit event lebih kecil dan benar-benar di tengah */
    #editEventModal .modal-dialog,
    #addEventModal .modal-dialog {
        max-width: 400px;
        /* Modal lebih kecil */
        margin: 0 auto;
        /* Modal horizontal di tengah */
        margin-top: 15vh;
        /* Modal vertikal di tengah */
    }
</style>

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

    <!-- Modal Tambah Event -->
    <div class="modal" id="addEventModal" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addEventForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEventLabel">Tambah Event Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="addEventTitle" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="addEventTitle" required>
                        </div>
                        <div class="mb-2">
                            <label for="addEventDesc" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="addEventDesc"></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="addEventDate" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="addEventDate" required>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="addEventStartTime" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="addEventStartTime">
                            </div>
                            <div class="col">
                                <label for="addEventEndTime" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="addEventEndTime">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <div class="mb-0">
                            <!-- <label for="addEventColor" class="form-label me-2">Warna Tag</label> -->
                            <input type="color" class="form-control form-control-color d-inline-block"
                                id="addEventColor" value="#3788d8">
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Event -->
    <div class="modal" id="editEventModal" tabindex="-1" aria-labelledby="editEventLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editEventForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEventLabel">Edit Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editEventId">
                        <div class="rowmb-2">
                            <label for="editEventTitle" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="editEventTitle" required>
                        </div>
                        <div class="mb-2">
                            <label for="editEventDesc" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editEventDesc"></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="editEventDate" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="editEventDate" required>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="editEventStartTime" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="editEventStartTime">
                            </div>
                            <div class="col">
                                <label for="editEventEndTime" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="editEventEndTime">
                            </div>
                        </div>
                        <!-- <div class="mb-2">
                            <label for="editEventColor" class="form-label">Warna Tag</label>
                            <input type="color" class="form-control form-control-color" id="editEventColor"
                                value="#3788d8">
                        </div> -->
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" id="deleteEventBtn" class="btn btn-danger">Hapus</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div> -->

                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <div class="mb-0">
                            <!-- <label for="editEventColor" class="form-label me-2">Warna Tag</label> -->
                            <input type="color" class="form-control form-control-color d-inline-block"
                                id="editEventColor" value="#3788d8"><!--  style="width: 2.5em; height: 2.5em;" -->
                        </div>
                        <div>
                            <button type="button" id="deleteEventBtn" class="btn btn-danger me-2">Hapus</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="loginToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-primary text-white">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong class="me-auto">Login Berhasil</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
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
        const toastElement = document.getElementById('loginToast');
        const toast = new bootstrap.Toast(toastElement, {
            delay: 3000
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
        var addModalEl = document.getElementById('addEventModal');
        var addModal = new bootstrap.Modal(addModalEl);
        var editModalEl = document.getElementById('editEventModal');
        var editModal = new bootstrap.Modal(editModalEl);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 400,
            selectable: true,
            events: '/event',

            // Tambah event baru dengan modal
            select: function(info) {
                // Isi tanggal otomatis
                document.getElementById('addEventDate').value = info.startStr;
                document.getElementById('addEventTitle').value = '';
                document.getElementById('addEventDesc').value = '';
                document.getElementById('addEventColor').value = '#3788d8';
                addModal.show();

                // Submit tambah event
                document.getElementById('addEventForm').onsubmit = function(e) {
                    e.preventDefault();
                    fetch('/event/create', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                title: document.getElementById('addEventTitle').value,
                                description: document.getElementById('addEventDesc')
                                    .value,
                                start: document.getElementById('addEventDate').value,
                                color: document.getElementById('addEventColor').value,
                                start_time: document.getElementById('addEventStartTime')
                                    .value,
                                end_time: document.getElementById('addEventEndTime')
                                    .value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            calendar.refetchEvents();
                            addModal.hide();
                        });
                };
                calendar.unselect();
            },

            // Edit/hapus event
            eventClick: function(info) {
                // Isi form modal dengan data event
                document.getElementById('editEventId').value = info.event.id;
                document.getElementById('editEventTitle').value = info.event.title;
                document.getElementById('editEventDesc').value = info.event.extendedProps.description ||
                    '';
                document.getElementById('editEventDate').value = info.event.startStr;
                document.getElementById('editEventStartTime').value = info.event.extendedProps
                    .start_time || '';
                document.getElementById('editEventEndTime').value = info.event.extendedProps.end_time ||
                    '';
                document.getElementById('editEventColor').value = info.event.backgroundColor ||
                    '#3788d8';


                editModal.show();

                // Tombol hapus
                document.getElementById('deleteEventBtn').onclick = function() {
                    // if (confirm('Hapus jadwal "' + info.event.title + '"?')) {
                    fetch('/event/delete/' + info.event.id, {
                            method: 'POST'
                        })
                        .then(response => response.json())
                        .then(data => {
                            calendar.refetchEvents();
                            editModal.hide();
                        });
                    // }
                };

                // Submit edit
                document.getElementById('editEventForm').onsubmit = function(e) {
                    e.preventDefault();
                    fetch('/event/update/' + info.event.id, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                title: document.getElementById('editEventTitle').value,
                                description: document.getElementById('editEventDesc')
                                    .value,
                                start: document.getElementById('editEventDate').value,
                                color: document.getElementById('editEventColor').value,
                                start_time: document.getElementById(
                                    'editEventStartTime').value,
                                end_time: document.getElementById('editEventEndTime')
                                    .value,
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            calendar.refetchEvents();
                            editModal.hide();
                        });
                };
            }
        });

        calendar.render();
    });
</script>

<?= $this->endSection() ?>