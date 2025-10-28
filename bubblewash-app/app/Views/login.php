<?= $this->include('templates/header', ['title' => 'Login']) ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="card-title text-primary">Login</h2>
                        <p class="text-muted">Sign in to your account</p>
                    </div>

                    <form method="post" action="<?= base_url('login') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="Enter your email" value="<?= old('email') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Enter your password" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                        
                        <!-- Display login errors -->
                        <?php if (isset($errors) && !empty($errors)): ?>
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </form>

                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">Don't have an account? <a href="/register" class="text-decoration-none">Sign up here</a></p>
                        <small class="text-muted">
                            <a href="#" class="text-decoration-none">Forgot your password?</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>