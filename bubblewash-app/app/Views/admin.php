<?= $this->include('templates/header', ['title' => 'Admin Panel']) ?>

<?php
    $logoImage        = base_url('assets/images/bubblewash_logo_1.png');
    $brandLogo        = base_url('assets/images/bubblewash_logo_2.png');
    $bgImage          = base_url('assets/images/bubblewash_bg_colors.jpg');
    $washerIllustration = base_url('assets/images/washing_machine.png');
?>

<style>
    .home-hero {
        background: url('<?= $bgImage ?>') center center / cover no-repeat fixed;
        min-height: 100vh;
    }

    .home-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(23, 60, 75, 0.45);
        backdrop-filter: blur(1px);
    }

    .home-logo {
        max-width: 280px;
    }

    .home-hero,
    .home-hero > .container {
        min-height: 100vh;
    }

    .home-hero > .container {
        display: flex;
        align-items: stretch;
    }

    .home-hero .row {
        flex: 1;
    }

    .letter-spacing-lg {
        letter-spacing: 0.15rem;
    }

    .hero-column {
        min-height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: stretch;
        align-items: stretch;
        padding: 3rem 0 4.5rem 0;
    }

    .hero-card {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.92);
        border-radius: 1.5rem;
        outline: 1px solid rgba(255, 255, 255, 0.85);
        outline-offset: 4px;
        box-shadow: 0 12px 20px rgba(31, 95, 114, 0.18);
        position: relative;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .hero-card .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
        position: relative;
        z-index: 1;
    }

    .hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('<?= base_url('assets/images/bubbles_bg.png') ?>') center center / cover no-repeat;
        opacity: 0.5;
        border-radius: 1.5rem;
        pointer-events: none;
        z-index: 0;
    }

    .hero-card::after {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 1.35rem;
        pointer-events: none;
        z-index: 0;
    }

    .text-brand {
        color: #1f5f72 !important;
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

    .hero-illustration {
        height: clamp(110px, 18vh, 180px);
        width: auto;
        max-width: 60%;
        margin: 0 auto 1rem auto;
        object-fit: contain;
    }

    .nav-buttons {
        display: flex;
        align-items: center;
    }

    .nav-buttons.left {
        background-color: #1f5f72;
        border-radius: 2rem;
        padding: 4px;
        gap: 4px;
    }

    .nav-btn {
        color: #fff;
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        background: transparent;
    }

    .nav-buttons.left .nav-btn {
        background-color: transparent;
    }

    .nav-buttons.left .nav-btn.active {
        background-color: #fff;
        color: #1f5f72;
    }

    .logout-btn {
        background-color: #dc3545;
        color: #fff;
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }

    .logout-btn:hover {
        background-color: #c82333;
        color: #fff;
    }

    .branding-nav-wrapper {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .branding-nav-wrapper .nav-buttons.left {
        justify-self: start;
    }

    .branding-nav-wrapper .home-logo {
        justify-self: center;
    }

    .branding-nav-wrapper .logout-btn {
        justify-self: end;
    }

    @media (max-width: 991px) {
        .branding-nav-wrapper {
            flex-direction: column;
            gap: 1rem;
        }

        .nav-buttons {
            justify-content: center;
        }
    }
</style>

<section class="home-hero position-relative overflow-hidden text-center text-white d-flex align-items-stretch p-0">
    <div class="position-relative container p-0">
        <div class="row justify-content-center g-0">
            <div class="col-12 col-lg-11 col-xl-10 hero-column">
                <div class="branding-nav-wrapper">
                    <div class="nav-buttons left">
                        <a href="<?= site_url('admin/bubbles') ?>" class="nav-btn <?= ($activeSection === 'bubbles') ? 'active' : '' ?>">Manage Bubbles</a>
                        <a href="<?= site_url('admin/users') ?>" class="nav-btn <?= ($activeSection === 'users') ? 'active' : '' ?>">Manage Users</a>
                    </div>
                    <a href="<?= site_url('/') ?>">
                        <img src="<?= $brandLogo ?>" alt="BubbleWash" class="home-logo img-fluid" style="cursor: pointer;">
                    </a>
                    <a href="/admin/logout" class="logout-btn">Log Out</a>
                </div>
                <div class="card border-0 shadow-lg overflow-hidden hero-card">
                    <div class="card-body p-4 p-lg-5 text-center text-dark">
                        <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
                            <?= $this->include('templates/admin/' . $activeSection) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (session()->getFlashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '<?= esc(session()->getFlashdata('success')) ?>',
        confirmButtonColor: '#1f5f72'
    });
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '<?= esc(session()->getFlashdata('error')) ?>',
        confirmButtonColor: '#1f5f72'
    });
</script>
<?php endif; ?>

<?= $this->include('templates/footer') ?>
