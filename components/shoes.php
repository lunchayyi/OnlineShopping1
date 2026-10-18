<?php

$shopByCategory = [
    [
        'id' => 41,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes9.jpg",
        'images' => [
            "images/shoes9.jpg",
            "images/shoes10.jpg",
            "images/shoes11.jpg",
            "images/shoes12.jpg",
            "images/shoes13.jpg"
        ]
    ],
    [
        'id' => 42,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes14.jpg",
        'images' => [
            "images/shoes14.jpg",
            "images/shoes15.jpg",
            "images/shoes16.jpg",
            "images/shoes13.jpg",
            "images/shoes18.jpg"
        ]
    ],
    [
        'id' => 43,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes23.jpg",
        'images' => [
            "images/shoes21.jpg",
            "images/shoes22.jpg",
            "images/shoes23.jpg",
            "images/shoes24.jpg",
            "images/shoes25.jpg"
        ]
    ],
    [
        'id' => 44,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes26.jpg",
        'images' => [
            "images/shoes26.jpg",
            "images/shoes27.jpg",
            "images/shoes28.jpg",
            "images/shoes26.jpg",
            "images/shoes27.jpg"
        ]
    ],
];

$newArrivals = [
    [
        'id' => 45,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes33.jpg",
        'images' => [
            "images/shoes30.jpg",
            "images/shoes33.jpg",
            "images/shoes31.jpg",
            "images/shoes32.jpg",
            "images/shoes33.jpg"
        ]
    ],
    [
        'id' => 46,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes34.jpg",
        'images' => [
            "images/shoes28.jpg",
            "images/shoes26.jpg",
            "images/shoes27.jpg",
            "images/shoes11.jpg",
            "images/shoes12.jpg"
        ]
    ],
    [
        'id' => 47,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes35.jpg",
        'images' => [
            "images/shoes9.jpg",
            "images/shoes8.jpg",
            "images/shoes13.jpg",
            "images/shoes14.jpg",
            "images/shoes17.jpg"
        ]
    ],
    [
        'id' => 48,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes36.jpg",
        'images' => [
            "images/shoes21.jpg",
            "images/shoes22.jpg",
            "images/shoes25.jpg",
            "images/shoes24.jpg",
            "images/shoes21.jpg"
        ]
    ],
];

$bestSellers = [
    [
        'id' => 49,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes37.jpg",
        'images' => [
            "images/shoes12.jpg",
            "images/shoes8.jpg",
            "images/shoes7.jpg",
            "images/shoes11.jpg",
            "images/shoes5.jpg"
        ]
    ],
    [
        'id' => 50,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes38.jpg",
        'images' => [
            "images/shoes38.jpg",
            "images/shoes12.jpg",
            "images/shoes13.jpg",
            "images/shoes14.jpg",
            "images/shoes15.jpg"
        ]
    ],
    [
        'id' => 51,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes39.jpg",
        'images' => [
            "images/shoes39.jpg",
            "images/shoes16.jpg",
            "images/shoes20.jpg",
            "images/shoes18.jpg",
            "images/shoes19.jpg"
        ]
    ],
    [
        'id' => 52,
        'price' => 30.95,
        'title' => "Baggy Denim & White Shirt Look",
        'image' => "images/shoes40.jpg",
        'images' => [
            "images/shoes40.jpg",
            "images/shoes20.jpg",
            "images/shoes21.jpg",
            "images/shoes22.jpg",
            "images/shoes23.jpg"
        ]
    ],
];

