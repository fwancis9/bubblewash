<style>
    .admin-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 10px;
    }

    .admin-table-wrapper {
        overflow-x: auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .admin-table thead {
        background: #1f5f72;
        color: white;
    }

    .admin-table th {
        padding: 0.75rem 0.5rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.85rem;
        border-bottom: 2px solid #164557;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .admin-table th:last-child {
        border-right: none;
    }

    .admin-table tbody tr {
        border-bottom: 1px solid #e0e0e0;
        transition: background-color 0.2s ease;
    }

    .admin-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .admin-table td {
        padding: 0.75rem 0.5rem;
        font-size: 0.85rem;
        color: #333;
        text-align: center;
        border-right: 1px solid rgba(0, 0, 0, 0.03);
    }

    .admin-table td:last-child {
        border-right: none;
    }

    .action-btn {
        padding: 0.4rem 0.8rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        display: inline-block;
        margin-right: 0.25rem;
    }

    .action-btn.edit {
        background-color: #ffc107;
        color: #000;
    }

    .action-btn.edit:hover {
        background-color: #e0a800;
    }

    .action-btn.delete {
        background-color: #dc3545;
        color: #fff;
    }

    .action-btn.delete:hover {
        background-color: #c82333;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #666;
    }

    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 1rem 0;
        margin: 0;
        gap: 0.5rem;
    }

    .page-item {
        display: inline-block;
    }

    .page-link {
        display: block;
        padding: 0.5rem 0.75rem;
        color: #1f5f72;
        text-decoration: none;
        background-color: white;
        border: 2px solid #e0e0e0;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        font-weight: 500;
        min-width: 40px;
        text-align: center;
    }

    .page-link:hover {
        background-color: #f0f8ff;
        border-color: #1f5f72;
        color: #164557;
    }

    .page-item.active .page-link {
        background-color: #1f5f72;
        border-color: #1f5f72;
        color: white;
        cursor: default;
    }

    .page-item.disabled .page-link {
        color: #ccc;
        border-color: #e0e0e0;
        cursor: not-allowed;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .admin-table {
            font-size: 0.85rem;
        }

        .admin-table th,
        .admin-table td {
            padding: 0.75rem 0.5rem;
        }

        .page-link {
            padding: 0.4rem 0.6rem;
            min-width: 35px;
            font-size: 0.9rem;
        }

        .pagination {
            gap: 0.3rem;
        }
    }
</style>

<div class="admin-content">
    <?php if (isset($users) && !empty($users)): ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
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
                            <td>
                                <?= date('M j, Y', strtotime($user['created_at'])) ?>
                                <br>
                                <small style="color: #999;">
                                    <?= date('g:i A', strtotime($user['created_at'])) ?>
                                </small>
                            </td>
                            <td>
                                <?= date('M j, Y', strtotime($user['updated_at'])) ?>
                                <br>
                                <small style="color: #999;">
                                    <?= date('g:i A', strtotime($user['updated_at'])) ?>
                                </small>
                            </td>
                            <td>
                                <button onclick="editUser(<?= $user['id'] ?>, '<?= esc($user['email'], 'js') ?>')" class="action-btn edit">
                                    Edit
                                </button>
                                <button onclick="deleteUser(<?= $user['id'] ?>, '<?= esc($user['email'], 'js') ?>')" class="action-btn delete">
                                    Delete
                                </button>
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
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-state">
            <p style="font-size: 1.1rem; color: #666;">No users registered yet.</p>
        </div>
    <?php endif; ?>
</div>

<script>
function editUser(userId, currentEmail) {
    Swal.fire({
        title: 'Edit User',
        html: `
            <div style="text-align: left;">
                <label for="swal-email" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #333;">Email Address</label>
                <input id="swal-email" class="swal2-input" value="${currentEmail}" style="width: 100%; margin: 0; box-sizing: border-box;">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#1f5f72',
        cancelButtonColor: '#6c757d',
        customClass: {
            confirmButton: 'rounded-pill',
            cancelButton: 'rounded-pill'
        },
        preConfirm: () => {
            const email = document.getElementById('swal-email').value;
            if (!email) {
                Swal.showValidationMessage('Email is required');
                return false;
            }
            if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                Swal.showValidationMessage('Please enter a valid email address');
                return false;
            }
            return { email: email };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`<?= site_url('admin/update-user') ?>`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    user_id: userId,
                    email: result.value.email
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'User updated successfully',
                        confirmButtonColor: '#1f5f72',
                        customClass: {
                            confirmButton: 'rounded-pill'
                        }
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to update user',
                        confirmButtonColor: '#1f5f72',
                        customClass: {
                            confirmButton: 'rounded-pill'
                        }
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the user',
                    confirmButtonColor: '#1f5f72',
                    customClass: {
                        confirmButton: 'rounded-pill'
                    }
                });
            });
        }
    });
}

function deleteUser(userId, userEmail) {
    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to delete user '${userEmail}'? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<span style="color: white;">Yes, delete</span>',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        customClass: {
            confirmButton: 'rounded-pill',
            cancelButton: 'rounded-pill'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `<?= site_url('admin/delete') ?>/${userId}`;
        }
    });
}
</script>

<style>
.action-btn {
    border: none;
    cursor: pointer;
    text-decoration: none;
    padding: 0.4rem 1rem;
    border-radius: 0.5rem;
    font-weight: normal;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    font-family: inherit;
    line-height: 1.5;
}

.action-btn.edit {
    background-color: #ffc107;
    color: black;
}

.action-btn.edit:hover {
    background-color: #ffb300;
}

.action-btn.delete {
    background-color: #dc3545;
    color: white;
}

.action-btn.delete:hover {
    background-color: #c82333;
}

.swal2-actions button {
    height: 40px !important;
    min-height: 40px !important;
    padding: 0.5rem 1.5rem !important;
}
</style>