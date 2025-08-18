<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Website Admin' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 56px;
        }

        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            width: 220px;
            background: linear-gradient(135deg, #e3f0ff 0%, #b6d0f7 100%);
            box-shadow: 0 0 10px rgba(25, 118, 210, 0.08);
            border-right: 1px solid #b6d0f7;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar .nav {
            flex-direction: column;
            gap: 1rem;
        }

        .sidebar .nav-item {
            margin-bottom: 0.5rem;
        }

        .sidebar .sidebar-box {
            background: #f8faff;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.05);
            padding: 1rem 0.75rem;
            display: flex;
            align-items: center;
            transition: background 0.2s;
            cursor: pointer;
            border: 1px solid #e3f0ff;
        }

        .sidebar .sidebar-box:hover,
        .sidebar .sidebar-box.active {
            background: #b6d0f7;
            color: #1976d2;
        }

        .sidebar .sidebar-box i {
            font-size: 1.3rem;
            margin-right: 0.75rem;
            color: #1976d2;
        }

        .sidebar .sidebar-box span {
            font-weight: 500;
            font-size: 1rem;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        .list-group-item {
            background: transparent !important;
            border: none;
            color: #1976d2;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }

        .list-group-item:hover {
            background: #e3f0ff !important;
            color: #1976d2;
        }

        .list-group-item.active {
            background: #b6d0f7 !important;
            color: #1976d2 !important;
            border: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('dashboard') ?>">Website Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('profile') ?>">
                            <i class="bi bi-person"></i> <?= session('username') ?? 'User' ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('auth/logout') ?>"><i class="bi bi-box-arrow-right"></i>
                            Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-sticky px-2 pt-3">
            <div class="list-group">
                <a href="<?= site_url('dashboard') ?>"
                    class="list-group-item list-group-item-action<?= (uri_string() == 'dashboard') ? ' active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <?php if (session('role') == 'admin'): ?>
                    <a href="<?= site_url('admin/barang') ?>"
                        class="list-group-item list-group-item-action<?= (uri_string() == 'admin/barang') ? ' active' : '' ?>">
                        <i class="bi bi-box"></i> Manajemen Barang
                    </a>
                    <a href="<?= site_url('admin/logs') ?>"
                        class="list-group-item list-group-item-action<?= (uri_string() == 'admin/logs') ? ' active' : '' ?>">
                        <i class="bi bi-list-check"></i> Log Aktivitas
                    </a>
                    <a href="<?= site_url('admin/users') ?>"
                        class="list-group-item list-group-item-action<?= (uri_string() == 'admin/users') ? ' active' : '' ?>">
                        <i class="bi bi-people"></i> Manajemen User
                    </a>
                    <a href="<?= site_url('admin/settings') ?>"
                        class="list-group-item list-group-item-action<?= (uri_string() == 'admin/settings') ? ' active' : '' ?>">
                        <i class="bi bi-gear"></i> Pengaturan
                    </a>
                <?php else: ?>
                    <a href="<?= site_url('barang') ?>"
                        class="list-group-item list-group-item-action<?= (uri_string() == 'barang') ? ' active' : '' ?>">
                        <i class="bi bi-box"></i> Daftar Produk
                    </a>
                <?php endif; ?>
                <a href="<?= site_url('profile') ?>"
                    class="list-group-item list-group-item-action<?= (uri_string() == 'profile') ? ' active' : '' ?>">
                    <i class="bi bi-person-circle"></i> Profil Saya
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
        <?= $this->renderSection('content') ?>
    </main>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>

</html>