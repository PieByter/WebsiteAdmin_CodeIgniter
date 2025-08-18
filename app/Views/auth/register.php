<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Website Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background: linear-gradient(135deg, #e3f0ff 0%, #b6d0f7 100%);
            min-height: 100vh;
        }

        .form-register {
            width: 100%;
            max-width: 400px;
            padding: 25px 20px 20px 20px;
            margin: auto;
            border-radius: 1rem;
            background: #fff;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
            border: 1px solid #e3e3e3;
        }

        .form-register .form-control {
            margin-bottom: 15px;
            border-radius: 0.5rem;
            border: 1px solid #bdbdbd;
            background: #f8faff;
            padding: 12px 15px;
        }

        .form-register .form-control:focus {
            border-color: #1976d2;
            box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.10);
            background: #e3f0ff;
        }

        .form-register label {
            color: #555;
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .form-register .btn-primary {
            background: linear-gradient(90deg, #1976d2 0%, #64b5f6 100%);
            border: none;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 12px;
        }

        .form-register .btn-primary:hover {
            background: linear-gradient(90deg, #64b5f6 0%, #1976d2 100%);
        }

        .form-register h1,
        .form-register h2 {
            color: #1976d2;
        }

        .form-register .alert {
            border-radius: 0.5rem;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .signin-section {
            font-size: 0.9rem;
        }

        .signin-section a {
            color: #1976d2;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .signin-section a:hover {
            color: #0d47a1;
            text-decoration: underline;
        }

        /* Password Toggle Styles */
        .password-container {
            position: relative;
        }

        .password-container .form-control {
            padding-right: 45px;
            margin-bottom: 0;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 1rem;
            z-index: 10;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: #1976d2;
        }

        .password-toggle:active {
            transform: translateY(-50%) scale(0.95);
        }

        #password-checklist {
            display: none;
        }

        #confirm-password-checklist {
            display: none;
        }
    </style>
</head>

<body class="text-center">
    <main class="form-register card">
        <form action="<?= site_url('auth/register') ?>" method="post">
            <?= csrf_field() ?>

            <h1 class="h4 mb-2 fw-normal"><b>Website Admin</b></h1>
            <h2 class="h6 mb-3 fw-normal text-muted">Create Account</h2>

            <!-- <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if (isset($validation)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 text-start">
                        <?php foreach ($validation->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?> -->

            <?php
            $validation = session('validation');
            if ($validation && $validation->getErrors()):
            ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 text-start">
                        <?php foreach ($validation->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>


            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username"
                    value="<?= old('username') ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email"
                    value="<?= old('email') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" class="form-control" id="password" name="password"
                        oninput="checkPasswordStrength()" placeholder="Masukkan password" value="<?= old('password') ?>"
                        required>
                    <i class="bi bi-eye-slash password-toggle" id="togglePassword"
                        onclick="togglePasswordVisibility('password', 'togglePassword')" title="Show/Hide Password"></i>
                </div>

                <ul id="password-checklist" class="text-start small mt-2 mb-0 list-unstyled">
                    <li id="check-length"><span class="me-1" id="icon-length">❌</span>Minimal 8 karakter</li>
                    <li id="check-case"><span class="me-1" id="icon-case">❌</span>Huruf besar & kecil</li>
                    <li id="check-symbol"><span class="me-1" id="icon-symbol">❌</span>Mengandung simbol</li>
                </ul>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="password-container">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                        placeholder="Konfirmasi password" value="<?= old('confirm_password') ?>" required>
                    <i class="bi bi-eye-slash password-toggle" id="toggleConfirmPassword"
                        onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmPassword')"
                        title="Show/Hide Confirm Password"></i>
                </div>
                <ul id="confirm-password-checklist" class="text-start small mt-2 mb-0 list-unstyled"
                    style="display:none;">
                    <li id="check-confirm"><span class="me-1" id="icon-confirm">❌</span>Password dan konfirmasi
                        harus sama</li>
                </ul>
            </div>
            <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Register</button>

            <div class="signin-section text-center">
                <span class="text-muted">Already have an account?</span>
                <a href="<?= site_url('auth/login') ?>">Sign In</a>
            </div>

            <p class="mt-3 mb-0 text-muted small">Copyright &copy; <?= date('Y') ?></p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript untuk Toggle Password -->
    <script>
        function togglePasswordVisibility(passwordFieldId, toggleIconId) {
            const passwordField = document.getElementById(passwordFieldId);
            const toggleIcon = document.getElementById(toggleIconId);

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }

        // Password checklist logic
        const passwordInput = document.getElementById('password');
        const passwordChecklist = document.getElementById('password-checklist');

        function isPasswordValid() {
            const password = passwordInput.value;
            return (
                password.length >= 8 &&
                /[a-z]/.test(password) &&
                /[A-Z]/.test(password) &&
                /[^A-Za-z0-9]/.test(password)
            );
        }

        function checkPasswordStrength() {
            const password = passwordInput.value;
            const lengthCheck = password.length >= 8;
            const caseCheck = /[a-z]/.test(password) && /[A-Z]/.test(password);
            const symbolCheck = /[^A-Za-z0-9]/.test(password);

            document.getElementById('check-length').className = lengthCheck ? 'text-success' : 'text-danger';
            document.getElementById('icon-length').textContent = lengthCheck ? '✔️' : '❌';

            document.getElementById('check-case').className = caseCheck ? 'text-success' : 'text-danger';
            document.getElementById('icon-case').textContent = caseCheck ? '✔️' : '❌';

            document.getElementById('check-symbol').className = symbolCheck ? 'text-success' : 'text-danger';
            document.getElementById('icon-symbol').textContent = symbolCheck ? '✔️' : '❌';

            // Tampilkan checklist hanya saat focus jika kosong
            if (password.length === 0) {
                passwordChecklist.style.display = passwordInput === document.activeElement ? 'block' : 'none';
            } else if (lengthCheck && caseCheck && symbolCheck) {
                passwordChecklist.style.display = passwordInput === document.activeElement ? 'block' : 'none';
            } else {
                passwordChecklist.style.display = 'block';
            }
        }

        passwordInput.addEventListener('focus', checkPasswordStrength);
        passwordInput.addEventListener('input', checkPasswordStrength);
        passwordInput.addEventListener('blur', checkPasswordStrength);

        // Confirm password checklist logic
        const confirmInput = document.getElementById('confirm_password');
        const confirmChecklist = document.getElementById('confirm-password-checklist');

        function isConfirmValid() {
            return (
                confirmInput.value.length > 0 &&
                passwordInput.value === confirmInput.value
            );
        }

        function checkConfirmPassword() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            const isMatch = password === confirm && confirm.length > 0;

            document.getElementById('check-confirm').className = isMatch ? 'text-success' : 'text-danger';
            document.getElementById('icon-confirm').textContent = isMatch ? '✔️' : '❌';

            // Tampilkan checklist hanya saat focus jika kosong
            if (confirm.length === 0) {
                confirmChecklist.style.display = confirmInput === document.activeElement ? 'block' : 'none';
            } else if (isMatch) {
                confirmChecklist.style.display = confirmInput === document.activeElement ? 'block' : 'none';
            } else {
                confirmChecklist.style.display = 'block';
            }
        }

        confirmInput.addEventListener('focus', checkConfirmPassword);
        confirmInput.addEventListener('input', checkConfirmPassword);
        confirmInput.addEventListener('blur', checkConfirmPassword);

        // Update confirm checklist juga saat password berubah
        passwordInput.addEventListener('input', checkConfirmPassword);
    </script>
</body>

</html>