<?= $this->include('templates/header', ['title' => 'Invalid Verification Link']) ?>

<?php
    $bgImage    = base_url('assets/images/bubblewash_bg.jpg');
    $logoImage  = base_url('assets/images/bubblewash_logo_1.png');
?>

<style>
    body {
        background: url('<?= $bgImage ?>') no-repeat center center fixed;
        background-size: cover;
    }

    .verification-card {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.92);
        border-radius: 1.1rem;
        outline: 1px solid rgba(255, 255, 255, 0.85);
        outline-offset: 4px;
        box-shadow: 0 12px 20px rgba(31, 95, 114, 0.18);
        position: relative;
    }

    .verification-card::before {
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

    .verification-card::after {
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

    .verification-card .card-body {
        position: relative;
        z-index: 1;
    }

    .right-card-wrapper {
        max-width: 420px;
        transform-origin: center;
    }

    .btn-brand {
        background-color: #1f5f72;
        border-color: #1f5f72;
        color: #fff;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }

    .btn-brand:hover,
    .btn-brand:focus {
        background-color: #164557;
        border-color: #164557;
        color: #fff;
    }

    .btn-brand-outline {
        color: #1f5f72;
        border-color: #1f5f72;
        transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
    }

    .btn-brand-outline:hover,
    .btn-brand-outline:focus {
        color: #fff;
        background-color: #1f5f72;
        border-color: #1f5f72;
    }

    .text-brand {
        color: #1f5f72 !important;
    }

    .error-icon {
        font-size: 4rem;
        color: #dc3545;
        margin-bottom: 1rem;
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
                <div class="card verification-card border-0">
                    <div class="card-body p-4 p-lg-5 text-center">
                        <div class="error-icon">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                        
                        <h2 class="fw-bold text-brand mb-3">Invalid</h2>
                        
                        <p class="text-muted mb-4">The verification link you clicked is invalid or has expired. You can request a new one when you login or register.</p>
                        
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mt-4">
                            <a href="<?= site_url('register') ?>" class="btn btn-brand btn-lg px-4 rounded-pill">Register</a>
                            <a href="<?= site_url('login') ?>" class="btn btn-brand-outline btn-lg px-4 rounded-pill">Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>

