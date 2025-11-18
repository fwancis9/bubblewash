<style>
    .bubbles-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 10px;
    }

    .bubbles-table-wrapper {
        overflow-x: auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .bubbles-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .bubbles-table thead {
        background: #1f5f72;
        color: white;
    }

    .bubbles-table th {
        padding: 0.75rem 0.5rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.85rem;
        border-bottom: 2px solid #164557;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .bubbles-table th:last-child {
        border-right: none;
    }

    .bubbles-table tbody tr {
        border-bottom: 1px solid #e0e0e0;
        transition: background-color 0.2s ease;
    }

    .bubbles-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .bubbles-table td {
        padding: 0.75rem 0.5rem;
        font-size: 0.85rem;
        color: #333;
        text-align: center;
        border-right: 1px solid rgba(0, 0, 0, 0.03);
    }

    .bubbles-table td:last-child {
        border-right: none;
    }

    .service-type-badge {
        background: #1f5f72;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-pending {
        background: #ffc107;
        color: #000;
    }

    .status-bubbling {
        background: #17a2b8;
        color: #fff;
    }

    .status-ready_for_pickup {
        background: #9c27b0;
        color: #fff;
    }

    .status-completed {
        background: #28a745;
        color: #fff;
    }

    .status-cancelled {
        background: #dc3545;
        color: #fff;
    }

    .status-select {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        border: 2px solid transparent;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        appearance: none;
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 12px;
        padding-right: 1.5rem;
    }

    .status-select:hover {
        opacity: 0.8;
        border-color: rgba(0, 0, 0, 0.2);
    }

    .status-select:focus {
        outline: none;
        border-color: rgba(0, 0, 0, 0.3);
    }

    .status-select.status-pending {
        background-color: #ffc107;
        color: #000;
    }

    .status-select.status-bubbling {
        background-color: #17a2b8;
        color: #fff;
    }

    .status-select.status-ready_for_pickup {
        background-color: #9c27b0;
        color: #fff;
    }

    .status-select.status-completed {
        background-color: #28a745;
        color: #fff;
    }

    .status-select.status-cancelled {
        background-color: #dc3545;
        color: #fff;
    }

    .swal-rounded-btn {
        border-radius: 2rem !important;
        padding: 0.6rem 1.5rem !important;
        font-weight: 500 !important;
        height: 44px !important;
        min-height: 44px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
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
        .bubbles-table {
            font-size: 0.85rem;
        }

        .bubbles-table th,
        .bubbles-table td {
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

<div class="bubbles-container">
    <?php if (isset($allBubbles) && !empty($allBubbles)): ?>
        <div class="bubbles-table-wrapper">
            <table class="bubbles-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Service Type</th>
                        <th>Details</th>
                        <th>Folded</th>
                        <th>Price</th>
                        <th>Pickup</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allBubbles as $bubble): ?>
                        <tr>
                            <td>#<?= str_pad($bubble['id'], 4, '0', STR_PAD_LEFT) ?></td>
                            <td><?= esc($bubble['user_email'] ?? 'User #' . $bubble['user_id']) ?></td>
                            <td>
                                <?= ucfirst($bubble['service_type']) ?>
                            </td>
                            <td>
                                <?php if ($bubble['service_type'] === 'weighted'): ?>
                                    <?= $bubble['weight_kg'] ?> kg
                                <?php else: ?>
                                    <?= ucfirst($bubble['package_size']) ?> 
                                    <?php
                                        $ranges = ['small' => '(5-6 kg)', 'medium' => '(7-8 kg)', 'large' => '(9-10 kg)'];
                                        echo $ranges[$bubble['package_size']] ?? '';
                                    ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $bubble['folded'] ? '✓ Yes' : '✗ No' ?>
                            </td>
                            <td style="font-weight: 600; color: #1f5f72;">
                                ₱<?= number_format($bubble['price'], 2) ?>
                            </td>
                            <td>
                                <?php if (!empty($bubble['pickup_date']) && !empty($bubble['pickup_time'])): ?>
                                    <?= date('M j, Y', strtotime($bubble['pickup_date'])) ?>
                                    <br>
                                    <small style="color: #999;"><?= date('g:i A', strtotime($bubble['pickup_time'])) ?></small>
                                <?php else: ?>
                                    <span style="color: #999;">Not set</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <select class="status-select status-<?= $bubble['status'] ?>" data-bubble-id="<?= $bubble['id'] ?>" onchange="updateBubbleStatus(this)">
                                    <option value="pending" <?= $bubble['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="bubbling" <?= $bubble['status'] === 'bubbling' ? 'selected' : '' ?>>Bubbling</option>
                                    <option value="ready_for_pickup" <?= $bubble['status'] === 'ready_for_pickup' ? 'selected' : '' ?>>Ready for Pickup</option>
                                    <option value="completed" <?= $bubble['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= $bubble['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </td>
                            <td>
                                <?= date('M j, Y', strtotime($bubble['created_at'])) ?>
                                <br>
                                <small style="color: #999;">
                                    <?= date('g:i A', strtotime($bubble['created_at'])) ?>
                                </small>
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
            <p style="font-size: 1.1rem; color: #666;">No orders yet.</p>
        </div>
    <?php endif; ?>
</div>

<script>
function updateBubbleStatus(selectElement) {
    const bubbleId = selectElement.getAttribute('data-bubble-id');
    const newStatus = selectElement.value;
    const oldStatus = selectElement.getAttribute('data-old-status');
    
    if (!oldStatus) {
        selectElement.setAttribute('data-old-status', newStatus);
        return;
    }
    
    if (newStatus === oldStatus) {
        return;
    }
    
    const statusLabels = {
        'pending': 'Pending',
        'bubbling': 'Bubbling',
        'ready_for_pickup': 'Ready for Pickup',
        'completed': 'Completed',
        'cancelled': 'Cancelled'
    };
    
    Swal.fire({
        title: 'Update Status?',
        text: `Change status from "${statusLabels[oldStatus]}" to "${statusLabels[newStatus]}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1f5f72',
        cancelButtonColor: '#666',
        confirmButtonText: 'Yes, update it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
            confirmButton: 'swal-rounded-btn',
            cancelButton: 'swal-rounded-btn'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= site_url('admin/update-bubble-status') ?>';
            
            const bubbleIdInput = document.createElement('input');
            bubbleIdInput.type = 'hidden';
            bubbleIdInput.name = 'bubble_id';
            bubbleIdInput.value = bubbleId;
            form.appendChild(bubbleIdInput);
            
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = newStatus;
            form.appendChild(statusInput);
            
            document.body.appendChild(form);
            form.submit();
        } else {
            selectElement.value = oldStatus;
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.status-select').forEach(function(select) {
        select.setAttribute('data-old-status', select.value);
    });
});
</script>

