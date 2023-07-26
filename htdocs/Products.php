<?php
    //Configurables
    $title = "Products"; //title of the page
    $require_auth = true; //whether or not the user needs to be logged in to see this page
    $perm_level = 1; //the user's permision level to see the page (requires require_auth = true)

    require __DIR__ . '/modules/authmanager.php';
    view_redirect($require_auth, $perm_level);
?>

<?php
    $conn = sqlconn();
    $query = "select * from PRODUCT";
    $result = mysqli_query($conn, $query);

    $supplier_query = "SELECT supplier_id FROM SUPPLIER";

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="stylesheets/bt.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <title><?php echo($title)?></title>
</head>

<body>
    <div class="bg-dark">
        <div id="nav-placeholder">

        </div>
        <script>
            $(function() {
                $("#nav-placeholder").load("components/navbar.php");
            });
        </script>
        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="text-center">
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-10">
                    <div class="card mt-5 ">
                        <div class="card-header">
                            <h2 class="display-6 text-center">Product Table</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <tr class="bg-dark text-white">
                                    <td> Product ID </td>
                                    <td> Product NAME </td>
                                    <td> Product Description </td>
                                    <td> Price </td>
                                    <td> Quantity </td>
                                    <td> Product Status </td>
                                    <td> Supplier ID </td>
                                    <td> EDIT - DELETE</td>
                                </tr>
                                <tr>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <td><?php echo $row['product_id']; ?></td>
                                        <td><?php echo $row['product_name']; ?></td>
                                        <td><?php echo $row['product_description']; ?></td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo $row['product_status']; ?></td>
                                        <td><?php echo $row['supplier_id']; ?></td>
                                        <td>
                                            <?php
                                            $output = $output = $row['system_id'] . "," . $row['product_id'] . "," . $row['product_name'] . "," . $row['product_description'] . "," . $row['price'] . "," . $row['quantity'] . "," . $row['product_status'] . "," . $row['supplier_id'];
                                            ?>
                                            <form method="POST" action="Form_Processing.php">
                                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="<?php echo $output ?>">EDIT</a>
                                                <input type="hidden" name="system_id" value="<?php echo $row['system_id']; ?>">
                                                <input class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this record?');" value="DELETE" name="DELETE_PRODUCT" action="Form_Processing.php">
                                            </form>
                                        </td>
                                </tr>
                            <?php
                                    }
                            ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to add new record -->
        <div class="modal" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="addForm" action="Form_Processing.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Product</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <label>Product ID</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="product_id" required="required">
                                </div>

                                <label>Product Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="product_name" required="required">
                                </div>

                                <label>Product Description</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="product_description" required="required">
                                </div>

                                <label>Price</label>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="price_dollars" required="required">
                                        <span class="input-group-text">.</span>
                                        <input type="number" class="form-control" name="price_cents">
                                    </div>

                                </div>

                                <label>Quanitity</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="quantity" required="required">
                                </div>

                                <label>Product Status</label>
                                <div class="input-group mb-3">
                                    <select name="product_status">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>

                                <label>Supplier ID</label>
                                <div class="input-group mb-3">
                                    <select name="supplier_id">
                                        <?php
                                        $supplier_result = mysqli_query($conn, $supplier_query);
                                        while ($suppliers = mysqli_fetch_array(
                                            $supplier_result,
                                            MYSQLI_ASSOC
                                        )) :;
                                        ?>
                                            <option value="<?php echo $suppliers['supplier_id']; ?>">
                                                <?php echo $suppliers["supplier_id"]; ?>
                                            </option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" value="Add Product" name="Add_Product" form="addForm">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal to edit record -->
        <div class="modal" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="editForm" action="Form_Processing.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Product</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <input type="hidden" name="system_id">

                                <label>Product ID</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="product_id" required="required">
                                </div>

                                <label>Product Name</label>
                                <div class="input-group mb-3 ppp">
                                    <input type="text" class="form-control" name="product_name" required="required">
                                </div>

                                <label>Product Description</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="product_description" required="required">
                                </div>

                                <label>Price</label>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="price_dollars" required="required">
                                        <span class="input-group-text">.</span>
                                        <input type="number" class="form-control" name="price_cents">
                                    </div>

                                </div>

                                <label>Quanitity</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="quantity" required="required">
                                </div>

                                <label>Product Status</label>
                                <div class="input-group mb-3">
                                    <select name="product_status">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>

                                <label>Supplier ID</label>
                                <div class="input-group mb-3">
                                    <select name="supplier_id">
                                        <?php
                                        $supplier_result = mysqli_query($conn, $supplier_query);
                                        while ($suppliers = mysqli_fetch_array(
                                            $supplier_result,
                                            MYSQLI_ASSOC
                                        )) :;
                                        ?>
                                            <option value="<?php echo $suppliers['supplier_id']; ?>">
                                                <?php echo $suppliers["supplier_id"]; ?>
                                            </option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" value="Edit Product" name="Edit_Product">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script finds modal and populates it with record-->
    <script>
        var modalObj = document.getElementById('editModal');
        modalObj.addEventListener('show.bs.modal', function(event) {

            // Gets the string with the record info
            var sysID = event.relatedTarget.getAttribute('data-bs-whatever');

            // Splitting by comma to get each seperate record
            var split = sysID.split(",");

            // Pre setting input boxes to record
            var md = modalObj.querySelector('.modal-body input[name="system_id"]');
            md.value = split[0];
            var md = modalObj.querySelector('.modal-body input[name="product_id"]');
            md.value = split[1];
            var md = modalObj.querySelector('.modal-body input[name="product_name"]');
            md.value = split[2];
            var md = modalObj.querySelector('.modal-body input[name="product_description"]');
            md.value = split[3];

            var num = split[4].split(".");
            var md = modalObj.querySelector('.modal-body input[name="price_dollars"]');
            md.value = num[0];
            var md = modalObj.querySelector('.modal-body input[name="price_cents"]');
            md.value = num[1];

            var md = modalObj.querySelector('.modal-body input[name="quantity"]');
            md.value = split[5];
            var md = modalObj.querySelector('.modal-body select[name="product_status"]');
            md.value = split[6];
            var md = modalObj.querySelector('.modal-body select[name="supplier_id"]');
            md.value = split[7];

        });
    </script>
</body>

</html>