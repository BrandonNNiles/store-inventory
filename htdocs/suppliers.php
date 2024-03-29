<?php
//Configurables
$title = "Suppliers Test"; //title of the page
$require_auth = true; //whether or not the user needs to be logged in to see this page
$perm_level = 1; //the user's permision level to see the page (requires require_auth = true)

require __DIR__ . '/modules/authmanager.php';
view_redirect($require_auth, $perm_level);
?>

<?php
$conn = sqlconn();
$supplier_query = "SELECT supplier_id FROM SUPPLIER";

if (isset($_POST['search'])) {
    $filter = $_POST['filter'];
    $query = "SELECT * FROM SUPPLIER WHERE supplier_name LIKE '%$filter%'";
    $result = mysqli_query($conn, $query);
} else {
    $query = "select * from SUPPLIER";
    $result = mysqli_query($conn, $query);
}

if (isset($_POST['showAll'])) {
    $query = "select * from SUPPLIER";
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
            <div class="row ">
                <div class="col-2">
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="btn-toolbar">
                                    <form action="suppliers.php" method="POST">
                                        <input class="btn btn-primary" name="showAll" type="submit" value="Show All">
                                    </form>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
                                </div>
                                <form action="suppliers.php" method="POST">
                                    <div class="input-group mb-3 mt-3">
                                        <input type="text" class="form-control" name="filter">
                                        <input class="btn btn-primary" name="search" type="submit" value="Search">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-10">
                    <div class="card mt-5 ">
                        <div class="card-header">
                            <h2 class="display-6 text-center">Suppliers</h2>
                        </div>
                        <div class="card-body" id="default-table">
                            <table class="table table-bordered text-center">
                                <tr class="bg-dark text-white">
                                    <td> Supplier ID </td>
                                    <td> Supplier Name </td>
                                    <td> Supplier Address </td>
                                    <td> Phone Number </td>
                                    <td> Email </td>
                                    <td> EDIT - DELETE</td>
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
                                    <td><?php echo $row['supplier_id']; ?></td>
                                    <td><?php echo $row['supplier_name']; ?></td>
                                    <td><?php echo $row['supplier_address']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td>
                                        <?php
                                            $output = $output = $row['supplier_id'] . "," . $row['supplier_name'] . "," . $row['supplier_address'] . "," . $row['phone'] . "," . $row['email'];
                                        ?>
                                        <form method="POST" action="modules/form_processing.php">
                                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="<?php echo $output ?>">EDIT</a>
                                            <input type="hidden" name="supplier_id" value="<?php echo $row['supplier_id']; ?>">
                                            <input class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this record?');" value="DELETE" name="DELETE_SUPPLIER" action="modules/form_processing.php">
                                        </form>
                                    </td>
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

        <!-- Modal to add new record -->
        <div class="modal" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="addForm" action="modules/form_processing.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Supplier</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <label>Supplier ID</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="supplier_id" required="required">
                                </div>

                                <label>Supplier Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="supplier_name" required="required">
                                </div>

                                <label>Supplier Address</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="supplier_address" required="required">
                                </div>

                                <label>Phone Number</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="phone" required="required">
                                </div>

                                <label>Email</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="email" required="required">
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" value="Add Supplier" name="Add_Supplier" form="addForm">
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
                    <form method="POST" id="editForm" action="modules/form_processing.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Product</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <label>Supplier ID</label>
                                <div class="input-group mb-3">
                                    <input type="number" readonly class="form-control" name="supplier_id" required="required">
                                </div>

                                <label>Supplier Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="supplier_name" required="required">
                                </div>

                                <label>Supplier Address</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="supplier_address" required="required">
                                </div>

                                <label>Phone Number</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="phone" required="required">
                                </div>

                                <label>Email</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="email" required="required">
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" value="Edit Supplier" name="Edit_Supplier">
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
            var md = modalObj.querySelector('.modal-body input[name="supplier_id"]');
            md.value = split[0];
            var md = modalObj.querySelector('.modal-body input[name="supplier_name"]');
            md.value = split[1];
            var md = modalObj.querySelector('.modal-body input[name="supplier_address"]');
            md.value = split[2];
            var md = modalObj.querySelector('.modal-body input[name="phone"]');
            md.value = split[3];
            var md = modalObj.querySelector('.modal-body input[name="email"]');
            md.value = split[4];
        });
    </script>
</body>

</html>