<?php
// ១. ទាញយកឈ្មោះ Category ពី URL (បើគ្មាន ដាក់ Default ជា 'women')
$category = isset($_GET['cat']) ? $_GET['cat'] : 'women';


$cartCount = 3; 
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$headerBgColor = '#6B8A85';
?>

<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($category); ?> - Clothes Store</title>
    <!-- ដាក់ CSS របស់អ្នកនៅទីនេះ -->
    <style>
        .icon-btn { background: none; border: none; cursor: pointer; padding: 10px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease-in-out; outline: none; }
        .icon-btn:hover { background-color: rgba(255, 255, 255, 0.15); transform: scale(1.1); }
        .nav-link:hover, .category-link:hover { opacity: 0.8; transform: translateY(-1px); }
        .cart-badge { position: absolute; top: -4px; right: -4px; background-color: #ef4444; color: #ffffff; font-size: 12px; font-weight: bold; min-width: 20px; height: 20px; padding: 0 4px; border-radius: 9999px; display: flex; align-items: center; justify-content: center; border: 2px solid #6B8A85; box-sizing: border-box; }
    </style>
</head>
<body style="margin: 0; padding-top: 130px; font-family: system-ui, -apple-system, sans-serif;">

   
    <?php include 'header.php';  ?>

    <!-- ផ្នែក Content នៃទំព័រថ្មី -->
    <main style="padding: 40px; text-align: center;">
        <h1 style="color: #333; text-transform: uppercase;">
            ប្រភេទផលិតផល៖ <?php echo htmlspecialchars($category); ?>
        </h1>
    
        <p>កំពុងបង្ហាញផលិតផលសម្រាប់ប្រភេទ <strong><?php echo htmlspecialchars($category); ?></strong>...</p>
    </main>

</body>
</html>



