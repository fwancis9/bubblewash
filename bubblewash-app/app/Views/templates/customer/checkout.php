<style>
    .checkout-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px;
        position: relative;
    }

    .checkout-content {
        display: flex;
        gap: 1.5rem;
        width: 100%;
        align-items: flex-start;
    }

    .left-column {
        flex: 1;
    }

    .middle-column {
        flex: 1;
    }

    .right-column {
        flex: 1;
    }

    .back-btn {
        background-color: #dc3545;
        color: #fff;
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
    }

    .back-btn:hover {
        background-color: #c82333;
        color: #fff;
    }

    .checkout-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f5f72;
        margin-bottom: 1.5rem;
    }

    .order-summary {
        width: 100%;
        background: #f0f8ff;
        border: 2px solid #1f5f72;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid #e0e0e0;
        font-size: 0.9rem;
    }

    .summary-row:last-child {
        border-bottom: none;
        padding-top: 0.75rem;
        margin-top: 0.5rem;
        border-top: 2px solid #1f5f72;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .summary-label {
        color: #666;
        font-weight: 500;
    }

    .summary-value {
        color: #333;
        font-weight: 600;
    }

    .folded-option {
        width: 100%;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .folded-option:hover {
        border-color: #5a8599;
    }

    .folded-option.selected {
        border-color: #1f5f72;
        background: #f0f8ff;
    }

    .folded-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0;
    }

    .folded-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #1f5f72;
    }

    .folded-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1f5f72;
        cursor: pointer;
    }

    .folded-description {
        font-size: 0.85rem;
        color: #666;
        margin-left: 2.25rem;
        margin-bottom: 0;
        text-align: left;
    }

    .folded-price {
        font-size: 0.9rem;
        font-weight: 700;
        color: #5a8599;
        margin-left: 2.25rem;
        text-align: right;
    }

    .schedule-section {
        width: 100%;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .schedule-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1f5f72;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        color: #666;
        margin-bottom: 0.4rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #333;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-input:focus {
        outline: none;
        border-color: #1f5f72;
        background: #f0f8ff;
    }

    .important-note {
        background: #fff3cd;
        border: 2px solid #ffc107;
        border-radius: 8px;
        padding: 0.5rem;
        margin-top: 1rem;
        font-size: 0.75rem;
        color: #856404;
        line-height: 1.4;
    }

    .important-note strong {
        color: #856404;
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.75rem;
    }

    .checkout-actions {
        display: flex;
        gap: 1rem;
        width: 100%;
        justify-content: center;
    }

    .checkout-btn {
        padding: 0.65rem 2rem;
        border-radius: 2rem;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
    }

    .confirm-btn {
        background-color: #1f5f72;
        color: white;
    }

    .confirm-btn:hover {
        background-color: #164557;
    }

    .cancel-btn {
        background-color: transparent;
        color: #666;
        border: 2px solid #666;
    }

    .cancel-btn:hover {
        background-color: #666;
        color: white;
    }

    @media (max-width: 768px) {
        .checkout-container {
            padding: 10px;
        }

        .checkout-content {
            flex-direction: column;
            gap: 1.5rem;
        }

        .checkout-actions {
            flex-direction: column;
        }

        .checkout-btn {
            width: 100%;
        }
    }
</style>

<div style="position: absolute; top: 1rem; left: 1rem; z-index: 10;">
    <a href="<?= site_url('customer/' . $checkoutData['service_type']) ?>" class="back-btn">← Go back</a>
</div>

