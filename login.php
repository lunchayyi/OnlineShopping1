<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([trim($_POST['email'] ?? '')]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'] ?? '', $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        // Go back to the page the visitor wanted (only same-site paths are allowed)
        $go = $_SESSION['redirect_after_login'] ?? 'index.php';
        unset($_SESSION['redirect_after_login']);
        if (!preg_match('#^(?!//)[A-Za-z0-9_./?=&%-]+$#', $go)) {
            $go = 'index.php';
        }
        header('Location: ' . $go);
        exit;
    }
    $error = 'Wrong email or password.';
}
include 'Layout/header.php';
?>
<main style="padding: 10px 40px 40px; min-height: 80vh;">
  <div class="auth-box">
    <form method="post">
      <h2>Log In</h2>
      <?php if (isset($_GET['registered'])): ?><p class="auth-ok">Account created! Please log in.</p><?php endif; ?>
      <?php if (isset($_GET['need_login'])): ?><p class="auth-error">Please log in first.</p><?php endif; ?>
      <?php if ($error): ?><p class="auth-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Log In</button>
      <p>New here? <a href="register.php">Create an account</a></p>
    </form>
  </div>
</main>
<?php include 'Layout/footer.php'; ?>