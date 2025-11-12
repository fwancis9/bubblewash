<?= $this->include('templates/header', ['title' => 'Admin Panel']) ?>

<div class="container">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
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
                            
                            <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
                                <?php 
                                    $currentPage = $pager->getCurrentPage();
                                    $totalPages = $pager->getPageCount();
                                ?>
                                <div class="d-flex justify-content-center mt-4">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php if ($currentPage > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                            <?php else: ?>
                                                <li class="page-item disabled">
                                                    <span class="page-link" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </span>
                                                </li>
                                            <?php endif; ?>

                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <?php if ($i == $currentPage): ?>
                                                    <li class="page-item active">
                                                        <span class="page-link"><?= $i ?></span>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endfor; ?>

                                            <?php if ($currentPage < $totalPages): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?= $currentPage + 1 ?>" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            <?php else: ?>
                                                <li class="page-item disabled">
                                                    <span class="page-link" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </span>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> No users registered yet.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->include('templates/footer') ?>