function renderSection($id, $title, $products = [])
{
    // ការពារ Error ប្រសិនបើ $products គ្មានទិន្នន័យ ឬ NULL
    $products = is_array($products) ? array_slice($products, 0, 4) : [];
    ?>
    <section id="<?php echo $id; ?>" class="section-container">
        <h2 class="section-title">
            <?php echo $title; ?> <span class="sparkle-icon">✨</span>
        </h2>

        <div class="slider-wrapper">
            <div class="slider-overflow">
                <div id="slider-track-<?php echo $id; ?>" class="slider-track">
                    <?php foreach ($products as $idx => $product): ?>
                        <?php $isFav = isset($_SESSION['wishlist'][$product['id']]) ? 'active' : ''; ?>
                        <div class="product-card-wrapper">
                            <div class="product-card">
                                <div class="product-image-container"
                                    onclick="viewProductDetail(<?php echo htmlspecialchars(json_encode($product)); ?>)">
                                    <img src="<?php echo $product['image']; ?>"
                                        alt="<?php echo htmlspecialchars($product['title']); ?>" class="product-image" />
                                </div>
                                <div class="product-details">
                                    <div class="product-header">
                                        <span class="product-price">US
                                            $<?php echo number_format($product['price'], 2); ?></span>
                                        <button class="wishlist-btn <?php echo $isFav; ?>"  onclick="toggleWishlist(this, <?php echo htmlspecialchars(json_encode([
                                            'id' => $product['id'] ?? '',
                                            'title' => $product['title'] ?? '',
                                            'price' => $product['price'] ?? 0,
                                            'image' => $product['image'] ?? ''
                                        ]), ENT_QUOTES, 'UTF-8'); ?>)" aria-label="Wishlist">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.8" class="heart-icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 8.25c0-2.485-2.099-4.575-4.688-4.575-1.688 0-3.153.86-4.012 2.149-.859-1.289-2.324-2.149-4.012-2.149C5.7 3.675 3.6 5.765 3.6 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                        </button>

                                    </div>
                                    <p class="product-title"
                                        onclick="viewProductDetail(<?php echo htmlspecialchars(json_encode($product)); ?>)">
                                        <?php echo htmlspecialchars($product['title']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>

<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details Page</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: inherit;
        }

        body {
            background-color: #ffffff;
            min-height: 100vh;
        }

        .catalog-container {
            width: 92%;
            max-width: 1400px;
            margin: 0 auto;
            padding-top: 110px;
            padding-bottom: 60px;
        }

        .section-container {
            margin-bottom: 40px;
        }

        .section-container:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 1.6rem;
            font-weight: 900;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sparkle-icon {
            font-size: 1.2rem;
        }

        .slider-track {
            display: flex;
            gap: 20px;
            width: 100%;
        }

        .product-card-wrapper {
            width: calc(25% - 15px);
            flex-shrink: 0;
        }

        .product-card {
            background: #f4f5f7;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-image-container {
            width: 100%;
            height: 480px;
            overflow: hidden;
            cursor: pointer;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.4s ease-in-out;
            will-change: transform;
        }

        .product-image-container:hover .product-image {
            transform: scale(1.05);
        }

        .product-details {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            background: #f4f5f7;
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-weight: 800;
            font-size: 1.05rem;
            color: #0d121c;
        }

        .product-title {
            cursor: pointer;
            font-weight: 500;
            font-size: 0.88rem;
            color: #4b5563;
            line-height: 1.3;
        }

        .wishlist-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8c96a6;
        }

        .heart-icon {
            width: 20px;
            height: 20px;
            transition: color 0.2s ease, fill 0.2s ease;
        }

        .wishlist-btn.active .heart-icon {
            color: #ef4444;
            fill: #ef4444;
        }

        #detailPage {
            display: none;
            width: 92%;
            max-width: 1200px;
            margin: 40px auto;
            padding-top: 10px;
        }

        #detailPage.active {
            display: grid !important;
            grid-template-columns: auto auto 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 850px) {
            #detailPage.active {
                grid-template-columns: 1fr;
            }

            .product-card-wrapper {
                width: calc(50% - 10px);
            }
        }

        .thumbnails-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .thumb-img {
            width: 75px;
            height: 90px;
            object-fit: cover;
            object-position: top;
            border-radius: 6px;
            cursor: pointer;
            border: 2px solid transparent;
            background-color: #f3f4f6;
            transition: all 0.2s ease;
        }

        .thumb-img.active {
            border-color: #000000;
        }

        .main-image-sec {
            background-color: #f9fafb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            width: 100%;
            max-width: 450px;
        }

        .main-image-sec img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            object-position: top;
            border-radius: 6px;
        }

        .product-info-sec {
            padding: 0 10px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .price-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .current-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ef4444;
        }

        .old-price {
            font-size: 1.1rem;
            color: #9ca3af;
            text-decoration: line-through;
        }

        .product-name-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
        }

        .option-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .option-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #4b5563;
        }

        .color-options {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .color-box {
            width: 28px;
            height: 28px;
            border-radius: 4px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .color-box:hover {
            transform: scale(1.15);
        }

        .color-box.active {
            border-color: #000000;
            transform: scale(1.1);
        }

        .size-options {
            display: flex;
            gap: 8px;
        }

        .size-btn {
            padding: 8px 16px;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .size-btn:hover {
            background-color: #e5e7eb;
        }

        .size-btn.active {
            background-color: #374151;
            color: #ffffff;
            border-color: #374151;
            font-weight: 600;
        }

        .qty-controls-row {
            display: flex;
            align-items: center;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            width: fit-content;
            overflow: hidden;
            background-color: #f9fafb;
        }

        .qty-btn-action {
            padding: 6px 16px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-weight: bold;
        }

        .qty-display-val {
            padding: 6px 16px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .btn-add-cart-full {
            width: 100%;
            background-color: #6B8A85;
            color: #ffffff;
            font-weight: 600;
            padding: 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            margin-top: 10px;
        }

        .btn-add-cart-full:hover {
            background-color: #41796f;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            background: none;
            border: none;
            color: #4b5563;
            font-weight: 600;
            cursor: pointer;
        }

        .wishlist-btn.active .heart-icon {
            fill: #ef4444;
            color: #ef4444;
        }
    </style>
</head>

<body>

    <?php if (file_exists('../Layout/Header.php'))
        include '../Layout/Header.php'; ?>

    <!-- Catalog Page Container (បង្ហាញត្រឹមតែ 3 Rows) -->
    <div id="catalogPage" class="catalog-container">
        <?php renderSection('women', 'Shop by Category', $shopByCategory); ?>
        <?php renderSection('man', 'New Arrivals', $newArrivals); ?>
        <?php renderSection('bags', 'Best Sellers', $bestSellers); ?>
    </div>

    <!-- Product Detail Page Layout -->
    <div id="detailPage" class="detail-view-container">
        <div>
            <button class="back-btn" onclick="backToCatalog()">← back</button>
            <div id="thumbnailsContainer" class="thumbnails-list"></div>
        </div>

        <div class="main-image-sec">
            <img id="detailMainImg" src="" alt="Product Detail">
        </div>

        <div class="product-info-sec">
            <div class="price-row">
                <span id="detailPrice" class="current-price"></span>
                <span class="old-price">$29.99</span>
            </div>

            <h2 id="detailTitle" class="product-name-title"></h2>

            <div class="option-group">
                <span class="option-label">Select Colors</span>
                <div class="color-options">
                    <div class="color-box" style="background-color: #000000;" onclick="selectColor(this)"></div>
                    <div class="color-box" style="background-color: #ef4444;" onclick="selectColor(this)"></div>
                    <div class="color-box" style="background-color: #6b7280;" onclick="selectColor(this)"></div>
                    <div class="color-box" style="background-color: #3b82f6;" onclick="selectColor(this)"></div>
                </div>
            </div>

            <div class="option-group">
                <span class="option-label">Size</span>
                <div class="size-options">
                    <button class="size-btn" onclick="selectSize(this)">S</button>
                    <button class="size-btn" onclick="selectSize(this)">M</button>
                    <button class="size-btn" onclick="selectSize(this)">L</button>
                    <button class="size-btn" onclick="selectSize(this)">XL</button>
                    <button class="size-btn" onclick="selectSize(this)">XXL</button>
                </div>
            </div>

            <div class="option-group">
                <span class="option-label">Quantity</span>
                <div class="qty-controls-row">
                    <button class="qty-btn-action" onclick="updateQty(-1)">-</button>
                    <span id="detailQty" class="qty-display-val">1</span>
                    <button class="qty-btn-action" onclick="updateQty(1)">+</button>
                </div>
            </div>

            <button class="btn-add-cart-full" onclick="addToCart()">Add To Cart</button>
        </div>
    </div>

        <script>

    let currentProduct = null;
    let qty = 1;
    let selectedColor = '';
    let selectedSize = '';
    let hiddenByDetail = [];
    let savedScrollY = 0;


    async function toggleWishlist(buttonElement, product) {
        if (!product || product.id == null || product.id === '') {
            console.error('Product ID is missing.');
            return;
        }

        const isActive = buttonElement.classList.contains('active');

        const formData = new FormData();
        formData.append('action', isActive ? 'remove' : 'add');
        formData.append('id', String(product.id));
        formData.append('name', product.title ?? '');
        formData.append('price', String(product.price ?? 0));
        formData.append('image', product.image ?? '');

        try {
            const response = await fetch('add-to-wishlist.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Wishlist update failed');
            }

            buttonElement.classList.toggle('active', data.action === 'add');

            const badge = document.getElementById('wishlistCountBadge');
            if (badge) {
                const count = Number(data.wishlistCount) || 0;
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }

        } catch (error) {
            console.error('Wishlist error:', error);
            alert('មានបញ្ហាក្នុងការបន្ថែម Favorite។ សូមពិនិត្យ add-to-wishlist.php។');
        }
    }


    // លាក់ header, banner, footer ពេលបើកទំព័រ detail
    function hideOutsideDetail() {
        hiddenByDetail = [];
        let node = document.getElementById('detailPage');

        while (node && node !== document.body) {
            const parent = node.parentElement;
            if (!parent) break;

            Array.from(parent.children).forEach(sib => {
                if (sib === node) return;
                if (['SCRIPT', 'STYLE', 'LINK'].includes(sib.tagName)) return;
                hiddenByDetail.push({ el: sib, display: sib.style.display });
                sib.style.display = 'none';
            });

            node = parent;
        }

        document.body.dataset.oldPadding = document.body.style.paddingTop;
        document.body.style.paddingTop = '0';
    }

    // បង្ហាញ header, banner, footer វិញ
    function showOutsideDetail() {
        hiddenByDetail.forEach(item => {
            item.el.style.display = item.display;
        });
        hiddenByDetail = [];
        document.body.style.paddingTop = document.body.dataset.oldPadding || '';
    }


    function viewProductDetail(product) {
        currentProduct = product;
        qty = 1;

        document.getElementById('detailMainImg').src = product.image;
        document.getElementById('detailTitle').innerText = product.title;
        document.getElementById('detailPrice').innerText = `US $${product.price.toFixed(2)}`;
        document.getElementById('detailQty').innerText = qty;

        const thumbsContainer = document.getElementById('thumbnailsContainer');
        thumbsContainer.innerHTML = '';

        let imageList = (product.images && Array.isArray(product.images) && product.images.length > 0)
            ? product.images
            : [product.image];

        imageList.forEach((imgSrc, index) => {
            const imgElem = document.createElement('img');
            imgElem.src = imgSrc;
            imgElem.className = `thumb-img ${index === 0 ? 'active' : ''}`;
            imgElem.onclick = function () {
                setMainImage(imgSrc, this);
            };
            thumbsContainer.appendChild(imgElem);
        });

        resetAndSelectDefaults();

        savedScrollY = window.scrollY;   // ចងចាំទីតាំង មុនលាក់ header

        hideOutsideDetail();
        document.getElementById('catalogPage').style.display = 'none';
        document.getElementById('detailPage').classList.add('active');
        window.scrollTo(0, 0);
    }

    function setMainImage(src, activeThumb) {
        document.getElementById('detailMainImg').src = src;

        document.querySelectorAll('.thumb-img').forEach(thumb => thumb.classList.remove('active'));
        if (activeThumb) activeThumb.classList.add('active');
    }

    function selectColor(element) {
        document.querySelectorAll('.color-box').forEach(box => box.classList.remove('active'));
        element.classList.add('active');
        selectedColor = element.style.backgroundColor;
    }

    function selectSize(element) {
        document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');
        selectedSize = element.innerText;
    }

    function resetAndSelectDefaults() {
        const firstColor = document.querySelector('.color-box');
        if (firstColor) selectColor(firstColor);

        const firstSize = document.querySelector('.size-btn');
        if (firstSize) selectSize(firstSize);
    }

    function backToCatalog() {
        showOutsideDetail();
        document.getElementById('detailPage').classList.remove('active');
        document.getElementById('catalogPage').style.display = 'block';

        // ត្រឡប់ទៅទីតាំងដែលបានចុច (row ដដែល)
        window.scrollTo(0, savedScrollY);
    }

    function updateQty(change) {
        qty = Math.max(1, qty + change);
        document.getElementById('detailQty').innerText = qty;

        if (currentProduct) {
            const totalPrice = currentProduct.price * qty;
            document.getElementById('detailPrice').innerText = `US $${totalPrice.toFixed(2)}`;
        }
    }

    function updateCartBadge(count) {
        const cartBtn = document.getElementById('cartBtn');
        if (!cartBtn) return;

        const cartContainer = cartBtn.parentElement;
        let badge = cartContainer.querySelector('.cart-badge');

        if (count <= 0) {
            if (badge) badge.remove();
            return;
        }

        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'cart-badge';
            cartContainer.appendChild(badge);
        }

        badge.textContent = count;
        badge.style.display = 'flex';
    }

    function addToCart() {
        if (!currentProduct) {
            alert('សូមជ្រើសរើស Product ជាមុនសិន។');
            return;
        }

        const formData = new FormData();
        formData.append('action', 'add_to_cart');
        formData.append('id', currentProduct.id);
        formData.append('name', currentProduct.title);
        formData.append('price', currentProduct.price);
        formData.append('image', currentProduct.image);
        formData.append('quantity', qty);
        formData.append('size', selectedSize);
        formData.append('color', selectedColor);

        fetch('add-to-cart.php', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server error: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error('Product was not added to cart.');
                }

                updateCartBadge(data.cartCount);

                alert(
                    `បានបន្ថែម ${currentProduct.title}\n` +
                    `Size: ${selectedSize}\n` +
                    `Color: ${selectedColor}\n` +
                    `ចំនួន: ${qty}\n\n` +
                    `បានបន្ថែមទៅក្នុង Cart!`
                );

                window.location.reload();
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                alert('មានបញ្ហាក្នុងការបន្ថែម Product ទៅ Cart។ សូមព្យាយាមម្ដងទៀត។');
            });
    }
</script>
</body>

</html>