<?php
require 'config/db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6) {
        $error = "Enter your name, a valid email, and a password of at least 6 characters.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $error = "This email is already registered.";
        } else {
            $conn->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)")
                 ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT)]);
            header("Location: login.php?registered=1");
            exit;
        }
    }
}
include 'Layout/header.php';
?>
<div class="auth-box">
  <form method="post">
    <h2>Create Account</h2>
    <?php if ($error): ?><p class="auth-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <input type="text" name="name" placeholder="Full name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password (min 6 characters)" required>
    <button type="submit">Sign Up</button>
    <p>Already have an account? <a href="login.php">Log in</a></p>
  </form>
</div>
<?php include 'Layout/footer.php'; ?>