<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['wishlist']) || !is_array($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// GET: ផ្ដល់ JavaScript សម្រាប់គ្រប់ទំព័រ
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/javascript; charset=utf-8');
    ?>
    async function toggleWishlist(buttonElement, product) {
        if (!product || product.id == null) return;

        // បើមានក្នុង wishlist រួច => remove, បើមិនទាន់ => add
        const isActive = buttonElement?.classList.contains('active');

        const formData = new FormData();
        formData.append('action', isActive ? 'remove' : 'add');
        formData.append('id', String(product.id));
        formData.append('category', product.category ?? '');
        formData.append('name', product.title ?? product.name ?? '');
        formData.append('price', product.price ?? 0);
        formData.append('image', product.image ?? '');

        try {
            const response = await fetch('add-to-wishlist.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Wishlist failed');
            }

            if (data.action === 'add') {
                buttonElement?.classList.add('active');
            } else {
                buttonElement?.classList.remove('active');
            }
            updateWishlistBadge(data.wishlistCount);

        } catch (error) {
            console.error('Wishlist error:', error);
            alert('មិនអាចបន្ថែម Favorite បានទេ។ សូមសាកល្បងម្ដងទៀត។');
        }
    }

    function updateWishlistBadge(count) {
        const badge = document.getElementById('wishlistCountBadge');
        if (!badge) return;

        const total = Number(count) || 0;
        badge.textContent = total;
        badge.style.display = total > 0 ? 'flex' : 'none';
    }
    <?php
    exit;
}

// POST
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$id       = trim((string)($_POST['id'] ?? ''));
$category = trim((string)($_POST['category'] ?? ''));
$action   = (string)($_POST['action'] ?? '');

if ($id === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Product ID is required']);
    exit;
}

// key មិនស្ទួន: category_id (ឧ. women_1, men_1)
$key = $category !== '' ? $category . '_' . $id : $id;

if ($action === 'add') {
    if (!isset($_SESSION['wishlist'][$key])) {
        $_SESSION['wishlist'][$key] = [
            'id'       => $id,
            'category' => $category,
            'name'     => (string)($_POST['name'] ?? ''),
            'price'    => (float)($_POST['price'] ?? 0),
            'image'    => (string)($_POST['image'] ?? ''),
            'quantity' => 1
        ];
    }
} elseif ($action === 'remove') {
    unset($_SESSION['wishlist'][$key]);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

echo json_encode([
    'success'       => true,
    'action'        => $action,
    'wishlistCount' => count($_SESSION['wishlist'])
]);
exit;

