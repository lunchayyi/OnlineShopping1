<?php
$year = date("Y");

// ---- Edit these two lists to match your shop ----
$socialLinks = [
    ['name' => 'Facebook',  'icon' => 'fa-facebook-f', 'class' => 'facebook-icon',  'url' => '#'],
    ['name' => 'Instagram', 'icon' => 'fa-instagram',  'class' => 'instagram-icon', 'url' => '#'],
    ['name' => 'TikTok',    'icon' => 'fa-tiktok',     'class' => 'tiktok-icon',    'url' => '#'],
    ['name' => 'Telegram',  'icon' => 'fa-telegram',   'class' => 'telegram-icon',  'url' => '#'],
];
$paymentMethods = ['Cash on delivery', 'ABA', 'Wing'];

// ---- Newsletter form ----
$newsletterMsg = '';
$newsletterOk  = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_submit'])) {
    $nEmail = trim($_POST['newsletter_email'] ?? '');
    if (!filter_var($nEmail, FILTER_VALIDATE_EMAIL)) {
        $newsletterMsg = 'Enter a valid email address.';
    } else {
        try {
            require_once __DIR__ . '/../config/db.php';
            $conn->prepare('INSERT IGNORE INTO subscribers (email) VALUES (?)')->execute([$nEmail]);
            $newsletterOk  = true;
            $newsletterMsg = 'Thank you for subscribing!';
        } catch (Throwable $e) {
            $newsletterMsg = 'We could not subscribe you right now. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Width Footer</title>
    <!-- Font Awesome សម្រាប់ Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        /* ---------------- FULL WIDTH FOOTER SECTION ---------------- */
        .footer {
            background-color: #63827d;
            color: #ffffff;
            padding: 50px 0 20px 0;
            width: 100%;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .footer-top {
            display: grid;
            grid-template-columns: repeat(3, 1fr) 1.5fr;
            gap: 40px;
            padding-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: #ffffff;
        }

        /* Newsletter & Button Animation */
        .newsletter p {
            color: #e0e0e0;
            font-size: 13px;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .subscribe-form {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }

        .subscribe-form input[type="email"] {
            background-color: rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 12px;
            border-radius: 4px;
            color: #fff;
            outline: none;
            flex: 1;
        }

        .subscribe-form input[type="email"]::placeholder {
            color: #ccc;
        }

        .subscribe-btn {
            background-color: #ffffff;
            color: #000000;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s;
        }

        .subscribe-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            background-color: #f0f0f0;
        }

        .subscribe-btn:active {
            transform: translateY(-1px);
        }

        .privacy-text {
            font-size: 11px !important;
            color: #ccc !important;
        }

        .privacy-text a {
            color: #fff;
            text-decoration: underline;
        }

        /* ---------------- SOCIAL ICONS ANIMATION ---------------- */
        .footer-middle {
            border-top: 1px solid rgba(255,255,255,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .social-icons {
            display: flex;
            gap: 18px;
        }

        .social-icons a {
            color: #ffffff;
            font-size: 20px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        /* ចលនារង្គើរឡើងលើសម្រាប់ Social Icons ទាំង ៤ */
        .social-icons a:hover {
            animation: bounceShake 0.5s ease infinite alternate;
        }

        .social-icons a.facebook-icon:hover { color: #1877f2; }
        .social-icons a.instagram-icon:hover { color: #e1306c; }
        .social-icons a.twitter-icon:hover { color: #1da1f2; }
        .social-icons a.pinterest-icon:hover { color: #bd081c; }

        @keyframes bounceShake {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-6px) rotate(-8deg); /* រុញឡើងលើ និងរង្គើរ */
            }
            100% {
                transform: translateY(-6px) rotate(8deg);
            }
        }

        /* ---------------- PAYMENT METHODS ---------------- */
        .payment-methods {
            display: flex;
            gap: 8px;
        }

        .payment-card {
            background-color: #ffffff;
            color: #000000;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 28px;
        }

        /* កែប្រែកន្លែង Mastercard ឱ្យមានរូបរង្វង់ពណ៌ក្រហម និងលឿង */
        .mastercard-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            width: 24px;
            height: 16px;
        }

        .mastercard-circle {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: inline-block;
        }

        .circle-red {
            background-color: #eb001b;
        }

        .circle-yellow {
            background-color: #f79e1b;
            margin-left: -7px;
            opacity: 0.9;
        }

        .footer-bottom {
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #dddddd;
        }

        .social-icons a.tiktok-icon:hover { color: #25f4ee; }
        .social-icons a.telegram-icon:hover { color: #2aabee; }

        .payment-methods { flex-wrap: wrap; justify-content: flex-end; }

        .newsletter-msg {
            font-size: 13px;
            margin-bottom: 10px;
            padding: 8px 12px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.2);
        }
        .newsletter-msg.error { background: rgba(0, 0, 0, 0.25); }

        @media (max-width: 768px) {
            .footer-top {
                grid-template-columns: 1fr 1fr;
            }
            .footer-middle {
                flex-direction: column;
                gap: 20px;
            }
            .payment-methods { justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- FULL WIDTH FOOTER -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-column">
                    <h3>About</h3>
                    <ul>
                        <li><a href="index.php?page=about">About Us</a></li>
                        <li><a href="index.php?page=contact">Contact Us</a></li>
                        <li><a href="index.php?page=help#shipping">Shipping and Delivery</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Shop</h3>
                    <ul>
                        <li><a href="index.php?page=women">Women</a></li>
                        <li><a href="index.php?page=men">Men</a></li>
                        <li><a href="index.php?page=bags">Bags</a></li>
                        <li><a href="index.php?page=shoes">Shoes</a></li>
                        <li><a href="index.php?page=caps">Caps</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Help</h3>
                    <ul>
                        <li><a href="index.php?page=help#faq">FAQs</a></li>
                        <li><a href="index.php?page=help#shipping">Shipping and Returns</a></li>
                        <li><a href="index.php?page=help#privacy">Privacy Policy</a></li>
                        <li><a href="index.php?page=help#terms">Terms and Conditions</a></li>
                    </ul>
                </div>

                <div class="footer-column newsletter" id="newsletter">
                    <h3>Newsletter</h3>
                    <p>Get news about new arrivals and special offers in your inbox.</p>
                    <?php if ($newsletterMsg): ?>
                        <p class="newsletter-msg <?= $newsletterOk ? '' : 'error' ?>" role="status">
                            <?= htmlspecialchars($newsletterMsg) ?>
                        </p>
                    <?php endif; ?>
                    <form action="#newsletter" method="POST" class="subscribe-form">
                        <input type="email" name="newsletter_email" placeholder="Email" required>
                        <button type="submit" name="newsletter_submit" class="subscribe-btn">Subscribe</button>
                    </form>
                    <p class="privacy-text">
                        By subscribing you agree to our <a href="index.php?page=help#privacy">Privacy Policy</a>.
                    </p>
                </div>
            </div>

            <div class="footer-middle">
                <div class="social-icons">
                    <?php foreach ($socialLinks as $s): ?>
                        <a href="<?= htmlspecialchars($s['url']) ?>"
                           class="<?= htmlspecialchars($s['class']) ?>"
                           aria-label="<?= htmlspecialchars($s['name']) ?>"
                           <?= $s['url'] !== '#' ? 'target="_blank" rel="noopener"' : '' ?>>
                            <i class="fab <?= htmlspecialchars($s['icon']) ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="payment-methods">
                    <?php foreach ($paymentMethods as $method): ?>
                        <span class="payment-card"><?= htmlspecialchars($method) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?= $year ?> Fashion Store. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>


