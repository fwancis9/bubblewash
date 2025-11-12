<?= $this->include('templates/header', ['title' => 'Home']) ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-4 text-primary">BubbleWash</h1>
                <p class="lead">Professional Laundry Service</p>
            </div>

            <?php if ($isLoggedIn): ?>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <h5 class="card-title">Wash & Fold</h5>
                                <p class="card-text">₱120/kg</p>
                                <small class="text-muted">Regular clothes washing and folding</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <h5 class="card-title">Dry Cleaning</h5>
                                <p class="card-text">₱400-750/item</p>
                                <small class="text-muted">Professional dry cleaning service</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <h5 class="card-title">Bedding & Linens</h5>
                                <p class="card-text">₱750-1,250/set</p>
                                <small class="text-muted">Sheets, comforters, and pillows</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <h5 class="card-title">Express Service</h5>
                                <p class="card-text">+50% fee</p>
                                <small class="text-muted">Same-day pickup and delivery</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="card border-0 bg-light">
                        <div class="card-body p-5">
                            <i class="bi bi-lock-fill text-muted mb-3" style="font-size: 3rem;"></i>
                            <h3 class="text-muted mb-3">Log in to view our offers</h3>
                            <p class="text-muted mb-4">Access our full range of professional laundry services and special pricing by logging into your account.</p>
                            <a href="/login" class="btn btn-primary btn-lg me-3">Login</a>
                            <a href="/register" class="btn btn-outline-primary btn-lg">Sign Up</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($isLoggedIn): ?>
                <div class="text-center mt-5">
                    <p class="mb-3">Welcome back, <?= esc($userEmail) ?>!</p>
                    <a href="/logout" class="btn btn-outline-secondary">Log Out</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>