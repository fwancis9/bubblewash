<?= $this->include('templates/header', ['title' => 'Login']) ?>

<?php
    $bgImage    = base_url('assets/images/bubblewash_bg.jpg');
    $logoImage  = base_url('assets/images/bubblewash_logo_1.png');
?>

<style>
    body {
        background: url('<?= $bgImage ?>') no-repeat center center fixed;
        background-size: cover;
    }

    .login-card,
    .admin-card {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.92);
        border-radius: 1.1rem;
    }

    .login-card {
        outline: 1px solid rgba(255, 255, 255, 0.85);
        outline-offset: 4px;
        box-shadow: 0 12px 20px rgba(31, 95, 114, 0.18);
        position: relative;
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('<?= base_url('assets/images/bubbles_bg.png') ?>') center center / cover no-repeat;
        opacity: 0.5;
        border-radius: 1.1rem;
        pointer-events: none;
        z-index: 0;
    }

    .login-card::after {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 0.95rem;
        pointer-events: none;
        z-index: 0;
    }

    .login-card .card-body {
        position: relative;
        z-index: 1;
    }

    .login-card .form-control {
        background-color: rgba(143, 143, 143, 0.35);
        border: none;
        padding-left: 2.5rem;
        font-size: 1rem;
        color: #333;
    }

    .login-card .form-control:focus {
        box-shadow: none;
        background-color: rgba(143, 143, 143, 0.45);
    }

    .login-card .field-icon {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #1f5f72;
        pointer-events: none;
        font-size: 1.1rem;
    }

    .login-card .btn {
        font-size: 1rem;
    }

    .login-field-group {
        margin-top: 3.3rem;
        margin-bottom: 3.3rem;
    }

    .right-card-wrapper {
        max-width: 320px;
        transform-origin: center;
    }

    .forgot-password-link {
        font-size: 0.9rem;
    }

    .login-card h2 {
        font-size: 2rem;
    }

    .login-card .text-muted {
        font-size: 0.95rem;
    }

    .admin-credentials {
        max-height: 0;
        overflow: hidden;
        margin-top: 0;
        transition: max-height 0.25s ease, margin-top 0.25s ease;
    }

    .admin-credentials.show {
        max-height: 120px;
        margin-top: 0.5rem;
    }

    .login-card .form-control::placeholder {
        color: #8f8f8f;
        opacity: 1;
    }
</style>

<div class="container-fluid">
    <div class="row align-items-center justify-content-center" style="min-height: 100vh; gap: 3rem;">
        <div class="col-lg-5 d-none d-lg-flex justify-content-center align-items-center">
            <a href="<?= site_url('/') ?>">
                <img src="<?= $logoImage ?>" alt="BubbleWash" style="max-width: 340px; cursor: pointer;" class="img-fluid">
            </a>
        </div>

        <div class="col-lg-5 d-flex justify-content-center align-items-center">
            <div class="w-100 right-card-wrapper">
                <div class="card login-card shadow-lg border-0">
                    <div class="card-body px-3 py-3">
                        <div class="text-center mb-3">
                            <h2 class="fw-bold" style="color: #1f5f72;">Log In</h2>
                        </div>

                        <form method="post" action="<?= base_url('login') ?>">
                            <?= csrf_field() ?>

                            <div class="login-field-group">
                                <div class="mb-2">
                                    <div class="position-relative">
                                        <i class="bi bi-person-fill field-icon"></i>
                                        <input
                                            type="text"
                                            class="form-control form-control-lg rounded-pill"
                                            id="email"
                                            name="email"
                                            placeholder="Email Address"
                                            value="<?= old('email') ?>"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="position-relative">
                                        <i class="bi bi-lock-fill field-icon"></i>
                                        <input
                                            type="password"
                                            class="form-control form-control-lg rounded-pill"
                                            id="password"
                                            name="password"
                                            placeholder="Password"
                                            required
                                        >
                                    </div>
                                    <div class="text-end mt-2">
                                        <a href="<?= site_url('forgot-password') ?>" class="text-muted text-decoration-none forgot-password-link">Forgot password?</a>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mb-2">
                                <button type="submit" class="btn btn-lg py-2 text-white rounded-pill" style="background-color: #1f5f72;">
                                    Log In
                                </button>
                            </div>

                            <div class="text-center mb-1">
                                <span class="text-muted">Need an account? <a href="<?= site_url('register') ?>" class="text-decoration-none" style="color: #1f5f72;">Register</a></span>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <div class="alert admin-card py-2 px-3 mb-0 d-inline-block admin-toggle" style="background-color: #396d84; border: 1px solid #396d84; color: #ffffff; font-size: 0.8rem; width: 100%; cursor: pointer;">
                        <div class="d-flex justify-content-between align-items-center admin-toggle-header fw-semibold">
                            <span>Admin Login</span>
                            <span class="admin-toggle-icon"><i class="bi bi-eye-fill"></i></span>
                        </div>
                        <div class="admin-credentials text-start">
                            <div>Username: <code>admin</code></div>
                            <div>Password: <code>admin</code></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const adminToggle = document.querySelector('.admin-toggle');
        if (!adminToggle) return;

        const creds = adminToggle.querySelector('.admin-credentials');
        const icon = adminToggle.querySelector('.admin-toggle-icon i');

        adminToggle.addEventListener('click', function () {
            const isHidden = !creds.classList.contains('show');
            creds.classList.toggle('show', isHidden);
            icon.classList.toggle('bi-eye-fill', !isHidden);
            icon.classList.toggle('bi-eye-slash-fill', isHidden);
        });
    });

    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            html: `<?= addslashes(session()->getFlashdata('success')) ?>`,
            confirmButtonColor: '#1f5f72',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>

    <?php
        $errorMessages = [];
        $flashError = session()->getFlashdata('error');
        
        if ($flashError) {
            $errorMessages[] = $flashError;
        }
        
        if (!empty($errors ?? [])) {
            $errorMessages = array_merge($errorMessages, $errors);
        }
    ?>

    <?php if (!empty($errorMessages)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `<div style="text-align: center;">
                <ul style="display: inline-block; text-align: left; padding-left: 1.5rem; margin: 0;">
                    <?php foreach ($errorMessages as $message): ?>
                        <li><?= addslashes(esc($message)) ?></li>
                        <?php if ($message === $flashError && session()->get('pending_verification_email')): ?>
                            <li style="list-style: none; padding-left: 0; margin-top: 0.5rem;">
                                <small style="font-size: 0.9em; color: #666;">Didn't receive the email? 
                                    <a href="#" id="resendLink" style="text-decoration: underline; color: #1f5f72;">Resend verification email</a>
                                </small>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>`,
            confirmButtonColor: '#1f5f72',
            confirmButtonText: 'OK'
        });

        <?php if (session()->get('pending_verification_email')): ?>
            document.addEventListener('click', function(e) {
                if (e.target && e.target.id === 'resendLink') {
                    e.preventDefault();
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '<?= base_url('login/resend') ?>';
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '<?= csrf_token() ?>';
                    csrf.value = '<?= csrf_hash() ?>';
                    form.appendChild(csrf);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        <?php endif; ?>
    <?php endif; ?>
</script>