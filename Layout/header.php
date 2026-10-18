<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;
$totalPrice = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $qty = (int) ($item['quantity'] ?? 1);
        $price = (float) ($item['price'] ?? 0);

        $cartCount += $qty;
        $totalPrice += $price * $qty;
    }
}
?>

<!-- Import Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        padding-top: 115px;
    }

    /* Cart Backdrop / Blur Overlay */
    .cart-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        z-index: 9998;
    }

    .main-header {
        background-color: #618281;
        padding: 10px 40px 8px;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 9999;
        box-sizing: border-box;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1400px;
        margin: 0 auto;
        gap: 20px;
    }

    .logo-img {
        height: 100px;
        width: auto;
        object-fit: contain;
        display: block;
    }

    .top-nav,
    .sub-nav {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .top-nav {
        gap: 32px;
    }

    .top-nav a,
    .sub-nav a {
        color: #ffffff;
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .top-nav a:hover,
    .sub-nav a:hover {
        color: #cbd5e1;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 22px;
        margin-top: 6px;
    }

    .search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-wrapper input {
        width: 230px;
        padding: 8px 18px 8px 38px;
        border-radius: 20px;
        border: none;
        outline: none;
        font-size: 15px;
        background-color: #ffffff;
        color: #334155;
        box-sizing: border-box;
    }

    .search-wrapper input::placeholder {
        color: #94a3b8;
    }

    .search-wrapper svg {
        position: absolute;
        left: 12px;
        width: 18px;
        height: 18px;
        color: #64748b;
        pointer-events: none;
    }

    .action-icon-btn {
        background: transparent;
        border: none;
        color: #ffffff;
        cursor: pointer;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        border-radius: 50%;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .action-icon-btn:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: #f1f5f9;
    }

    .cart-count-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        background-color: #ef4444;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        border-radius: 50%;
        min-width: 18px;
        height: 18px;
        padding: 0 3px;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sub-nav-container {
        max-width: 1400px;
        margin: -2px auto 0;
        display: flex;
        justify-content: center;
    }

    .sub-nav {
        gap: 36px;
    }

    /* Cart Dropdown */
    .cart-dropdown-box {
        display: none;
        position: absolute;
        right: 0;
        top: 135%;
        width: 350px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        padding: 18px;
        z-index: 99999;
        color: #0f172a;
        box-sizing: border-box;
    }

    .cart-dropdown-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .cart-dropdown-title {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }

    .close-cart-btn {
        background: none;
        border: none;
        font-size: 20px;
        color: #94a3b8;
        cursor: pointer;
    }

    .cart-items-wrapper {
        max-height: 260px;
        overflow-y: auto;
    }

    .cart-dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .cart-dropdown-item img {
        width: 60px;
        height: 60px;
        flex-shrink: 0;
        border-radius: 8px;
        object-fit: contain;
        background-color: #f8fafc;
    }

    .cart-item-details {
        flex: 1;
        min-width: 0;
    }

    .cart-item-name {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 3px;
        overflow-wrap: anywhere;
        line-height: 1.5;
    }

    .cart-item-qty {
        font-size: 12px;
        color: #64748b;
    }

    /* Remove button */
    .remove-cart-item {
        display: inline-block;
        margin-top: 5px;
        padding: 0;
        background: transparent;
        border: none;
        color: #dc2626;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .remove-cart-item:hover {
        color: #991b1b;
        text-decoration: underline;
    }

    .cart-item-price-total {
        font-weight: 700;
        font-size: 13px;
        white-space: nowrap;
        align-self: center;
    }

    .cart-empty-message {
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
        padding: 15px 0;
    }

    .cart-total-section {
        border-top: 1px dashed #e2e8f0;
        padding-top: 10px;
        margin-top: 10px;
    }

    .cart-total-row {
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 15px;
    }

    .cart-total-value {
        color: #059669;
    }

    .btn-checkout-submit {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #618281;
        color: #ffffff;
        text-align: center;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        margin-top: 14px;
        box-sizing: border-box;
        transition: background-color 0.2s ease;
    }

    .btn-checkout-submit:hover {
        background-color: #4e6a69;
    }


    /* Account dropdown */
    .user-dropdown { position: relative; }
    .user-dropdown-content {
        display: none; position: absolute; right: 0; top: 100%;
        min-width: 170px; background: #fff; border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,.2); padding: 8px; z-index: 99999;
    }
    .user-dropdown:hover .user-dropdown-content { display: block; }
    .user-dropdown-content a, .user-hello {
        display: block; padding: 9px 12px; color: #0f172a;
        text-decoration: none; font-size: 14px; border-radius: 6px;
    }
    .user-hello { font-weight: 700; border-bottom: 1px solid #f1f5f9; }
    .user-dropdown-content a:hover { background: #f1f5f9; color: #0f172a; }

    /* Login / Register / About / Contact pages */
    .auth-box { max-width: 420px; margin: 40px auto; padding: 30px; background: #fff; border-radius: 14px; box-shadow: 0 4px 20px rgba(0,0,0,.1); }
    .auth-box h2 { text-align: center; margin: 0 0 20px; }
    .auth-box input, .auth-box textarea { width: 100%; padding: 12px; margin-bottom: 14px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-family: inherit; font-size: 15px; }
    .auth-box button { width: 100%; padding: 12px; background: #618281; color: #fff; border: 0; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: 600; }
    .auth-box button:hover { background: #4e6a69; }
    .auth-box p { text-align: center; margin-top: 14px; }
    .auth-error { color: #c0392b; background: #fdecea; padding: 10px; border-radius: 8px; }
    .auth-ok { color: #1e8449; background: #e9f7ef; padding: 10px; border-radius: 8px; }
    .info-page { max-width: 1000px; margin: 0 auto; line-height: 1.7; color: #1e293b; }
    .info-page h1 { text-align: center; }
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin: 24px 0; }
    .info-card { background: #f8fafc; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
    .info-card h3 { margin-top: 0; color: #618281; }
    .info-btn { display: inline-block; background: #618281; color: #fff; padding: 12px 26px; border-radius: 10px; text-decoration: none; font-weight: 600; }
    .contact-wrap { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; align-items: start; }
    .contact-wrap .auth-box { margin: 0; max-width: none; }

    /* Responsive */
    @media (max-width: 1000px) {
        .main-header {
            padding-left: 20px;
            padding-right: 20px;
        }

        .top-nav {
            gap: 15px;
        }

        .header-actions {
            gap: 12px;
        }

        .search-wrapper input {
            width: 180px;
        }
    }

    @media (max-width: 700px) {
        body {
            padding-top: 130px;
        }

        .header-top {
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .logo-img {
            height: 55px;
        }

        .top-nav {
            display: none;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
            gap: 14px;
            margin-top: 0;
        }

        .search-wrapper {
            flex: 1;
            max-width: 250px;
        }

        .search-wrapper input {
            width: 100%;
        }

        .sub-nav-container {
            margin-top: 12px;
            overflow-x: auto;
            justify-content: flex-start;
        }

        .sub-nav {
            gap: 22px;
            padding: 5px 0;
            white-space: nowrap;
        }

        .sub-nav a {
            font-size: 14px;
        }

        .cart-dropdown-box {
            position: fixed;
            top: 100px;
            right: 12px;
            width: 350px;
        }
    }
</style>

<!-- Backdrop Blur Element -->
<div class="cart-backdrop" id="cartBackdrop"></div>

<header class="main-header">
    <div class="header-top">

        <!-- Logo -->
        <a href="index.php">
            <img src="images/logo-fashion2.png" alt="Logo Fashion" class="logo-img">
        </a>

        <!-- Main Navigation -->
        <ul class="top-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?page=about">About</a></li>
            <li><a href="index.php?page=contact">Contact</a></li>
        </ul>

        <!-- Header Actions -->
        <div class="header-actions">

            <!-- Search -->
            <div class="search-wrapper">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search products...">
            </div>

            <!-- Account -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-dropdown">
                    <button class="action-icon-btn" type="button" title="Account">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                    </button>
                    <div class="user-dropdown-content">
                        <span class="user-hello">Hi, <?= htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') ?></span>
                        <a href="wishlist.php">My Wishlist</a>
                        <a href="logout.php">Log out</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="action-icon-btn" title="Log in / Sign up" style="text-decoration:none;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                </a>
            <?php endif; ?>

            <?php

            $wishlistCount = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
            ?>

            <!-- Wishlist -->

            <?php
              $wishlistCount = !empty($_SESSION['wishlist'])
    && is_array($_SESSION['wishlist'])
    ? count($_SESSION['wishlist'])
    : 0;
            ?>

            <!-- Wishlist -->
            <div style="position: relative;">
    <a href="wishlist.php"
       class="action-icon-btn"
       title="Wishlist"
       style="text-decoration:none; display:flex; align-items:center; justify-content:center;">

        <svg width="24" height="24" fill="none"
             stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>

        <span
            class="cart-count-badge"
            id="wishlistCountBadge"
            style="<?= $wishlistCount > 0 ? 'display:flex;' : 'display:none;' ?>"
        ><?= $wishlistCount ?></span>
    </a>
</div>

            <!-- Cart -->
            <div style="position: relative;">

                <button class="action-icon-btn" id="cartBtn" type="button" title="Cart" aria-label="Shopping cart">
                    <svg width="25" height="25" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>

                    <?php if ($cartCount > 0): ?>
                        <span class="cart-count-badge">
                            <?php echo $cartCount; ?>
                        </span>
                    <?php endif; ?>
                </button>

                <!-- Cart Dropdown -->
                <div class="cart-dropdown-box" id="cartDropdown">

                    <div class="cart-dropdown-header">
                        <h3 class="cart-dropdown-title">
                            កន្ត្រកទំនិញ
                        </h3>

                        <button class="close-cart-btn" id="closeCartBtn" type="button"
                            aria-label="Close cart">✕</button>
                    </div>

                    <div class="cart-items-wrapper">

                        <?php if (empty($_SESSION['cart'])): ?>

                            <p class="cart-empty-message">
                                គ្មានទំនិញក្នុងកន្ត្រកទេ
                            </p>

                        <?php else: ?>

                            <?php foreach ($_SESSION['cart'] as $item): ?>

                                <?php
                                $itemId = (string) ($item['id'] ?? '');
                                $itemQty = max(
                                    1,
                                    (int) ($item['quantity'] ?? 1)
                                );
                                $itemPrice = max(
                                    0,
                                    (float) ($item['price'] ?? 0)
                                );

                                $itemImage = $item['image'] ?? '';
                                ?>

                                <div class="cart-dropdown-item">

                                    <img src="<?php echo htmlspecialchars($itemImage, ENT_QUOTES, 'UTF-8'); ?>"
                                        alt="<?php echo htmlspecialchars($item['name'] ?? 'Product', ENT_QUOTES, 'UTF-8'); ?>">

                                    <div class="cart-item-details">

                                        <div class="cart-item-name">
                                            <?php
                                            echo htmlspecialchars(
                                                $item['name'] ?? 'Product',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                            ?>
                                        </div>

                                        <div class="cart-item-qty">
                                            $<?php echo number_format($itemPrice, 2); ?>
                                            × <?php echo $itemQty; ?>
                                        </div>

                                        <!-- Remove Product -->
                                        <button type="button" class="remove-cart-item" onclick="removeCartItem(<?php
                                        echo htmlspecialchars(
                                            json_encode($itemId),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                        ?>)">
                                            Remove
                                        </button>

                                    </div>

                                    <div class="cart-item-price-total">
                                        $<?php
                                        echo number_format(
                                            $itemPrice * $itemQty,
                                            2
                                        );
                                        ?>
                                    </div>

                                </div>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>

                    <?php if (!empty($_SESSION['cart'])): ?>

                        <div class="cart-total-section">

                            <div class="cart-total-row">
                                <span>Total:</span>

                                <span class="cart-total-value">
                                    $<?php echo number_format($totalPrice, 2); ?>
                                </span>
                            </div>

                            <a href="checkout.php" class="btn-checkout-submit">
                                ទូទាត់ប្រាក់ (Checkout)
                            </a>

                        </div>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

    <!-- Sub Navigation -->
    <div class="sub-nav-container">
        <ul class="sub-nav">
            <li><a href="index.php?page=women">Women</a></li>
            <li><a href="index.php?page=men">Men</a></li>
            <li><a href="index.php?page=bags">Bags</a></li>
            <li><a href="index.php?page=shoes">Shoes</a></li>
            <li><a href="index.php?page=caps">Caps</a></li>
        </ul>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cartBtn = document.getElementById('cartBtn');
        const closeCartBtn = document.getElementById('closeCartBtn');
        const cartDropdown = document.getElementById('cartDropdown');
        const cartBackdrop = document.getElementById('cartBackdrop');

        function openCart() {
            if (cartDropdown) cartDropdown.style.display = 'block';
            if (cartBackdrop) cartBackdrop.style.display = 'block';
        }

        function closeCart() {
            if (cartDropdown) cartDropdown.style.display = 'none';
            if (cartBackdrop) cartBackdrop.style.display = 'none';
        }

        // Open and close Cart
        if (cartBtn && cartDropdown) {
            cartBtn.addEventListener('click', (event) => {
                event.stopPropagation();
                const isOpen = cartDropdown.style.display === 'block';
                if (isOpen) {
                    closeCart();
                } else {
                    openCart();
                }
            });
        }

        if (closeCartBtn) {
            closeCartBtn.addEventListener('click', (event) => {
                event.stopPropagation();
                closeCart();
            });
        }

        if (cartBackdrop) {
            cartBackdrop.addEventListener('click', () => {
                closeCart();
            });
        }

        // Close when clicking outside
        document.addEventListener('click', (event) => {
            if (
                cartDropdown &&
                cartBtn &&
                !cartDropdown.contains(event.target) &&
                !cartBtn.contains(event.target)
            ) {
                closeCart();
            }
        });

        // Reopen Cart after removing a product
        if (sessionStorage.getItem('openCartAfterRemove') === '1') {
            sessionStorage.removeItem('openCartAfterRemove');
            openCart();
        }
    });

    // Remove one product from Cart
    async function removeCartItem(productId) {
        if (!confirm('Are you sure you want to delete it?')) {
            return;
        }

        const formData = new FormData();
        formData.append('id', productId);

        try {
            const response = await fetch('./remove-from-cart.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(
                    data.message || 'មិនអាចលុប Product បានទេ។'
                );
            }

            // Refresh cart data from PHP session
            sessionStorage.setItem('openCartAfterRemove', '1');
            window.location.reload();

        } catch (error) {
            console.error('Remove Cart Error:', error);

            alert(
                error.message ||
                'មានបញ្ហាក្នុងការលុប Product។ សូមព្យាយាមម្ដងទៀត។'
            );
        }
    }
</script>

<script src="wishlist.js" defer></script>


