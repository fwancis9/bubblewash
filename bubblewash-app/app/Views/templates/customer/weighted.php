<style>
    .weighted-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 100%;
    }

    .washing-machine-side {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .washing-machine-img {
        width: clamp(150px, 20vw, 220px);
        height: auto;
        transition: transform 0.1s ease;
    }

    .washing-machine-img.bounce {
        transform: scale(0.95);
    }

    .controls-side {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .kilograms-label {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f5f72;
        margin-bottom: 0;
    }

    .kg-controls {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .kg-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #5a8599;
        border: none;
        color: #fff;
        font-size: 2rem;
        font-weight: 600;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.1s ease;
        padding: 0;
    }

    .kg-btn:hover {
        background-color: #4a7080;
        transform: scale(1.05);
    }

    .kg-btn:active {
        transform: scale(0.95);
    }

    .kg-display {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background-color: #5a8599;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        font-weight: 700;
        color: #fff;
    }

    .price-display {
        font-size: 2rem;
        font-weight: 700;
        color: #1f5f72;
        margin-top: 0.5rem;
    }

    .price-per-kg {
        font-size: 1rem;
        font-weight: 400;
        color: #5a8599;
        margin-top: 0.25rem;
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
        transition: all 0.2s ease;
        margin-top: 0;
    }

    .bubble-now-btn:hover {
        background-color: #5a8599;
        color: #fff;
    }

    @media (max-width: 768px) {
        .weighted-container {
            flex-direction: column;
            gap: 2rem;
        }

        .washing-machine-img {
            width: 200px;
        }
    }
</style>

<div class="weighted-container">
    <div class="washing-machine-side">
        <img src="<?= base_url('assets/images/washing_machine.png') ?>" alt="Washing Machine" class="washing-machine-img">
    </div>
    
    <div class="controls-side">
        <div class="kilograms-label">Kilograms</div>
        <div class="kg-controls">
            <button class="kg-btn" id="decreaseKg">-</button>
            <div class="kg-display" id="kgDisplay">1</div>
            <button class="kg-btn" id="increaseKg">+</button>
        </div>
        <div class="price-display" id="priceDisplay">₱50.00</div>
        <button class="bubble-now-btn">BubbleNow</button>
    </div>
</div>

<script>
    let kilograms = 1;
    const minKg = 1;
    const maxKg = 10;

    const display = document.getElementById('kgDisplay');
    const priceDisplay = document.getElementById('priceDisplay');
    const decreaseBtn = document.getElementById('decreaseKg');
    const increaseBtn = document.getElementById('increaseKg');
    const washingMachine = document.querySelector('.washing-machine-img');
    const pricePerKg = 50;

    function updateDisplay() {
        display.textContent = kilograms;
        const totalPrice = kilograms * pricePerKg;
        priceDisplay.textContent = '₱' + totalPrice.toFixed(2);
    }

    function bounceWashingMachine() {
        washingMachine.classList.add('bounce');
        setTimeout(() => {
            washingMachine.classList.remove('bounce');
        }, 100);
    }

    decreaseBtn.addEventListener('click', function() {
        if (kilograms > minKg) {
            kilograms--;
            updateDisplay();
            bounceWashingMachine();
        }
    });

    increaseBtn.addEventListener('click', function() {
        if (kilograms < maxKg) {
            kilograms++;
            updateDisplay();
            bounceWashingMachine();
        }
    });

    document.querySelector('.bubble-now-btn').addEventListener('click', function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= site_url('customer/checkout') ?>';

        const serviceTypeInput = document.createElement('input');
        serviceTypeInput.type = 'hidden';
        serviceTypeInput.name = 'service_type';
        serviceTypeInput.value = 'weighted';
        form.appendChild(serviceTypeInput);

        const weightInput = document.createElement('input');
        weightInput.type = 'hidden';
        weightInput.name = 'weight_kg';
        weightInput.value = kilograms;
        form.appendChild(weightInput);

        document.body.appendChild(form);
        form.submit();
    });
</script>

