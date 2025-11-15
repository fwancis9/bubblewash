<?= $this->include('templates/header', ['title' => 'Register']) ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="card-title text-primary">Create Account</h2>
                        <p class="text-muted">Join BubbleWash today</p>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                            <?php if (session()->get('pending_verification_email')): ?>
                                <br><small>Didn't receive the email? 
                                    <form method="post" action="<?= base_url('register/resend') ?>" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-link p-0 align-baseline alert-link" style="text-decoration: underline;">Resend verification email</button>
                                    </form>
                                </small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?= esc($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('register') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="Enter your email" value="<?= old('email') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Create password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   placeholder="Confirm password" required>
                        </div>
                        
                        <div class="alert alert-info">
                            <small><strong>Note:</strong> After registration, you'll receive a verification email. Please verify your email to activate your account.</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Account</button>
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
                    
                    <div class="text-center">
                        <p class="mb-0">Already have an account? <a href="/login" class="text-decoration-none">Sign in here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>