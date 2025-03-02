<?php require(__DIR__ . "/../partials/header.php"); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Profile Information</h3>
                </div>
                <div class="card-body">
                    <p><strong>Username:</strong> <?= $user['username']; ?></p>
                    <p><strong>Email:</strong> <?= $user['email']; ?></p>
                    <p><strong>Account Type:</strong> <?= ucfirst($user['role']); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <?php if ($user['role'] === 'business'): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>My Shops</h3>
                    </div>
                    <div class="card-body">
                        <!-- Shop list will be added later -->
                        <p>You currently have no shops.</p>
                        <a href="/shops/create" class="btn btn-primary">Create a Shop</a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3>Account Settings</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="/profile/edit" class="btn btn-primary">Edit Profile</a>
                    </div>
                    <div class="mb-3">
                        <a href="/profile/change-password" class="btn btn-secondary">Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require(__DIR__ . "/../partials/footer.php"); ?>