<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Profil</h5>
                </div>
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

                    <form action="<?= site_url('profile/update') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?= old('username', $user['username']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= old('email', $user['email'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password">Password Baru</label>
                            <div class="password-container position-relative">
                                <input type="password" class="form-control" id="password" name="password"
                                    oninput="checkPasswordStrength()" placeholder="Masukkan password baru">
                                <i class="bi bi-eye-slash password-toggle" id="togglePassword"
                                    onclick="togglePasswordVisibility('password', 'togglePassword')"
                                    title="Show/Hide Password"
                                    style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
                            </div>
                            <!-- checklist tetap di luar password-container -->
                            <ul id="password-checklist" class="text-start small mt-2 mb-0 list-unstyled"
                                style="display:none;">
                                <li id="check-length"><span class="me-1" id="icon-length">❌</span>Minimal 8 karakter
                                </li>
                                <li id="check-case"><span class="me-1" id="icon-case">❌</span>Huruf besar & kecil</li>
                                <li id="check-symbol"><span class="me-1" id="icon-symbol">❌</span>Mengandung simbol</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password">Konfirmasi Password Baru</label>
                            <div class="password-container position-relative">
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" placeholder="Konfirmasi password baru">
                                <i class="bi bi-eye-slash password-toggle" id="toggleConfirmPassword"
                                    onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmPassword')"
                                    title="Show/Hide Confirm Password"
                                    style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
                            </div>
                            <ul id="confirm-password-checklist" class="text-start small mt-2 mb-0 list-unstyled"
                                style="display:none;">
                                <li id="check-confirm"><span class="me-1" id="icon-confirm">❌</span>Password dan
                                    konfirmasi harus sama</li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="<?= site_url('profile') ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

// function isPasswordValid() {
//     const password = passwordInput.value;
//     return (
//         password.length >= 8 &&
//         /[a-z]/.test(password) &&
//         /[A-Z]/.test(password) &&
//         /[^A-Za-z0-9]/.test(password)
//     );
// }

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

// function isConfirmValid() {
//     return (
//         confirmInput.value.length > 0 &&
//         passwordInput.value === confirmInput.value
//     );
// }

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
<?= $this->endSection() ?>