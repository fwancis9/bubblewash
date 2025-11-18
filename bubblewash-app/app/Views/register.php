<?= $this->include('templates/header', ['title' => 'Register']) ?>

<?php
    $bgImage    = base_url('assets/images/bubblewash_bg.jpg');
    $logoImage  = base_url('assets/images/bubblewash_logo_1.png');
?>

<style>
    body {
        background: url('<?= $bgImage ?>') no-repeat center center fixed;
        background-size: cover;
    }

    .register-card,
    .note-card {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.92);
        border-radius: 1.1rem;
    }

    .register-card {
        outline: 1px solid rgba(255, 255, 255, 0.85);
        outline-offset: 4px;
        box-shadow: 0 12px 20px rgba(31, 95, 114, 0.18);
        position: relative;
    }

    .register-card::before {
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

    .register-card::after {
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

    .register-card .card-body {
        position: relative;
        z-index: 1;
    }

    .register-card .form-control {
        background-color: rgba(143, 143, 143, 0.35);
        border: none;
        padding-left: 2.5rem;
        font-size: 1rem;
        color: #333;
    }

    .register-card .form-control:focus {
        box-shadow: none;
        background-color: rgba(143, 143, 143, 0.45);
    }

    .register-card .form-control::placeholder {
        color: #8f8f8f;
        opacity: 1;
    }

    .register-card .field-icon {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #1f5f72;
        pointer-events: none;
        font-size: 1.1rem;
    }

    .register-card .btn {
        font-size: 1rem;
    }

    .register-card h2 {
        font-size: 2rem;
    }

    .register-card .text-muted {
        font-size: 0.95rem;
    }

    .note-card {
        background-color: #396d84;
        border: 1px solid #396d84;
        color: #ffffff;
    }

    .register-field-group {
        margin-top: 3.3rem;
        margin-bottom: 3.3rem;
    }

    .right-card-wrapper {
        max-width: 320px;
        transform-origin: center;
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
                <div class="card register-card border-0">
                    <div class="card-body px-3 py-3">
                        <div class="text-center mb-3">
                            <h2 class="fw-bold" style="color: #1f5f72;">Register</h2>
                        </div>

                        <form method="post" action="<?= base_url('register') ?>">
                            <?= csrf_field() ?>

                            <div class="register-field-group">
                                <div class="mb-2">
                                    <div class="position-relative">
                                        <i class="bi bi-envelope-fill field-icon"></i>
                                        <input type="email" class="form-control form-control-lg rounded-pill" id="email" name="email"
                                               placeholder="Email Address" value="<?= old('email') ?>" required>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="position-relative">
                                        <i class="bi bi-lock-fill field-icon"></i>
                                        <input type="password" class="form-control form-control-lg rounded-pill" id="password" name="password"
                                               placeholder="Create Password" required>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="position-relative">
                                        <i class="bi bi-lock-fill field-icon"></i>
                                        <input type="password" class="form-control form-control-lg rounded-pill" id="confirm_password" name="confirm_password"
                                               placeholder="Confirm Password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mb-2">
                                <button type="submit" class="btn btn-lg py-2 text-white rounded-pill" style="background-color: #1f5f72;">
                                    Register
                                </button>
                            </div>

                            <div class="text-center">
                                <span class="text-muted">Already have an account? <a href="<?= site_url('login') ?>" class="text-decoration-none" style="color: #1f5f72;">Log in</a></span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="note-card alert py-2 px-3 mt-3 text-start" style="font-size: 0.7rem;">
                    <strong>Note:</strong> After registration you'll receive a verification email. Please verify to activate your account.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                html: `<?= addslashes(session()->getFlashdata('success')) ?>
                    <?php if (session()->get('pending_verification_email')): ?>
                        <br><br><small style="font-size: 0.9em; color: #666;">Didn't receive the email? 
                            <a href="#" id="resendLink" style="text-decoration: underline; color: #1f5f72;">Resend verification email</a>
                        </small>
                    <?php endif; ?>`,
                confirmButtonColor: '#1f5f72',
                confirmButtonText: 'OK'
            });

            <?php if (session()->get('pending_verification_email')): ?>
                document.addEventListener('click', function(e) {
                    if (e.target && e.target.id === 'resendLink') {
                        e.preventDefault();
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '<?= base_url('register/resend') ?>';
                        
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

        <?php
            $errorMessages = [];
            if (isset($error) && $error) {
                $errorMessages[] = $error;
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
                    <?php endforeach; ?>
                </ul>
            </div>`,
            confirmButtonColor: '#1f5f72',
            confirmButtonText: 'OK'
        });
        <?php endif; ?>
    });
</script>

<?= $this->include('templates/footer') ?>