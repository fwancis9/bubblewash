<?= $this->include('templates/header', ['title' => 'Invalid Verification Link']) ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <h2 class="card-title text-danger">Invalid or Expired Verification Link</h2>
                    </div>
                    
                    <p class="text-muted">The verification link you clicked is invalid or has expired.</p>
                    <p class="text-muted">You can request a new one when you login or register.</p>
                    
                    <div class="mt-4">
                        <a href="/register" class="btn btn-primary me-2">Register</a>
                        <a href="/login" class="btn btn-outline-secondary">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>

