<?php

?>
<?php
include(__DIR__ . "/../header.php");
?>
<div class="card">
    <div class="card-header">
        Create Product
    </div>
    <div class="card-body">
        <form action="/products/create" method="post" enctype="multipart/form-data" id="create-form">
            <div class="row mb-3">
                <div class="col">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="col">
                    <label for="price" class="form-label">Price:</label>
                    <input type="text" class="form-control" name="price" id="price">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="text" class="form-control" name="quantity" id="quantity">
                </div>
            </div>
            <div class="row mb-3">
                <label for="desc" class="form-label">Description:</label>
                <textarea class="form-control" rows="4" cols="50" name="desc" placeholder="Enter text here..."></textarea>
            </div>
            <div class="row mb-3">
                <label for="img" class="form-label">Image: </label>
                <input type="file" class="form-control-file" name="img" id="img">
            </div>
            <button type="submit" class="btn btn-success">Add</button>
            <a name="" id="" class="btn btn-primary" href="/product" role="button">Cancel</a>

        </form>
    </div>

</div>
<?php include(__DIR__ . "/../footer.php"); ?>