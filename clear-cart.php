<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


unset($_SESSION['cart']);


echo json_encode(['status' => 'success']);
exit();
?>


