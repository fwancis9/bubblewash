<?= $this->include('templates/header', ['title' => 'Admin Panel']) ?>

<div class="container">
    <!-- Success/Error Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
        <!-- Admin Dashboard - Logged In -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="text-primary">Admin Dashboard</h1>
                    <div>
                        <span class="badge bg-success me-2">Welcome, <?= esc(session()->get('admin_username')) ?></span>
                        <a href="/admin/logout" class="btn btn-outline-danger btn-sm">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Registered Users</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($users) && !empty($users)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?= esc($user['id']) ?></td>
                                                <td><?= esc($user['email']) ?></td>
                                                <td><?= esc($user['created_at']) ?></td>
                                                <td><?= esc($user['updated_at']) ?></td>
                                                <td>
                                                    <a href="/admin/edit/<?= esc($user['id']) ?>" class="btn btn-warning btn-sm me-1">
                                                        Edit
                                                    </a>
                                                    <a href="/admin/delete/<?= esc($user['id']) ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Are you sure you want to delete user \'<?= esc($user['email']) ?>\'? This action cannot be undone.')">
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> No users registered yet.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Admin Login Form -->
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4 class="text-primary">Admin Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('admin') ?>">
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?= old('username') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <!-- Error Display -->
                        <?php if (isset($errors) && !empty($errors)): ?>
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Demo Credentials -->
                        <div class="mt-3">
                            <small class="text-muted">
                                <strong>Demo Credentials:</strong><br>
                                Username: admin<br>
                                Password: admin123
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->include('templates/footer') ?>