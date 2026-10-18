<?php
require_once __DIR__ . '/../config/db.php';

$sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '' || $message === '') {
        $error = 'Please fill in every field with a valid email.';
    } else {
        $conn->prepare('INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)')
             ->execute([$name, $email, $subject, $message]);
        $sent = true;
    }
}
?>
<div class="info-page">
  <h1>Contact Us</h1>
  <p style="text-align:center;">Questions about an order or a product? We reply within 24 hours.</p>

  <div class="contact-wrap">
    <div class="auth-box">
      <form method="post" action="index.php?page=contact">
        <h2>Send a Message</h2>
        <?php if ($sent): ?><p class="auth-ok">Thank you! We received your message.</p><?php endif; ?>
        <?php if ($error): ?><p class="auth-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <input type="text" name="name" placeholder="Your name" required>
        <input type="email" name="email" placeholder="Your email" required>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" rows="5" placeholder="Your message" required></textarea>
        <button type="submit" name="send_message">Send</button>
      </form>
    </div>

    <div>
      <div class="info-card"><h3>Store Info</h3>
        <p>Address: Your street, Phnom Penh<br>
           Phone: +855 00 000 000<br>
           Email: hello@fashionstore.com</p>
      </div>
      <br>
      <div class="info-card"><h3>Opening Hours</h3>
        <p>Mon - Sat: 9:00 - 18:00<br>Sunday: 10:00 - 16:00</p>
      </div>
      <br>
      <div class="info-card"><h3>Follow Us</h3>
        <p>Facebook &middot; Instagram &middot; TikTok &middot; Telegram</p>
      </div>
    </div>
  </div>
</div>
