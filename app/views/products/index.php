<?php

include(__DIR__ . "/../header.php");
?>
<br />
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="/product/create" role="button">Create</a>
    </div>
    <div class=" card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model as $product) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $product->getId(); ?></td>
                            <td><?php echo $product->getName(); ?></td>
                            <td><?php echo $product->getDescription(); ?></td>
                            <td>
                                <input name="editbtn" id="editbtn" class="btn btn-info" type="button" value="Edit" onclick="location='product/edit'">
                                <input name="deletebtn" id="deletebtn" class="btn btn-danger" type="button" value="Delete" onclick="location='product/delete'">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<?php include(__DIR__ . "/../footer.php"); ?>