<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $productId   = $_POST['id'] ?? null;
    $productName = $_POST['name'] ?? '';
    $productPrice = (float)($_POST['price'] ?? 0);
    $productQty  = max(1, (int)($_POST['quantity'] ?? 1));
    $productImage = $_POST['image'] ?? '';

    if ($productId) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $productQty;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $productQty,
                'image' => $productImage
            ];
        }

        $cartCount = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cartCount += (int)($item['quantity'] ?? 1);
        }

        echo json_encode([
            'success' => true,
            'cartCount' => $cartCount
        ]);
        exit;
    }
}

echo json_encode([
    'success' => false,
    'message' => 'Invalid request'
]);
exit;



