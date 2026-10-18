<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,500;1,6..96,500&display=swap" rel="stylesheet">

<style>
    .ab {
        --teal: #618281;
        --teal-deep: #2f4645;
        --mist: #eef3f2;
        --ink: #17211f;
        --muted: #55645f;
        --line: #d5dfdd;
        max-width: 1200px;
        margin: 0 auto;
        color: var(--ink);
        font-family: 'Inter', system-ui, sans-serif;
        line-height: 1.65;
    }

    .ab * { box-sizing: border-box; }
    .ab h1, .ab h2 { font-family: 'Bodoni Moda', Georgia, serif; font-weight: 500; line-height: 1.1; margin: 0; }
    .ab p { margin: 0; }
    .ab a { color: inherit; }
    .ab a:focus-visible { outline: 3px solid var(--teal); outline-offset: 3px; }

    /* ---------- Hero ---------- */
    .ab-hero {
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        gap: 64px;
        align-items: center;
        padding: 36px 0 72px;
    }

    .ab-hero h1 {
        font-size: clamp(2.4rem, 5vw, 4rem);
        font-style: italic;
        letter-spacing: -0.01em;
        color: var(--teal-deep);
    }

    .ab-hero p {
        margin-top: 24px;
        max-width: 46ch;
        font-size: 1.08rem;
        color: var(--muted);
    }

    .ab-hero-actions { margin-top: 32px; display: flex; gap: 14px; flex-wrap: wrap; }

    .ab-btn {
        display: inline-block;
        padding: 14px 30px;
        border-radius: 999px;
        background: var(--teal);
        color: #fff !important;
        font-weight: 600;
        text-decoration: none;
        transition: background .2s ease;
    }
    .ab-btn:hover { background: var(--teal-deep); }

    .ab-btn.ghost {
        background: transparent;
        color: var(--teal-deep) !important;
        box-shadow: inset 0 0 0 2px var(--teal);
    }
    .ab-btn.ghost:hover { background: var(--mist); }

    .ab-collage { position: relative; height: 560px; }

    .ab-collage .arch {
        position: absolute;
        right: 0; top: 0;
        width: 68%; height: 100%;
        border-radius: 999px 999px 8px 8px;
        object-fit: cover;
        object-position: top;
        background: var(--mist);
    }

    .ab-collage .inset {
        position: absolute;
        left: 0; bottom: 36px;
        width: 42%; height: 46%;
        border-radius: 8px;
        object-fit: cover;
        object-position: top;
        background: var(--mist);
        border: 8px solid #fff;
    }

    /* ---------- Shop tiles ---------- */
    .ab-section { padding: 72px 0; border-top: 1px solid var(--line); }
    .ab-section > h2 { font-size: clamp(1.8rem, 3vw, 2.4rem); color: var(--teal-deep); margin-bottom: 36px; }

    .ab-tiles { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; }

    .ab-tile {
        position: relative;
        display: block;
        aspect-ratio: 3 / 4;
        overflow: hidden;
        border-radius: 10px;
        background: var(--mist);
        text-decoration: none;
    }
    .ab-tile img {
        width: 100%; height: 100%;
        object-fit: cover; object-position: top;
        display: block;
        transition: transform .5s ease;
    }
    .ab-tile:hover img { transform: scale(1.06); }
    .ab-tile::after {
        content: "";
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(23,33,31,.72), rgba(23,33,31,0) 55%);
    }
    .ab-tile span {
        position: absolute; left: 16px; bottom: 14px; z-index: 1;
        color: #fff; font-weight: 600; font-size: 1.05rem;
    }

    /* ---------- Story ---------- */
    .ab-story { display: grid; grid-template-columns: 1fr 1.4fr; gap: 64px; }
    .ab-story > h2 { margin-bottom: 0; }
    .ab-story .text p + p { margin-top: 18px; }
    .ab-story .text { color: var(--muted); font-size: 1.05rem; max-width: 62ch; }

    /* ---------- Promises ---------- */
    .ab-promises { display: grid; grid-template-columns: repeat(4, 1fr); gap: 36px; }
    .ab-promises div { border-top: 3px solid var(--teal); padding-top: 18px; }
    .ab-promises h3 { margin: 0 0 8px; font-size: 1.1rem; color: var(--teal-deep); }
    .ab-promises p { color: var(--muted); font-size: .97rem; }

    /* ---------- Delivery & payment ---------- */
    .ab-info { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; }
    .ab-info h3 { margin: 0 0 10px; font-size: 1.2rem; color: var(--teal-deep); }
    .ab-info p { color: var(--muted); max-width: 52ch; }
    .ab-info p + p { margin-top: 10px; }

    /* ---------- Closing band ---------- */
    .ab-band {
        margin: 24px 0 40px;
        padding: 56px 40px;
        border-radius: 18px;
        background: var(--teal);
        color: #fff;
        text-align: center;
    }
    .ab-band h2 { font-size: clamp(1.8rem, 3vw, 2.6rem); font-style: italic; }
    .ab-band p { margin: 14px auto 28px; max-width: 48ch; opacity: .92; }
    .ab-band .ab-btn { background: #fff; color: var(--teal-deep) !important; }
    .ab-band .ab-btn:hover { background: var(--mist); }

    /* ---------- Responsive ---------- */
    @media (max-width: 960px) {
        .ab-hero, .ab-story, .ab-info { grid-template-columns: 1fr; gap: 40px; }
        .ab-collage { height: 440px; max-width: 520px; }
        .ab-tiles { grid-template-columns: repeat(3, 1fr); }
        .ab-promises { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 560px) {
        .ab-tiles { grid-template-columns: repeat(2, 1fr); }
        .ab-promises { grid-template-columns: 1fr; }
        .ab-collage { height: 380px; }
        .ab-band { padding: 40px 22px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ab-tile img, .ab-btn { transition: none; }
    }
</style>

<div class="ab">

    <!-- Hero -->
    <section class="ab-hero">
        <div>
            <h1>Clothes, bags, shoes and caps you will want to wear again.</h1>
            <p>
                Fashion Store is a Phnom Penh fashion shop for people who like looking put together
                without paying luxury prices. Every piece is picked to feel good, fit well and last.
            </p>
            <div class="ab-hero-actions">
                <a class="ab-btn" href="index.php">Shop new arrivals</a>
                <a class="ab-btn ghost" href="index.php?page=contact">Contact us</a>
            </div>
        </div>

        <div class="ab-collage">
            <img class="arch" src="images/cloth_girl_2.jpg" alt="Baggy denim and white shirt look">
            <img class="inset" src="images/bag_1.jpg" alt="Chic buckle shoulder bag">
        </div>
    </section>

    <!-- Shop tiles -->
    <section class="ab-section">
        <h2>What we sell</h2>
        <div class="ab-tiles">
            <a class="ab-tile" href="index.php?page=women">
                <img src="images/cloth11.jpg" alt=""><span>Women</span>
            </a>
            <a class="ab-tile" href="index.php?page=men">
                <img src="images/men2.jpg" alt=""><span>Men</span>
            </a>
            <a class="ab-tile" href="index.php?page=bags">
                <img src="images/bag_2.jpg" alt=""><span>Bags</span>
            </a>
            <a class="ab-tile" href="index.php?page=shoes">
                <img src="images/shoes13.jpg" alt=""><span>Shoes</span>
            </a>
            <a class="ab-tile" href="index.php?page=caps">
                <img src="images/cap1.jpg" alt=""><span>Caps</span>
            </a>
        </div>
    </section>

    <!-- Story -->
    <section class="ab-section ab-story">
        <h2>Our story</h2>
        <div class="text">
            <p>
                Fashion Store began with a simple frustration: good-looking clothes were either too
                expensive or fell apart after a few washes. We set out to build a shop where you can
                get both style and quality.
            </p>
            <p>
                Today we sell for women and men, plus bags, shoes and caps to finish the outfit.
               
            </p>
        </div>
    </section>

    <!-- Promises -->
    <section class="ab-section">
        <h2>What you can count on</h2>
        <div class="ab-promises">
            <div>
                <h3>Quality you can feel</h3>
                <p>We check fabric, stitching and finishing before anything goes on the shelf.</p>
            </div>
            <div>
                <h3>Fair prices</h3>
                <p>Honest pricing on every item, with no luxury mark-up.</p>
            </div>
            <div>
                <h3>Fast delivery</h3>
                <p>Orders are packed quickly and delivered across Cambodia.</p>
            </div>
            <div>
                <h3>Easy exchanges</h3>
                <p>Wrong size? Exchange it within 7 days.</p>
            </div>
        </div>
    </section>

    <!-- Delivery & payment -->
    <section class="ab-section">
        <h2>Delivery and payment</h2>
        <div class="ab-info">
            <div>
                <h3>Delivery</h3>
                <p>Orders in Phnom Penh usually arrive in 1 to 2 days. Provinces take 2 to 4 days.</p>
               
            </div>
            <div>
                <h3>Payment</h3>
                <p>Pay with cash on delivery, ABA or Wing.</p>
               
            </div>
        </div>
    </section>

    <!-- Closing band -->
    <section class="ab-band">
        <h2>Find your next favourite outfit</h2>
        <p>New styles arrive often. Browse the latest and save the ones you like to your wishlist.</p>
        <a class="ab-btn" href="index.php">Start shopping</a>
    </section>

</div>