<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="main" style="padding: var(--space-8) 0 var(--space-16);">
    <div class="container">
        <nav style="margin-bottom: var(--space-6);">
            <a href="/" style="color: var(--muted-foreground); font-size: 0.875rem; display: flex; align-items: center; gap: var(--space-2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Back to Home
            </a>
        </nav>

        <div style="margin-bottom: var(--space-8);">
            <h1 class="heading-section">My Profile</h1>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: var(--space-6);">
            <!-- Profile Information Card -->
            <div class="cta-card">
                <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500; margin-bottom: var(--space-4); display: flex; align-items: center; gap: var(--space-2);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Profile Information
                </h3>

                <div style="display: flex; flex-direction: column; gap: var(--space-3);">
                    <div style="display: flex; align-items: center; gap: var(--space-3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground); flex-shrink: 0;"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                        <div>
                            <p style="font-size: 0.75rem; color: var(--muted-foreground); text-transform: uppercase; letter-spacing: 0.05em;">Email</p>
                            <p class="body-text"><?= $user['email']; ?></p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: var(--space-3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--muted-foreground); flex-shrink: 0;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <div>
                            <p style="font-size: 0.75rem; color: var(--muted-foreground); text-transform: uppercase; letter-spacing: 0.05em;">Account Type</p>
                            <p class="body-text">
                                <span class="badge badge-primary"><?= ucfirst($user['role']); ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($user['role'] === 'business'): ?>
                <!-- My Shops Card -->
                <div class="cta-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-4);">
                        <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500; display: flex; align-items: center; gap: var(--space-2);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            My Shops
                        </h3>
                        <a href="/shops/create" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"></path><path d="M5 12h14"></path></svg>
                            Create Shop
                        </a>
                    </div>

                    <?php if (empty($shops)): ?>
                        <p class="body-text text-muted">You haven't created any shops yet.</p>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: var(--space-3);">
                            <?php foreach ($shops as $shop): ?>
                                <a href="/shops/<?= $shop['shop_id']; ?>" style="display: block; padding: var(--space-4); background: var(--secondary); border-radius: var(--radius-md); text-decoration: none; transition: all 0.2s ease;">
                                    <h4 style="font-family: var(--font-sans); font-size: 1rem; font-weight: 600; color: var(--foreground); margin-bottom: var(--space-1);"><?= htmlspecialchars($shop['name']); ?></h4>
                                    <p style="font-size: 0.875rem; color: var(--muted-foreground); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= htmlspecialchars($shop['description']); ?></p>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Account Settings Card -->
            <div class="cta-card">
                <h3 style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 500; margin-bottom: var(--space-4); display: flex; align-items: center; gap: var(--space-2);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Account Settings
                </h3>

                <div style="display: flex; flex-direction: column; gap: var(--space-3);">
                    <a href="/profile/edit" class="btn btn-primary" style="justify-content: flex-start;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>
                        Edit Profile
                    </a>
                    <a href="/profile/change-password" class="btn btn-outline" style="justify-content: flex-start;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../../partials/footer.php"); ?>
