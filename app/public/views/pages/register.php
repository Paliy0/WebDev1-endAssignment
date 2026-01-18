<?php require(__DIR__ . "/../partials/header.php"); ?>

<main class="main" style="padding: var(--space-16) 0; min-height: calc(100vh - 200px); display: flex; align-items: center;">
    <div class="container">
        <div style="max-width: 480px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: var(--space-8);">
                <a href="/" class="logo" style="font-size: 2rem; display: inline-block; margin-bottom: var(--space-3);">PHP Shop</a>
                <p class="body-text text-muted">Create your account</p>
            </div>

            <div class="cta-card">
                <h1 style="font-family: var(--font-serif); font-size: 1.5rem; margin-bottom: var(--space-6); text-align: center;">Join PHP Shop</h1>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error" style="margin-bottom: var(--space-4);">
                        <?= htmlspecialchars($_SESSION['error']); ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="/register">
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--muted-foreground);" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            <input type="email" class="form-input" id="email" name="email" placeholder="name@example.com" style="padding-left: 48px;" required>
                        </div>
                        <p class="caption text-muted" style="margin-top: var(--space-1);">We'll never share your email with anyone else.</p>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--muted-foreground);" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input type="password" class="form-input" id="password" name="password" placeholder="Create a password" style="padding-left: 48px;" required>
                        </div>
                        <p class="caption text-muted" style="margin-top: var(--space-1);">Must be at least 8 characters.</p>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm" class="form-label">Confirm Password</label>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--muted-foreground);" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input type="password" class="form-input" id="password_confirm" name="password_confirm" placeholder="Confirm your password" style="padding-left: 48px;" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Account Type</label>
                        <div style="display: grid; gap: var(--space-3); grid-template-columns: 1fr 1fr;">
                            <label style="display: block; padding: var(--space-4); border: 1px solid var(--border); border-radius: var(--radius-lg); cursor: pointer; transition: all 0.2s;" class="role-option">
                                <input type="radio" name="role" value="customer" checked style="margin-right: var(--space-2);">
                                <div style="display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-2);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span style="font-weight: 500;">Customer</span>
                                </div>
                                <p class="caption text-muted" style="margin: 0;">Shop for products</p>
                            </label>
                            <label style="display: block; padding: var(--space-4); border: 1px solid var(--border); border-radius: var(--radius-lg); cursor: pointer; transition: all 0.2s;" class="role-option">
                                <input type="radio" name="role" value="business" style="margin-right: var(--space-2);">
                                <div style="display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-2);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    <span style="font-weight: 500;">Business</span>
                                </div>
                                <p class="caption text-muted" style="margin: 0;">Sell your products</p>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full" style="margin-top: var(--space-4);">Create Account</button>
                </form>

                <div style="text-align: center; margin-top: var(--space-6); padding-top: var(--space-6); border-top: 1px solid var(--border);">
                    <p class="body-text text-muted" style="margin: 0;">
                        Already have an account?
                        <a href="/login" style="color: var(--accent); font-weight: 500;">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .role-option:has(input:checked) {
        border-color: var(--foreground);
        background: var(--secondary);
    }
</style>

<?php require(__DIR__ . "/../partials/footer.php"); ?>