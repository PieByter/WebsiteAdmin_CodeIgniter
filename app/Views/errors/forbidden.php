<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .error-container {
        text-align: center;
        max-width: 500px;
    }
    </style>
</head>

<body>
    <div class="error-container">
        <h1 class="display-1 text-danger">403</h1>
        <h2 class="mb-4">Akses Ditolak</h2>
        <p class="lead">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <p>Silakan kembali ke halaman dashboard atau hubungi administrator jika Anda yakin seharusnya memiliki akses.
        </p>
        <div class="mt-4">
            <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>