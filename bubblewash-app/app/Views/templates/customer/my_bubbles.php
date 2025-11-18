<style>
    .bubbles-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px;
    }

    .bubbles-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f5f72;
        margin-bottom: 1.5rem;
        text-align: center;
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
        min-width: 800px;
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

    .bubbles-table tbody tr:last-child {
        border-bottom: none;
    }

    .bubbles-table td {
        padding: 0.65rem 0.5rem;
        color: #333;
        font-size: 0.85rem;
        text-align: center;
        border-right: 1px solid rgba(0, 0, 0, 0.03);
    }

    .bubbles-table td:last-child {
        border-right: none;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.65rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-bubbling {
        background-color: #cfe2ff;
        color: #084298;
    }

    .status-ready_for_pickup {
        background-color: #e2d9f3;
        color: #5a1f9c;
    }

    .status-completed {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #842029;
    }

    .service-type-badge {
        display: inline-block;
        padding: 0.2rem 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        background-color: #5a8599;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #666;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 1rem;
    }

    .empty-state-text {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .start-bubble-btn {
        background-color: #1f5f72;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 2rem;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .start-bubble-btn:hover {
        background-color: #164557;
        color: white;
        transform: translateY(-2px);
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
        padding: 0.75rem 0;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
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
    <?php if (empty($userBubbles)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">🫧</div>
            <div class="empty-state-text">No bubbles yet! Start your first laundry order.</div>
            <a href="<?= site_url('customer/weighted') ?>" class="start-bubble-btn">Start BubbleNow</a>
        </div>
    <?php else: ?>
        <div class="bubbles-table-wrapper">
            <table class="bubbles-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
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
                    <?php foreach ($userBubbles as $bubble): ?>
                        <tr>
                            <td>#<?= str_pad($bubble['id'], 4, '0', STR_PAD_LEFT) ?></td>
                            <td>
                                <span class="service-type-badge">
                                    <?= ucfirst($bubble['service_type']) ?>
                                </span>
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
                                <span class="status-badge status-<?= $bubble['status'] ?>">
                                    <?php
                                        $statusLabels = [
                                            'pending' => 'Pending',
                                            'bubbling' => 'Bubbling',
                                            'ready_for_pickup' => 'Ready for Pickup',
                                            'completed' => 'Completed',
                                            'cancelled' => 'Cancelled'
                                        ];
                                        echo $statusLabels[$bubble['status']] ?? ucfirst($bubble['status']);
                                    ?>
                                </span>
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
            <div class="pagination-wrapper">
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
    <?php endif; ?>
</div>

<script>
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            html: `<?= addslashes(session()->getFlashdata('success')) ?>`,
            confirmButtonColor: '#1f5f72',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
</script>
