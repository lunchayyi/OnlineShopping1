
<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
    exit;
}

$id = $_POST['id'] ?? '';

if ($id === '' || !isset($_SESSION['cart'][$id])) {
    echo json_encode([
        'success' => false,
        'message' => 'Product not found in cart'
    ]);
    exit;
}


unset($_SESSION['cart'][$id]);

// Recalculate cart quantity
$cartCount = 0;

foreach ($_SESSION['cart'] ?? [] as $item) {
    $cartCount += (int) ($item['quantity'] ?? 0);
}

// Calculate total price
$total = 0;

foreach ($_SESSION['cart'] ?? [] as $item) {
    $total += (float) $item['price']
            * (int) $item['quantity'];
}

echo json_encode([
    'success' => true,
    'cartCount' => $cartCount,
    'total' => number_format($total, 2, '.', ''),
    'cart' => array_values($_SESSION['cart'] ?? [])
]);
exit;



