<!DOCTYPE html>
<html lang="en">
<!-- data-bs-theme="dark" -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Website Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background: linear-gradient(135deg, #e3f0ff 0%, #b6d0f7 100%);
        height: 100vh;
    }

    .form-signin {
        width: 100%;
        max-width: 350px;
        padding: 25px 20px 20px 20px;
        margin: auto;
        border-radius: 1rem;
        background: #fff;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
        border: 1px solid #e3e3e3;
    }

    .form-signin .form-control {
        margin-bottom: 15px;
        border-radius: 0.5rem;
        border: 1px solid #bdbdbd;
        background: #f8faff;
        padding: 12px 15px;
    }

    .form-signin .form-control:focus {
        border-color: #1976d2;
        box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.10);
        background: #e3f0ff;
    }

    .form-signin label {
        color: #555;
        font-weight: 500;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }

    .form-signin .btn-primary {
        background: linear-gradient(90deg, #1976d2 0%, #64b5f6 100%);
        border: none;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 1px;
        padding: 12px;
    }

    .form-signin .btn-primary:hover {
        background: linear-gradient(90deg, #64b5f6 0%, #1976d2 100%);
    }

    .form-signin .btn-outline-secondary {
        border-radius: 50px;
        padding: 8px 16px;
        font-size: 0.85rem;
    }

    .form-signin h1,
    .form-signin h2 {
        color: #1976d2;
    }

    .form-signin .alert {
        border-radius: 0.5rem;
        padding: 10px 15px;
        margin-bottom: 15px;
    }

    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .signup-section {
        font-size: 0.9rem;
        white-space: nowrap;
    }

    /* Password Toggle Styles */
    .password-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
        transition: color 0.2s;
    }

    .password-toggle:hover {
        color: #1976d2;
    }

    .password-container .form-control {
        padding-right: 45px;
    }
    </style>
</head>

<body class="text-center">
    <main class="form-signin card">
        <form action="<?= site_url('auth/login') ?>" method="post">
            <h1 class="h4 mb-2 fw-normal"><b>Website Admin</b></h1>
            <h2 class="h6 mb-3 fw-normal text-muted">Login Account</h2>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email"
                    value="<?= old('email') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan password" required>
                    <i class="bi bi-eye-slash password-toggle" id="togglePassword"
                        onclick="togglePasswordVisibility()"></i>
                </div>
            </div>

            <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Sign in</button>

            <div class="signup-section d-flex align-items-center justify-content-center gap-2">
                <span class="text-muted">Don't have an account?</span>
                <!-- <a href="<?= site_url('auth/register') ?>" class="btn btn-outline-secondary">Create Account</a> -->
                <a href="<?= site_url('auth/register') ?>">Create Account</a>
            </div>

            <p class="mt-3 mb-0 text-muted small">Copyright &copy; <?= date('Y') ?></p>
        </form>
    </main>

    <!-- <script>
    // Cek parameter URL untuk notifikasi logout
    const urlParams = new URLSearchParams(window.location.search);
    const logoutStatus = urlParams.get('logout');

    if (logoutStatus === 'success') {
        // Tampilkan SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Logout Berhasil!',
            text: 'Anda telah berhasil logout dari sistem.',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });

        // Hapus parameter dari URL
        setTimeout(() => {
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        }, 500);
    }
    </script> -->

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="logoutToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong class="me-auto">Logout Berhasil</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Anda telah berhasil logout dari sistem.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // JavaScript untuk Toggle Password
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePassword');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        }
    }
    // JavaScript untuk Notifikasi Logout
    // Cek parameter URL untuk notifikasi logout
    const urlParams = new URLSearchParams(window.location.search);
    const logoutStatus = urlParams.get('logout');

    if (logoutStatus === 'success') {
        // Tampilkan toast notifikasi
        const toastElement = document.getElementById('logoutToast');
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
    </script>

</body>

</html>