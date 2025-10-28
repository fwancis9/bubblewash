<?= $this->include('templates/header', ['title' => 'Home']) ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body text-center p-5">
                    <?php if ($isLoggedIn): ?>
                        <!-- Logged in user content -->
                        <h1 class="card-title display-4 text-primary mb-4">Welcome back, <?= esc($userEmail) ?>!</h1>
                        <p class="card-text lead mb-4">Ready to book your car wash service?</p>
                        
                        <!-- Services for logged in users -->
                        <h1>Available Services</h1>
                        <div class="row g-3 mt-4">
                            <div class="col-md-4">
                                <h1>Basic Wash - $15</h1>
                            </div>
                            <div class="col-md-4">
                                <h1>Premium Wash - $25</h1>
                            </div>
                            <div class="col-md-4">
                                <h1>Deluxe Wash - $35</h1>
                            </div>
                        </div>
                        
                        <div class="mt-5">
                            <a href="/logout" class="btn btn-outline-secondary">Logout</a>
                        </div>
                        
                    <?php else: ?>
                        <!-- Non-logged in user content -->
                        <h1>Welcome to BubbleWash</h1>
                        <p class="card-text lead mb-4">Your premier car wash service - making your vehicle shine like new!</p>
                        
                        <div class="mt-5">
                            <a href="/login" class="btn btn-primary btn-lg me-3">Get Started</a>
                            <a href="/register" class="btn btn-outline-primary btn-lg">Sign Up</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>