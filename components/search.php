<?php
/*
 * Search page: looks through every product listed in your category files
 * (women.php, men.php, bags.php, shoes.php, caps.php) and the home page (product.php).
 * It reads the product arrays at the top of each file, so when you add or edit a
 * product there, search picks it up automatically.
 */

$searchQuery = trim($_GET['q'] ?? '');

// Which files hold products, and which words mean each category
$searchSources = [
    'women' => ['label' => 'Women', 'file' => 'women.php', 'words' => ['women', 'woman', 'womens', 'ladies', 'girl', 'girls', 'female']],
    'men'   => ['label' => 'Men',   'file' => 'men.php',   'words' => ['men', 'man', 'mens', 'boy', 'boys', 'male']],
    'bags'  => ['label' => 'Bags',  'file' => 'bags.php',  'words' => ['bags', 'bag', 'handbag', 'handbags', 'purse', 'purses']],
    'shoes' => ['label' => 'Shoes', 'file' => 'shoes.php', 'words' => ['shoes', 'shoe', 'sneaker', 'sneakers', 'sandals', 'footwear']],
    'caps'  => ['label' => 'Caps',  'file' => 'caps.php',  'words' => ['caps', 'cap', 'hat', 'hats', 'accessories', 'accessory']],
];

// On the home page (product.php) each list belongs to a category and a section anchor
$homeLists = [
    'shopByCategory' => ['women', 'women'],
    'newArrivals'    => ['men', 'man'],
    'bestSellers'    => ['bags', 'bags'],
    'trendingNow'    => ['shoes', 'shoes'],
    'specialOffers'  => ['caps', 'accessories'],
];

/** Read the product arrays at the top of a component file. */
function searchLoadProducts(string $path): array
{
    $src = @file_get_contents($path);
    if ($src === false) {
        return [];
    }
    $start = strpos($src, '<?php');
    $end   = strpos($src, 'function renderSection');
    if ($start === false || $end === false || $end < $start) {
        return [];
    }

    $code = substr($src, $start + 5, $end - $start - 5);
    try {
        eval($code);
    } catch (Throwable $e) {
        return [];
    }

    $lists = [];
    foreach (get_defined_vars() as $name => $value) {
        if (is_array($value) && isset($value[0]) && is_array($value[0]) && isset($value[0]['title'])) {
            $lists[$name] = $value;
        }
    }
    return $lists;
}

// ---------- Collect all products ----------
$allProducts = [];
$seenImages  = [];

$addProduct = function (array $p, string $category, string $link) use (&$allProducts, &$seenImages, $searchSources) {
    $image = $p['image'] ?? '';
    $key   = $image !== '' ? $image : ($p['title'] ?? '') . ($p['id'] ?? '');
    if (isset($seenImages[$key])) {
        return;
    }
    $seenImages[$key] = true;
    $allProducts[] = [
        'title'    => trim((string) ($p['title'] ?? 'Product')),
        'price'    => (float) ($p['price'] ?? 0),
        'image'    => $image,
        'category' => $category,
        'label'    => $searchSources[$category]['label'],
        'link'     => $link,
    ];
};

foreach ($searchSources as $cat => $info) {
    foreach (searchLoadProducts(__DIR__ . '/' . $info['file']) as $list) {
        foreach ($list as $p) {
            $addProduct($p, $cat, 'index.php?page=' . $cat);
        }
    }
}
foreach (searchLoadProducts(__DIR__ . '/product.php') as $listName => $list) {
    if (!isset($homeLists[$listName])) {
        continue;
    }
    [$cat, $anchor] = $homeLists[$listName];
    foreach ($list as $p) {
        $addProduct($p, $cat, 'index.php#' . $anchor);
    }
}

// ---------- Match the query ----------
$results = [];
if ($searchQuery !== '') {
    preg_match_all('/[\p{L}\p{N}]+/u', mb_strtolower($searchQuery), $m);
    $words = $m[0];

    foreach ($allProducts as $product) {
        $categoryWords = $searchSources[$product['category']]['words'];
        $matchesAll = true;

        foreach ($words as $w) {
            if (in_array($w, $categoryWords, true)) {
                continue;
            }
            $stem = (mb_strlen($w) > 3) ? preg_replace('/(es|s)$/u', '', $w) : $w;
            if (!preg_match('/\b' . preg_quote($stem, '/') . '/iu', $product['title'])) {
                $matchesAll = false;
                break;
            }
        }
        if ($matchesAll && $words) {
            $results[] = $product;
        }
    }
}
$resultCount = count($results);
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,500;1,6..96,500&display=swap" rel="stylesheet">

