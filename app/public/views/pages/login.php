<?php require(__DIR__ . "/../partials/header.php"); ?>

<main class="main" style="padding: var(--space-16) 0; min-height: calc(100vh - 200px); display: flex; align-items: center;">
    <div class="container">
        <div style="max-width: 420px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: var(--space-8);">
                <a href="/" class="logo" style="font-size: 2rem; display: inline-block; margin-bottom: var(--space-3);">Curated</a>
                <p class="body-text text-muted">Sign in to your account</p>
            </div>

            <div class="cta-card">
                <h1 style="font-family: var(--font-serif); font-size: 1.5rem; margin-bottom: var(--space-6); text-align: center;">Welcome Back</h1>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error" style="margin-bottom: var(--space-4);">
                        <?= $_SESSION['error']; ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success" style="margin-bottom: var(--space-4);">
                        <?= $_SESSION['success']; ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="/login">
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--muted-foreground);" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                            <input type="email" class="form-input" id="email" name="email" placeholder="name@example.com" style="padding-left: 48px;" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-2);">
                            <label for="password" class="form-label" style="margin-bottom: 0;">Password</label>
                            <a href="/forgot-password" style="font-size: 0.875rem; color: var(--muted-foreground);">Forgot password?</a>
                        </div>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--muted-foreground);" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <input type="password" class="form-input" id="password" name="password" placeholder="Enter your password" style="padding-left: 48px;" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: var(--space-2); cursor: pointer;">
                            <input type="checkbox" id="remember-me" style="width: 16px; height: 16px; accent-color: var(--foreground);">
                            <span style="font-size: 0.875rem; color: var(--muted-foreground);">Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full" style="margin-top: var(--space-2);">Sign In</button>
                </form>

                <div style="text-align: center; margin-top: var(--space-6); padding-top: var(--space-6); border-top: 1px solid var(--border);">
                    <p class="body-text text-muted" style="margin: 0;">
                        Don't have an account?
                        <a href="/register" style="color: var(--accent); font-weight: 500;">Create one</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../partials/footer.php"); ?>
