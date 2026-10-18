<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,500;1,6..96,500&display=swap" rel="stylesheet">

<style>
    .hp {
        --teal: #618281;
        --teal-deep: #2f4645;
        --mist: #eef3f2;
        --ink: #17211f;
        --muted: #55645f;
        --line: #d5dfdd;
        max-width: 860px;
        margin: 0 auto;
        padding: 20px 0 60px;
        color: var(--ink);
        font-family: 'Inter', system-ui, sans-serif;
        line-height: 1.7;
    }
    .hp h1, .hp h2 { font-family: 'Bodoni Moda', Georgia, serif; font-weight: 500; line-height: 1.15; margin: 0; color: var(--teal-deep); }
    .hp h1 { font-size: clamp(2.2rem, 4.5vw, 3.2rem); font-style: italic; }
    .hp h2 { font-size: clamp(1.6rem, 3vw, 2rem); margin-bottom: 20px; }
    .hp h3 { margin: 26px 0 6px; font-size: 1.05rem; color: var(--teal-deep); }
    .hp p { margin: 0 0 12px; color: var(--muted); }
    .hp a { color: var(--teal-deep); }
    .hp a:focus-visible, .hp summary:focus-visible { outline: 3px solid var(--teal); outline-offset: 3px; }

    .hp-intro { margin-top: 14px; font-size: 1.05rem; max-width: 60ch; }
    .hp-jump { display: flex; flex-wrap: wrap; gap: 10px; margin: 26px 0 8px; }
    .hp-jump a {
        padding: 8px 18px; border-radius: 999px; text-decoration: none; font-weight: 600; font-size: .92rem;
        box-shadow: inset 0 0 0 2px var(--teal); color: var(--teal-deep);
    }
    .hp-jump a:hover { background: var(--mist); }

    .hp section { padding: 48px 0 0; margin-top: 48px; border-top: 1px solid var(--line); scroll-margin-top: 140px; }

    .hp details { border-bottom: 1px solid var(--line); padding: 16px 0; }
    .hp details:first-of-type { border-top: 1px solid var(--line); }
    .hp summary { cursor: pointer; font-weight: 600; color: var(--ink); list-style: none; display: flex; justify-content: space-between; gap: 16px; }
    .hp summary::-webkit-details-marker { display: none; }
    .hp summary::after { content: "+"; font-size: 1.4rem; line-height: 1; color: var(--teal); }
    .hp details[open] summary::after { content: "\2212"; }
    .hp details p { margin: 12px 0 0; }
</style>

<div class="hp">
    <h1>Help</h1>
    <p class="hp-intro">Answers about ordering, delivery and exchanges, plus how we look after your information.</p>

    <nav class="hp-jump" aria-label="Help topics">
        <a href="#faq">FAQs</a>
        <a href="#shipping">Shipping and returns</a>
        <a href="#privacy">Privacy policy</a>
        <a href="#terms">Terms and conditions</a>
    </nav>

    <!-- FAQs -->
    <section id="faq">
        <h2>FAQs</h2>
        <details>
            <summary>How long does delivery take?</summary>
            <p>Orders in Phnom Penh usually arrive in 1 to 2 days. Provinces take 2 to 4 days.</p>
        </details>
        <details>
            <summary>How can I pay?</summary>
            <p>You can pay with cash on delivery, ABA or Wing.</p>
        </details>
        <details>
            <summary>Do I need an account to order?</summary>
            <p>Yes. Create a free account to check out. It also lets you save items to your wishlist.</p>
        </details>
        <details>
            <summary>Can I exchange an item?</summary>
            <p>Yes. You can exchange an item within 7 days if it is unworn and has its tags. See Shipping and returns below.</p>
        </details>
        <details>
            <summary>How do I choose my size?</summary>
            <p>Pick your size on the product page. If you are unsure, send us a message on the <a href="index.php?page=contact">Contact page</a> and we will help.</p>
        </details>
    </section>

    <!-- Shipping & returns -->
    <section id="shipping">
        <h2>Shipping and returns</h2>

        <h3>Delivery times</h3>
        <p>Phnom Penh: 1 to 2 days. Provinces: 2 to 4 days. We pack orders as soon as they are confirmed.</p>

        <h3>Delivery fees</h3>
        <p>Delivery fees depend on your location. Edit this text with your real prices, for example the fee inside Phnom Penh and the free-delivery amount.</p>

        <h3>Exchanges</h3>
        <p>Wrong size or a problem with your item? Contact us within 7 days of receiving it. Items must be unworn, unwashed and have their tags.</p>

        <h3>Damaged or wrong items</h3>
        <p>If your order arrives damaged or is not what you ordered, send us a photo through the <a href="index.php?page=contact">Contact page</a> and we will make it right.</p>
    </section>

    <!-- Privacy -->
    <section id="privacy">
        <h2>Privacy policy</h2>

        <h3>What we collect</h3>
        <p>When you create an account, send us a message or join the newsletter, we collect your name and email address. Your cart and wishlist are saved while you browse.</p>

        <h3>How we use it</h3>
        <p>We use your details to run your account, process your orders, reply to your messages and, if you subscribed, send news about new arrivals and offers.</p>

        <h3>How we protect it</h3>
        <p>Passwords are stored in a scrambled form that we cannot read. We do not sell your information.</p>

        <h3>Your choices</h3>
        <p>You can ask us to update or delete your information, or unsubscribe from the newsletter, at any time through the <a href="index.php?page=contact">Contact page</a>.</p>
    </section>

    <!-- Terms -->
    <section id="terms">
        <h2>Terms and conditions</h2>

        <h3>Prices and availability</h3>
        <p>Prices are shown in US dollars. Items are subject to availability, and we may cancel an order if an item is out of stock. In that case you will not be charged.</p>

        <h3>Orders and payment</h3>
        <p>An order is confirmed once we contact you or accept your payment. You are responsible for giving us a correct delivery address and phone number.</p>

        <h3>Your account</h3>
        <p>Keep your password private. You are responsible for activity on your account.</p>

        <h3>Changes</h3>
        <p>We may update these terms from time to time. The version on this page is the one that applies.</p>
    </section>
</div>
