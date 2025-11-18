<?= $this->include('templates/header', ['title' => 'Forgot Password']) ?>

<?php
    $bgImage    = base_url('assets/images/bubblewash_bg.jpg');
    $logoImage  = base_url('assets/images/bubblewash_logo_1.png');
?>

<style>
    body {
        background: url('<?= $bgImage ?>') no-repeat center center fixed;
        background-size: cover;
    }

    .forgot-password-card {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.92);
        border-radius: 1.1rem;
        outline: 1px solid rgba(255, 255, 255, 0.85);
        outline-offset: 4px;
        box-shadow: 0 12px 20px rgba(31, 95, 114, 0.18);
        position: relative;
    }

    .forgot-password-card::before {
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

    .forgot-password-card::after {
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

    .forgot-password-card .card-body {
        position: relative;
        z-index: 1;
    }

    .forgot-password-card .form-control {
        background-color: rgba(143, 143, 143, 0.35);
        border: none;
        padding-left: 2.5rem;
        font-size: 1rem;
        color: #333;
    }

    .forgot-password-card .form-control:focus {
        box-shadow: none;
        background-color: rgba(143, 143, 143, 0.45);
    }

    .forgot-password-card .field-icon {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #1f5f72;
        pointer-events: none;
        font-size: 1.1rem;
    }

    .forgot-password-card .btn {
        font-size: 1rem;
    }

    .forgot-password-field-group {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    .right-card-wrapper {
        max-width: 320px;
        transform-origin: center;
    }

    .forgot-password-card h2 {
        font-size: 2rem;
    }

    .forgot-password-card .text-muted {
        font-size: 0.95rem;
    }

    .forgot-password-card .form-control::placeholder {
        color: #8f8f8f;
        opacity: 1;
    }

    .info-text {
        font-size: 0.9rem;
        color: #555;
        line-height: 1.5;
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
                <div class="card forgot-password-card shadow-lg border-0">
                    <div class="card-body px-3 py-4">
                        <div class="text-center mb-3">
                            <h2 class="fw-bold" style="color: #1f5f72;">Forgot Password</h2>
                            <p class="info-text mt-2 mb-0">Enter your email address and we'll send you a link to reset your password.</p>
                        </div>

                        <form method="post" action="<?= base_url('forgot-password') ?>">
                            <?= csrf_field() ?>

                            <div class="forgot-password-field-group">
                                <div class="mb-2">
                                    <div class="position-relative">
                                        <i class="bi bi-envelope-fill field-icon"></i>
                                        <input
                                            type="email"
                                            class="form-control form-control-lg rounded-pill"
                                            id="email"
                                            name="email"
                                            placeholder="Email Address"
                                            value="<?= old('email') ?>"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-lg py-2 text-white rounded-pill" style="background-color: #1f5f72;">
                                    Send Reset Link
                                </button>
                            </div>

                            <div class="text-center">
                                <span class="text-muted">Remember your password? <a href="<?= site_url('login') ?>" class="text-decoration-none" style="color: #1f5f72;">Log In</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>

<script>
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            html: `<?= addslashes(session()->getFlashdata('success')) ?>`,
            confirmButtonColor: '#1f5f72',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `<?= addslashes(session()->getFlashdata('error')) ?>`,
            confirmButtonColor: '#1f5f72',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
</script>

