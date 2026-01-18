<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <div style="margin-bottom: var(--space-8);">
            <h1 class="heading-section">Admin Dashboard</h1>
            <p class="body-text text-muted">Welcome to the admin panel. Manage users and shops below.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--space-6);">
            <!-- Users Card -->
            <div class="cta-card" style="text-align: center;">
                <div style="width: 64px; height: 64px; background: var(--secondary); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-4);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <p style="font-family: var(--font-serif); font-size: 2.5rem; font-weight: 500; color: var(--foreground); margin-bottom: var(--space-2);"><?= $userCount; ?></p>
                <p class="body-text text-muted" style="margin-bottom: var(--space-4);">Total Users</p>
                <a href="/admin/users" class="btn btn-primary">Manage Users</a>
            </div>

            <!-- Shops Card -->
            <div class="cta-card" style="text-align: center;">
                <div style="width: 64px; height: 64px; background: var(--secondary); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-4);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </div>
                <p style="font-family: var(--font-serif); font-size: 2.5rem; font-weight: 500; color: var(--foreground); margin-bottom: var(--space-2);"><?= $shopCount; ?></p>
                <p class="body-text text-muted" style="margin-bottom: var(--space-4);">Total Shops</p>
                <a href="/admin/shops" class="btn btn-primary">Manage Shops</a>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
