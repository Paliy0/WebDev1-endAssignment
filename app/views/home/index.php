<?php
include __DIR__ . '/../header.php';
?>

<div class="text-center container py-5">
    <h4 class="mt-4 mb-5"><strong>Products</strong></h4>
    <div class="container">
        <div class="row">
            <?php foreach ($products as $product) { ?>
                <div class="col-sm-6 col-md-4">
                    <div class="card">
                        <img class="card-img-top image-fluid" src=" <?= $product->getImg() ?>" alt="Product image">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product->getName() ?></h5>
                            <p class="card-text"><?= $product->getPrice() ?>€</p>
                            <p class="card-text">Store: <?= $product->getStoreName() ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/../footer.php';