<div class="checkout-container">
    <h2 class="checkout-title">Checkout</h2>

    <div class="checkout-content">
        <div class="left-column">
            <div class="order-summary">
                <div class="summary-row">
                    <span class="summary-label">Service Type:</span>
                    <span class="summary-value" id="serviceTypeDisplay">
                        <?= ucfirst($checkoutData['service_type']) ?>
                    </span>
                </div>

                <?php if ($checkoutData['service_type'] === 'weighted'): ?>
                    <div class="summary-row">
                        <span class="summary-label">Weight:</span>
                        <span class="summary-value"><?= $checkoutData['weight_kg'] ?> kg</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Price per kg:</span>
                        <span class="summary-value">₱50.00</span>
                    </div>
                <?php else: ?>
                    <div class="summary-row">
                        <span class="summary-label">Package Size:</span>
                        <span class="summary-value"><?= ucfirst($checkoutData['package_size']) ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Weight Range:</span>
                        <span class="summary-value">
                            <?php
                                $ranges = ['small' => '5-6 kg', 'medium' => '7-8 kg', 'large' => '9-10 kg'];
                                echo $ranges[$checkoutData['package_size']];
                            ?>
                        </span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Package Price:</span>
                        <span class="summary-value">
                            ₱<?= number_format($checkoutData['base_price'], 2) ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="middle-column">
            <div class="schedule-section">
                <div class="schedule-title">
                    Schedule Pickup
                </div>
                <div class="form-group">
                    <label for="pickupDate" class="form-label">Pickup Date</label>
                    <input type="date" id="pickupDate" class="form-input" required 
                           min="<?= date('Y-m-d') ?>" 
                           value="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label for="pickupTime" class="form-label">Pickup Time</label>
                    <input type="time" id="pickupTime" class="form-input" required
                           value="09:00">
                </div>
                <div class="important-note">
                    <strong>⚠️ Important:</strong>
                    Please drop off your laundry within 1 hour of booking, otherwise it will be cancelled automatically.
                </div>
            </div>
        </div>

        <div class="right-column">
            <div class="folded-option" id="foldedOption">
                <div class="folded-header">
                    <input type="checkbox" id="foldedCheckbox" class="folded-checkbox">
                    <label for="foldedCheckbox" class="folded-title">Add Folding Service</label>
                </div>
                <div class="folded-description">
                    Get your laundry neatly folded and organized
                </div>
                <div class="folded-price">+ ₱30.00</div>
            </div>

            <div class="order-summary">
                <div class="summary-row">
                    <span class="summary-label">Total:</span>
                    <span class="summary-value" id="totalPrice" style="color: #1f5f72; font-size: 1.3rem;">
                        ₱<?= number_format($checkoutData['base_price'], 2) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-actions">
        <button class="checkout-btn confirm-btn" id="confirmBtn">
            Confirm Order
        </button>
    </div>
</div>

<script>
    const foldedCheckbox = document.getElementById('foldedCheckbox');
    const foldedOption = document.getElementById('foldedOption');
    const totalPriceElement = document.getElementById('totalPrice');
    const basePrice = <?= $checkoutData['base_price'] ?>;
    const foldingPrice = 30;

    foldedCheckbox.addEventListener('change', function() {
        if (this.checked) {
            foldedOption.classList.add('selected');
            const newTotal = basePrice + foldingPrice;
            totalPriceElement.textContent = '₱' + newTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        } else {
            foldedOption.classList.remove('selected');
            totalPriceElement.textContent = '₱' + basePrice.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    });

    foldedOption.addEventListener('click', function(e) {
        if (e.target !== foldedCheckbox) {
            foldedCheckbox.checked = !foldedCheckbox.checked;
            foldedCheckbox.dispatchEvent(new Event('change'));
        }
    });

    document.getElementById('confirmBtn').addEventListener('click', function() {
        const folded = foldedCheckbox.checked ? 1 : 0;
        const totalPrice = foldedCheckbox.checked ? (basePrice + foldingPrice) : basePrice;
        const pickupDate = document.getElementById('pickupDate').value;
        const pickupTime = document.getElementById('pickupTime').value;

        if (!pickupDate || !pickupTime) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please select both pickup date and time.',
                confirmButtonColor: '#1f5f72'
            });
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= site_url('customer/confirm-order') ?>';

        const fields = {
            'service_type': '<?= $checkoutData['service_type'] ?>',
            'weight_kg': '<?= $checkoutData['weight_kg'] ?? '' ?>',
            'package_size': '<?= $checkoutData['package_size'] ?? '' ?>',
            'folded': folded,
            'price': totalPrice,
            'pickup_date': pickupDate,
            'pickup_time': pickupTime
        };

        for (const [key, value] of Object.entries(fields)) {
            if (value !== '') {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            }
        }

        document.body.appendChild(form);
        form.submit();
    });
</script>