<style>
    .sr {
        --teal: #618281;
        --teal-deep: #2f4645;
        --mist: #eef3f2;
        --ink: #17211f;
        --muted: #55645f;
        --line: #d5dfdd;
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px 0 60px;
        color: var(--ink);
        font-family: 'Inter', system-ui, sans-serif;
    }
    .sr a:focus-visible { outline: 3px solid var(--teal); outline-offset: 3px; }

    .sr-head { padding-bottom: 24px; border-bottom: 1px solid var(--line); margin-bottom: 36px; }
    .sr-head h1 {
        margin: 0;
        font-family: 'Bodoni Moda', Georgia, serif;
        font-style: italic; font-weight: 500;
        font-size: clamp(2rem, 4vw, 3rem);
        line-height: 1.15;
        color: var(--teal-deep);
        overflow-wrap: anywhere;
    }
    .sr-head p { margin: 10px 0 0; color: var(--muted); }

    .sr-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px 22px; }

    .sr-card { display: block; text-decoration: none; color: inherit; }
    .sr-photo {
        aspect-ratio: 3 / 4;
        overflow: hidden;
        border-radius: 12px;
        background: var(--mist);
    }
    .sr-photo img {
        width: 100%; height: 100%;
        object-fit: cover; object-position: top;
        display: block;
        transition: transform .5s ease;
    }
    .sr-card:hover .sr-photo img { transform: scale(1.05); }
    .sr-info { padding: 14px 2px 0; }
    .sr-cat { margin: 0 0 4px; font-size: .85rem; font-weight: 600; color: var(--teal); }
    .sr-name { margin: 0; font-weight: 600; font-size: .98rem; line-height: 1.35; }
    .sr-price { margin: 4px 0 0; color: var(--teal-deep); font-weight: 700; font-size: 1.05rem; }

    .sr-empty { max-width: 560px; margin: 30px auto; text-align: center; }
    .sr-empty h2 {
        margin: 0 0 10px;
        font-family: 'Bodoni Moda', Georgia, serif;
        font-style: italic; font-weight: 500;
        font-size: clamp(1.7rem, 3vw, 2.3rem);
        color: var(--teal-deep);
    }
    .sr-empty p { margin: 0 0 24px; color: var(--muted); line-height: 1.6; }
    .sr-pills { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
    .sr-pills a {
        padding: 10px 22px; border-radius: 999px; text-decoration: none; font-weight: 600;
        background: var(--mist); color: var(--teal-deep); transition: background .2s ease, color .2s ease;
    }
    .sr-pills a:hover { background: var(--teal); color: #fff; }

    @media (max-width: 1000px) { .sr-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 720px)  { .sr-grid { grid-template-columns: repeat(2, 1fr); gap: 22px 14px; } }
    @media (prefers-reduced-motion: reduce) { .sr-photo img { transition: none; } }
</style>

<div class="sr">

    <?php if ($searchQuery === ''): ?>

        <div class="sr-head">
            <h1>Search</h1>
            <p>Type a product or a category in the search box above.</p>
        </div>

    <?php else: ?>

        <div class="sr-head">
            <h1>Results for &ldquo;<?= htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8') ?>&rdquo;</h1>
            <p>
                <?php if ($resultCount > 0): ?>
                    <?= $resultCount ?> <?= $resultCount === 1 ? 'product' : 'products' ?> found
                <?php else: ?>
                    No products found
                <?php endif; ?>
            </p>
        </div>

    <?php endif; ?>

    <?php if ($resultCount > 0): ?>

        <div class="sr-grid">
            <?php foreach ($results as $r): ?>
                <a class="sr-card" href="<?= htmlspecialchars($r['link'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="sr-photo">
                        <?php if ($r['image'] !== ''): ?>
                            <img src="<?= htmlspecialchars($r['image'], ENT_QUOTES, 'UTF-8') ?>"
                                 alt="<?= htmlspecialchars($r['title'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                        <?php endif; ?>
                    </div>
                    <div class="sr-info">
                        <p class="sr-cat"><?= htmlspecialchars($r['label']) ?></p>
                        <p class="sr-name"><?= htmlspecialchars($r['title'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="sr-price">US $<?= number_format($r['price'], 2) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    <?php else: ?>

        <div class="sr-empty">
            <?php if ($searchQuery !== ''): ?>
                <h2>We could not find that</h2>
                <p>Check the spelling, or try a simpler word such as &ldquo;bag&rdquo;, &ldquo;sneakers&rdquo; or &ldquo;jacket&rdquo;. You can also browse a category.</p>
            <?php else: ?>
                <h2>What are you looking for?</h2>
                <p>Try a word like &ldquo;bag&rdquo; or &ldquo;sneakers&rdquo;, or browse a category.</p>
            <?php endif; ?>
            <div class="sr-pills">
                <a href="index.php?page=women">Women</a>
                <a href="index.php?page=men">Men</a>
                <a href="index.php?page=bags">Bags</a>
                <a href="index.php?page=shoes">Shoes</a>
                <a href="index.php?page=caps">Caps</a>
            </div>
        </div>

    <?php endif; ?>

</div>
