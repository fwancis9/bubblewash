<style>
    .package-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        max-width: 100%;
    }

    .package-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        position: relative;
    }

    .package-machine-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 200px;
        height: 200px;
    }

    .package-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background-color: #5a8599;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        opacity: 0;
        flex-shrink: 0;
    }

    .package-option.active .package-circle {
        opacity: 1;
    }

    .package-machine-img {
        width: 140px;
        height: auto;
        position: relative;
        z-index: 1;
        opacity: 0.8;
        filter: grayscale(50%);
        transition: transform 0.1s ease, opacity 0s, filter 0s;
    }

    .package-option.active .package-machine-img {
        opacity: 1;
        filter: grayscale(0%);
    }

    .package-machine-img.bounce {
        transform: scale(0.95);
    }

    .package-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0;
    }

    .package-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f5f72;
        opacity: 0.8;
    }

    .package-option.active .package-title {
        opacity: 1;
    }

    .package-range {
        font-size: 1rem;
        font-weight: 400;
        color: #5a8599;
        opacity: 0.8;
    }

    .package-option.active .package-range {
        opacity: 1;
    }

    .package-price {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f5f72;
        margin-top: 0.5rem;
        opacity: 0.8;
    }

    .package-option.active .package-price {
        opacity: 1;
    }

    .bubble-now-btn {
        background-color: transparent;
        border: 2px solid #5a8599;
        color: #5a8599;
        padding: 0.5rem 2rem;
        border-radius: 2rem;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        margin-top: 1rem;
    }

    .package-option.active .bubble-now-btn {
        opacity: 1;
        visibility: visible;
    }

    .bubble-now-btn:hover {
        background-color: #5a8599;
        color: #fff;
    }

    @media (max-width: 768px) {
        .package-container {
            flex-direction: column;
            gap: 2rem;
        }

        .package-machine-img {
            width: 120px;
        }
    }
</style>

<div class="package-container">
    <div class="package-option active" data-package="small">
        <div class="package-machine-wrapper">
            <div class="package-circle"></div>
            <img src="<?= base_url('assets/images/washing_machine.png') ?>" alt="Small Package" class="package-machine-img">
        </div>
        <div class="package-info">
            <div class="package-title">Small</div>
            <div class="package-range">5-6 kg</div>
            <div class="package-price">₱275.00</div>
        </div>
        <button class="bubble-now-btn">BubbleNow</button>
    </div>

    <div class="package-option" data-package="medium">
        <div class="package-machine-wrapper">
            <div class="package-circle"></div>
            <img src="<?= base_url('assets/images/washing_machine.png') ?>" alt="Medium Package" class="package-machine-img">
        </div>
        <div class="package-info">
            <div class="package-title">Medium</div>
            <div class="package-range">7-8 kg</div>
            <div class="package-price">₱375.00</div>
        </div>
        <button class="bubble-now-btn">BubbleNow</button>
    </div>

    <div class="package-option" data-package="large">
        <div class="package-machine-wrapper">
            <div class="package-circle"></div>
            <img src="<?= base_url('assets/images/washing_machine.png') ?>" alt="Large Package" class="package-machine-img">
        </div>
        <div class="package-info">
            <div class="package-title">Large</div>
            <div class="package-range">9-10 kg</div>
            <div class="package-price">₱475.00</div>
        </div>
        <button class="bubble-now-btn">BubbleNow</button>
    </div>
</div>

<script>
    const packageOptions = document.querySelectorAll('.package-option');
    
    packageOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            if (e.target.classList.contains('bubble-now-btn')) {
                return;
            }
            
            packageOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            const washingMachine = this.querySelector('.package-machine-img');
            washingMachine.classList.add('bounce');
            setTimeout(() => {
                washingMachine.classList.remove('bounce');
            }, 100);
        });
    });

    document.querySelectorAll('.bubble-now-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const packageOption = this.closest('.package-option');
            const packageSize = packageOption.dataset.package;
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= site_url('customer/checkout') ?>';

            const serviceTypeInput = document.createElement('input');
            serviceTypeInput.type = 'hidden';
            serviceTypeInput.name = 'service_type';
            serviceTypeInput.value = 'package';
            form.appendChild(serviceTypeInput);

            const packageSizeInput = document.createElement('input');
            packageSizeInput.type = 'hidden';
            packageSizeInput.name = 'package_size';
            packageSizeInput.value = packageSize;
            form.appendChild(packageSizeInput);

            document.body.appendChild(form);
            form.submit();
        });
    });
</script>

