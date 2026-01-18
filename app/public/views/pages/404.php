<?php require(__DIR__ . "/../partials/header.php"); ?>

<main class="main" style="padding: var(--space-16) 0; min-height: calc(100vh - 200px); display: flex; align-items: center;">
    <div class="container">
        <div style="max-width: 480px; margin: 0 auto; text-align: center;">
            <div style="font-family: var(--font-serif); font-size: 8rem; font-weight: 700; line-height: 1; color: var(--foreground); margin-bottom: var(--space-4);">404</div>
            <h1 class="heading-section" style="margin-bottom: var(--space-4);">Page Not Found</h1>
            <p class="body-text text-muted" style="margin-bottom: var(--space-8);">
                The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
            </p>
            <div style="display: flex; justify-content: center; gap: var(--space-3); flex-wrap: wrap;">
                <a href="/" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    Go to Homepage
                </a>
                <a href="/products" class="btn btn-outline">Browse Products</a>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../partials/footer.php"); ?>
