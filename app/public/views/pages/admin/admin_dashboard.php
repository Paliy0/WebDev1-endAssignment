<?php require(__DIR__ . "/../../partials/header.php"); ?>

<main class="container mt-4">
    <h1>Admin Dashboard</h1>
    <p>Welcome to the admin panel. Manage users and shops below.</p>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $userCount; ?></h5>
                    <p class="card-text">Total Users</p>
                    <a href="/admin/users" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $shopCount; ?></h5>
                    <p class="card-text">Total Shops</p>
                    <a href="/admin/shops" class="btn btn-primary">Manage Shops</a>
                </div>
            </div>
        </div>
    </div>
</main>