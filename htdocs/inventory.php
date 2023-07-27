<?php
//Configurables
$title = "Inventory"; //title of the page
$require_auth = true; //whether or not the user needs to be logged in to see this page
$perm_level = 0; //the user's permision level to see the page (requires require_auth = true)

require __DIR__ . '/modules/authmanager.php';
view_redirect($require_auth, $perm_level);
?>

<?php
$conn = sqlconn();

if (isset($_POST['search'])) {
    $filter = $_POST['filter'];
    $query = "SELECT PRODUCT.product_id, PRODUCT.product_name, PRODUCT.quantity, PRODUCT.price, PRODUCT.product_status, SUPPLIER.supplier_name FROM PRODUCT INNER JOIN SUPPLIER ON PRODUCT.supplier_id=SUPPLIER.supplier_id WHERE product_name LIKE '%$filter%'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) < 1) {
        $query = "SELECT PRODUCT.product_id, PRODUCT.product_name, PRODUCT.quantity, PRODUCT.price, PRODUCT.product_status, SUPPLIER.supplier_name FROM PRODUCT INNER JOIN SUPPLIER ON PRODUCT.supplier_id=SUPPLIER.supplier_id WHERE supplier_name LIKE '%$filter%'";
        $result = mysqli_query($conn, $query);
    }
} else {
    $query = "SELECT PRODUCT.product_id, PRODUCT.product_name, PRODUCT.quantity, PRODUCT.price, PRODUCT.product_status, SUPPLIER.supplier_name FROM PRODUCT INNER JOIN SUPPLIER ON PRODUCT.supplier_id=SUPPLIER.supplier_id";
    $result = mysqli_query($conn, $query);
}
if (isset($_POST['showAll'])){
    $query = "SELECT PRODUCT.product_id, PRODUCT.product_name, PRODUCT.quantity, PRODUCT.price, PRODUCT.product_status, SUPPLIER.supplier_name FROM PRODUCT INNER JOIN SUPPLIER ON PRODUCT.supplier_id=SUPPLIER.supplier_id";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="stylesheets/bt.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <title><?php echo ($title) ?></title>
    <link rel="icon" type="image/png" href="resources/images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/resources/images/favicon-16x16.png" sizes="16x16" />
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
                                <form action="inventory.php" method="POST">
                                    <input class="btn btn-primary" name="showAll" type="submit" value="Show All">
                                </form>
                                <form action="inventory.php" method="POST">
                                    <div class="input-group mb-3 mt-3">
                                        <input type="text" class="form-control" name="filter">
                                        <input class="btn btn-primary" name="search" type="submit" value="Search"></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mt-5 ">
                        <div class="card-header">
                            <h2 class="display-6 text-center">Inventory</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <tr class="bg-dark text-white">
                                    <td> Product ID </td>
                                    <td> Product Name </td>
                                    <td> Quantity </td>
                                    <td> Price </td>
                                    <td> Status </td>
                                    <td> Supplier Name </td>
                                </tr>
                                <tr>
                                    <?php
                                    if (mysqli_num_rows($result) < 1) {
                                    ?>
                                <tr>
                                    <td colspan="6">No Record Found
                                </tr>
                                <?php
                                    } else {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <td><?php echo $row['product_id']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['product_status']; ?></td>
                                    <td><?php echo $row['supplier_name']; ?></td>
                                    </tr>
                            <?php
                                        }
                                    }
                            ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>