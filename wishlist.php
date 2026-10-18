<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$wishlist = (isset($_SESSION['wishlist']) && is_array($_SESSION['wishlist'])) ? $_SESSION['wishlist'] : [];
$count = count($wishlist);

include 'Layout/header.php';
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,500;1,6..96,500&display=swap" rel="stylesheet">

<style>
    .wl {
        --teal: #618281;
        --teal-deep: #2f4645;
        --mist: #eef3f2;
        --ink: #17211f;
        --muted: #55645f;
        --line: #d5dfdd;
        --heart: #e0455f;
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px 0 60px;
        color: var(--ink);
        font-family: 'Inter', system-ui, sans-serif;
    }

    .wl a:focus-visible, .wl button:focus-visible { outline: 3px solid var(--teal); outline-offset: 3px; }

    .wl-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--line);
        margin-bottom: 36px;
    }

    .wl-head h1 {
        margin: 0;
        font-family: 'Bodoni Moda', Georgia, serif;
        font-style: italic;
        font-weight: 500;
        font-size: clamp(2.2rem, 4.5vw, 3.2rem);
        line-height: 1.1;
        color: var(--teal-deep);
    }

    .wl-head p { margin: 8px 0 0; color: var(--muted); }

    .wl-link {
        color: var(--teal-deep);
        font-weight: 600;
        text-decoration: none;
        padding: 10px 22px;
        border-radius: 999px;
        box-shadow: inset 0 0 0 2px var(--teal);
        transition: background .2s ease;
    }
    .wl-link:hover { background: var(--mist); }

    /* ---------- Product grid ---------- */
    .wl-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 28px 22px;
    }

    .wl-item { display: flex; flex-direction: column; transition: opacity .3s ease, transform .3s ease; }
    .wl-item.removing { opacity: 0; transform: scale(.96); }

    .wl-photo {
        position: relative;
        aspect-ratio: 3 / 4;
        overflow: hidden;
        border-radius: 12px;
        background: var(--mist);
    }
    .wl-photo img {
        width: 100%; height: 100%;
        object-fit: cover; object-position: top;
        display: block;
        transition: transform .5s ease;
    }
    .wl-item:hover .wl-photo img { transform: scale(1.04); }

    .wl-remove {
        position: absolute; top: 12px; right: 12px;
        width: 40px; height: 40px;
        border: 0; border-radius: 50%;
        background: rgba(255,255,255,.95);
        color: var(--heart);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: transform .2s ease, background .2s ease;
    }
    .wl-remove:hover { transform: scale(1.1); background: #fff; }
    .wl-remove svg { width: 20px; height: 20px; fill: currentColor; }

    .wl-info { padding: 14px 2px 12px; }
    .wl-name { margin: 0; font-weight: 600; font-size: .98rem; line-height: 1.35; color: var(--ink); }
    .wl-price { margin: 4px 0 0; color: var(--teal-deep); font-weight: 700; font-size: 1.05rem; }

    .wl-cart {
        margin-top: auto;
        width: 100%;
        padding: 12px;
        border: 0;
        border-radius: 999px;
        background: var(--teal);
        color: #fff;
        font: 600 .95rem 'Inter', system-ui, sans-serif;
        cursor: pointer;
        transition: background .2s ease;
    }
    .wl-cart:hover { background: var(--teal-deep); }
    .wl-cart:disabled { opacity: .6; cursor: wait; }

    /* ---------- Empty state ---------- */
    .wl-empty { max-width: 560px; margin: 40px auto 20px; text-align: center; }
    .wl-empty svg { width: 84px; height: 84px; stroke: var(--teal); fill: none; stroke-width: 1.4; }
    .wl-empty h2 {
        margin: 20px 0 10px;
        font-family: 'Bodoni Moda', Georgia, serif;
        font-style: italic; font-weight: 500;
        font-size: clamp(1.8rem, 3.5vw, 2.4rem);
        color: var(--teal-deep);
    }
    .wl-empty p { margin: 0 0 26px; color: var(--muted); line-height: 1.6; }
    .wl-pills { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
    .wl-pills a {
        padding: 10px 22px; border-radius: 999px; text-decoration: none; font-weight: 600;
        background: var(--mist); color: var(--teal-deep); transition: background .2s ease, color .2s ease;
    }
    .wl-pills a:hover { background: var(--teal); color: #fff; }

    /* ---------- Message ---------- */
    .wl-toast {
        position: fixed; left: 50%; bottom: 28px; transform: translate(-50%, 20px);
        background: var(--teal-deep); color: #fff;
        padding: 12px 22px; border-radius: 999px; font-weight: 600; font-size: .95rem;
        opacity: 0; pointer-events: none; transition: opacity .25s ease, transform .25s ease;
        z-index: 100000;
    }
    .wl-toast.show { opacity: 1; transform: translate(-50%, 0); }

    @media (max-width: 1000px) { .wl-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 720px)  { .wl-grid { grid-template-columns: repeat(2, 1fr); gap: 22px 14px; } }
    @media (prefers-reduced-motion: reduce) {
        .wl-item, .wl-photo img, .wl-remove, .wl-toast { transition: none; }
    }
</style>

<main style="padding: 10px 40px 40px; min-height: 80vh;">
<div class="wl">

    <div class="wl-head">
        <div>
            <h1>Your wishlist</h1>
            <p id="wlCount">
                <?php if ($count > 0): ?>
                    <?= $count ?> saved <?= $count === 1 ? 'item' : 'items' ?>
                <?php else: ?>
                    Nothing saved yet
                <?php endif; ?>
            </p>
        </div>
        <a class="wl-link" href="index.php">Continue shopping</a>
    </div>

    <?php if ($count === 0): ?>

        <div class="wl-empty">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.575-4.688-4.575-1.688 0-3.153.86-4.012 2.149-.859-1.289-2.324-2.149-4.012-2.149C5.7 3.675 3.6 5.765 3.6 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
            <h2>Your wishlist is empty</h2>
            <p>Tap the heart on any product to save it here, and come back when you are ready to buy.</p>
            <div class="wl-pills">
                <a href="index.php?page=women">Women</a>
                <a href="index.php?page=men">Men</a>
                <a href="index.php?page=bags">Bags</a>
                <a href="index.php?page=shoes">Shoes</a>
                <a href="index.php?page=caps">Caps</a>
            </div>
        </div>

    <?php else: ?>

        <div class="wl-grid">
            <?php foreach ($wishlist as $key => $item): ?>
                <?php
                $id    = (string) ($item['id'] ?? $key);
                $name  = $item['name'] ?? ($item['title'] ?? 'Product');
                $price = (float) ($item['price'] ?? 0);
                $image = $item['image'] ?? '';
                ?>
                <article class="wl-item"
                         data-id="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>"
                         data-name="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
                         data-price="<?= htmlspecialchars((string) $price, ENT_QUOTES, 'UTF-8') ?>"
                         data-image="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>">

                    <div class="wl-photo">
                        <?php if ($image !== ''): ?>
                            <img src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>"
                                 alt="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
                        <?php endif; ?>
                        <button type="button" class="wl-remove" data-action="remove"
                                aria-label="Remove <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?> from wishlist">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M21 8.25c0-2.485-2.099-4.575-4.688-4.575-1.688 0-3.153.86-4.012 2.149-.859-1.289-2.324-2.149-4.012-2.149C5.7 3.675 3.6 5.765 3.6 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </button>
                    </div>

                    <div class="wl-info">
                        <p class="wl-name"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="wl-price">US $<?= number_format($price, 2) ?></p>
                    </div>

                    <button type="button" class="wl-cart" data-action="cart">Add to cart</button>
                </article>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>
</main>

<div class="wl-toast" id="wlToast" role="status" aria-live="polite"></div>

<script>
    (function () {
        const toast = document.getElementById('wlToast');
        let toastTimer;

        function showToast(text) {
            toast.textContent = text;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2600);
        }

        function updateBadge(count) {
            const badge = document.getElementById('wishlistCountBadge');
            if (!badge) return;
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }

        async function removeItem(card) {
            const form = new FormData();
            form.append('action', 'remove');
            form.append('id', card.dataset.id);

            try {
                const res = await fetch('add-to-wishlist.php', { method: 'POST', body: form });
                const data = await res.json();
                if (!res.ok || !data.success) throw new Error(data.message || 'Could not remove item');

                const left = Number(data.wishlistCount) || 0;
                updateBadge(left);
                card.classList.add('removing');

                setTimeout(() => {
                    if (left === 0) {
                        window.location.reload();
                        return;
                    }
                    card.remove();
                    document.getElementById('wlCount').textContent =
                        left + ' saved ' + (left === 1 ? 'item' : 'items');
                }, 300);
            } catch (err) {
                console.error(err);
                showToast('Could not remove this item. Please try again.');
            }
        }

        async function addToCart(card, button) {
            const form = new FormData();
            form.append('action', 'add_to_cart');
            form.append('id', card.dataset.id);
            form.append('name', card.dataset.name);
            form.append('price', card.dataset.price);
            form.append('image', card.dataset.image);
            form.append('quantity', 1);
            form.append('size', '');
            form.append('color', '');

            button.disabled = true;
            button.textContent = 'Adding...';

            try {
                const res = await fetch('add-to-cart.php', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: form
                });
                const data = await res.json();
                if (!res.ok || !data.success) throw new Error('Not added');

                // Reload so the header cart shows the new item, and open it
                sessionStorage.setItem('openCartAfterRemove', '1');
                window.location.reload();
            } catch (err) {
                console.error(err);
                button.disabled = false;
                button.textContent = 'Add to cart';
                showToast('Could not add to cart. Please try again.');
            }
        }

        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;
            const card = btn.closest('.wl-item');
            if (!card) return;

            if (btn.dataset.action === 'remove') removeItem(card);
            if (btn.dataset.action === 'cart') addToCart(card, btn);
        });
    })();
</script>

<?php include 'Layout/footer.php'; ?>