<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$totalPrice = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $qty = (int) ($item['quantity'] ?? 1);
        $price = (float) ($item['price'] ?? 0);
        $totalPrice += $price * $qty;
    }
}
?>
<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ទូទាត់ប្រាក់ - Checkout</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            padding: 40px 20px;
        }

        .checkout-wrapper {
            max-width: 1000px;
            margin: 0 auto;
        }

        .back-home {
            display: inline-block;
            margin-bottom: 20px;
            color: #618281;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .back-home:hover {
            text-decoration: underline;
        }

        .checkout-container {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 768px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
        }

        .checkout-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            box-sizing: border-box;
        }

        .checkout-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1e293b;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #334155;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            border-color: #618281;
            box-shadow: 0 0 0 3px rgba(97, 130, 129, 0.15);
        }

        textarea.form-control {
            resize: vertical;
            height: 90px;
        }

        .order-item-list {
            max-height: 250px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 5px;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .order-item img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border-radius: 8px;
            background: #f8fafc;
            flex-shrink: 0;
        }

        .order-item-info {
            flex: 1;
            min-width: 0;
        }

        .order-item-name {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .order-item-qty {
            font-size: 12px;
            color: #64748b;
        }

        .order-item-price {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: #64748b;
        }

        .summary-row.total {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            border-top: 1px dashed #cbd5e1;
            padding-top: 12px;
            margin-top: 12px;
        }

        .summary-row.total .value {
            color: #059669;
        }

        .btn-submit-order {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: #618281;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.2s ease;
            margin-top: 20px;
            box-sizing: border-box;
        }

        .btn-submit-order:hover {
            background-color: #4e6a69;
        }

        /* Success Popup Modal Styling */
        .success-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .success-box {
            background: #ffffff;
            padding: 35px 30px;
            border-radius: 20px;
            text-align: center;
            max-width: 380px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: scaleUp 0.3s ease-in-out;
        }

        @keyframes scaleUp {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .success-icon {
            width: 60px;
            height: 60px;
            background-color: #d1fae5;
            color: #059669;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 16px;
        }

        .success-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .success-desc {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<div class="checkout-wrapper">
    <a href="index.php" class="back-home">← ត្រឡប់ទៅទំព័រដើមវិញ</a>
    
    <div class="checkout-container">
       
        <div class="checkout-card">
            <h2 class="checkout-title">ព័ត៌មានដឹកជញ្ជូន (Shipping Details)</h2>
            <form id="checkout-form" onsubmit="handleCheckout(event)">
                <div class="form-group">
                    <label class="form-label">ឈ្មោះពេញ (Full Name)</label>
                    <input type="text" id="fullname" class="form-control" placeholder="បញ្ចូលឈ្មោះរបស់អ្នក" required>
                </div>

                <div class="form-group">
                    <label class="form-label">លេខទូរសព្ទ (Phone Number)</label>
                    <input type="tel" id="phone" class="form-control" placeholder="ឧ. 012 345 678" required>
                </div>

                <div class="form-group">
                    <label class="form-label">អាសយដ្ឋានដឹកជញ្ជូន (Delivery Address)</label>
                    <textarea id="address" class="form-control" placeholder="ផ្ទះលេខ, ផ្លូវ, សង្កាត់/ឃុំ, ខណ្ឌ/ស្រុក, រាជធានី/ខេត្ត" required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">កំណត់ចំណាំ (Optional Notes)</label>
                    <textarea id="notes" class="form-control" placeholder="ចំណាំបន្ថែមដល់អ្នកដឹកជញ្ជូន..."></textarea>
                </div>
            </form>
        </div>

       
        <div class="checkout-card">
            <h2 class="checkout-title">សេចក្តីសង្ខេបទំនិញ (Order Summary)</h2>
            
            <div class="order-item-list">
                <?php if (empty($_SESSION['cart'])): ?>
                    <p style="text-align: center; color: #94a3b8; font-size: 13px;">គ្មានទំនិញក្នុងកន្ត្រកទេ</p>
                <?php else: ?>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <?php 
                            $qty = (int)($item['quantity'] ?? 1);
                            $price = (float)($item['price'] ?? 0);
                            $rawImage = $item['image'] ?? '';
                            
                           
                            if (!empty($rawImage)) {
                                if (strpos($rawImage, 'http') === 0) {
                                    $itemImage = $rawImage;
                                } else {
                                    $itemImage = './' . ltrim($rawImage, '/');
                                }
                            } else {
                                $itemImage = '';
                            }
                        ?>
                        <div class="order-item">
                            <img src="<?php echo htmlspecialchars($itemImage, ENT_QUOTES, 'UTF-8'); ?>" alt="Product">
                            <div class="order-item-info">
                                <div class="order-item-name"><?php echo htmlspecialchars($item['name'] ?? 'Product', ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="order-item-qty">ចំនួន: <?php echo $qty; ?> × $<?php echo number_format($price, 2); ?></div>
                            </div>
                            <div class="order-item-price">$<?php echo number_format($price * $qty, 2); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="summary-row">
                <span>តម្លៃផលិតផលសរុប</span>
                <span>$<?php echo number_format($totalPrice, 2); ?></span>
            </div>
            <div class="summary-row">
                <span>សេវាដឹកជញ្ជូន</span>
                <span>ឥតគិតថ្លៃ (Free)</span>
            </div>
            <div class="summary-row total">
                <span>ទឹកប្រាក់ត្រូវបង់សរុប</span>
                <span class="value">$<?php echo number_format($totalPrice, 2); ?></span>
            </div>

            <button type="submit" form="checkout-form" class="btn-submit-order">
                បញ្ជាក់ការបញ្ជាទិញ (Confirm Order)
            </button>
        </div>
    </div>
</div>


<div class="success-modal" id="successModal">
    <div class="success-box">
        <div class="success-icon">✓</div>
        <div class="success-title">បញ្ជាទិញបានជោគជ័យ!</div>
        <div class="success-desc">អរគុណសម្រាប់ការបញ្ជាទិញទំនិញពីហាងយើងខ្ញុំ។ ហាងយើងខ្ញុំនឹងរៀបចំទំនិញជូនអ្នកប្រកបដោយទំនុកចិត្ត​ 🙏</div>
    </div>
</div>

<script>
    function handleCheckout(event) {
        event.preventDefault(); 

        const name = document.getElementById('fullname').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const address = document.getElementById('address').value.trim();

        if(!name || !phone || !address) {
            alert('សូមបំពេញព័ត៌មានដឹកជញ្ជូនឱ្យបានគ្រប់គ្រាន់!');
            return;
        }

        const modal = document.getElementById('successModal');
        if(modal) {
            modal.style.display = 'flex';
        }

     
        fetch('clear-cart.php', {
            method: 'POST'
        }).then(() => {
      
            setTimeout(() => {
                window.location.href = 'index.php'; // 
            }, 3000);
        });
    }
</script>

</body>
</html>



