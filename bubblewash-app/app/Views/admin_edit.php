<?= $this->include('templates/header', ['title' => 'Edit User']) ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit User</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url('admin/edit/' . $user['id']) ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="user_id" value="<?= esc($user['id']) ?>" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= esc($user['email']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="created_at" class="form-label">Created At</label>
                            <input type="text" class="form-control" id="created_at" value="<?= esc($user['created_at']) ?>" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="updated_at" class="form-label">Updated At</label>
                            <input type="text" class="form-control" id="updated_at" value="<?= esc($user['updated_at']) ?>" readonly>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/admin" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Email</button>
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
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>
