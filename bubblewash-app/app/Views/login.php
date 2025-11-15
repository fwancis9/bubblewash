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

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-info">
                            <?= session()->getFlashdata('error') ?>
                            <?php if (session()->get('pending_verification_email')): ?>
                                <br><small>Didn't receive the email? 
                                    <form method="post" action="<?= base_url('login/resend') ?>" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-link p-0 align-baseline alert-link" style="text-decoration: underline;">Resend verification email</button>
                                    </form>
                                </small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('login') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address or Username</label>
                            <input type="text" class="form-control" id="email" name="email" 
                                   placeholder="Enter your email or username" value="<?= old('email') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Enter your password" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                        
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
                    
                    <div class="text-center mb-3">
                        <div class="alert alert-info py-2">
                            <small class="text-muted">
                                <strong>Admin Login:</strong><br>
                                Username: <code>admin</code><br>
                                Password: <code>admin</code>
                            </small>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <p class="mb-0">Don't have an account? <a href="/register" class="text-decoration-none">Sign up here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>