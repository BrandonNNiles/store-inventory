<?php
    
    //Configurables
    $title = "Admin"; //title of the page
    $require_auth = true; //whether or not the user needs to be logged in to see this page
    $perm_level = 2; //the user's permision level to see the page (requires require_auth = true)

    require __DIR__ . '/modules/authmanager.php';
    view_redirect($require_auth, $perm_level);
?>

<?php
    $conn = sqlconn();
    $query = "select * from USERS";
    $result = mysqli_query($conn, $query);
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
                            <h2 class="display-6 text-center">Users Table</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <tr class="bg-dark text-white">
                                    <td> First Name </td>
                                    <td> Last Name </td>
                                    <td> UserName </td>
                                    <td> Email </td>
                                    <td> Permission Level </td>
                                    <td> EDIT - DELETE</td>
                                </tr>
                                <tr>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <td><?php echo $row['first_name']; ?></td>
                                        <td><?php echo $row['last_name']; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['permission']; ?></td>
                                        <td>
                                            <?php
                                            $output = $output = $row['id'] . "," . $row['first_name'] . "," . $row['last_name'] . "," . $row['username'] . "," . $row['email'] . "," . $row['permission'];
                                            ?>
                                            <form method="POST" action="Form_Processing.php">
                                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="<?php echo $output ?>">EDIT</a>
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this record?');" value="DELETE" name="DELETE_USER" action="Form_Processing.php">
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
                            <h4 class="modal-title">Add User</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <label>First Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="20" class="form-control" name="first_name" required="required">
                                </div>

                                <label>Last Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="20" class="form-control" name="last_name" required="required">
                                </div>

                                <label>UserName</label>
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="20" class="form-control" name="username" required="required">
                                </div>

                                <label>Password</label>
                                <div class="input-group mb-3">
                                    <input type="password"  class="form-control" name="password" required="required">
                                </div>

                                <label>Email</label>
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="20" class="form-control" name="email" required="required">
                                </div>

                                <label>Permission</label>
                                <div class="input-group mb-3">
                                    <select name="permission">
                                        <option value="0">Read Only</option>
                                        <option value="1">Edit</option>
                                        <option value="2">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" value="Add User" name="Add_User" form="addForm">
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
                            <h4 class="modal-title">Edit User</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <input type="hidden" name="id">

                                <label>First Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="20" class="form-control" name="first_name" required="required">
                                </div>

                                <label>Last Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="20" class="form-control" name="last_name" required="required">
                                </div>

                                <label>UserName</label>
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="20" class="form-control" name="username" required="required">
                                </div>

                                <label>Password</label>
                                <div class="input-group mb-3">
                                    <input type="password"  class="form-control" name="password" required="required">
                                </div>

                                <label>Email</label>
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="20" class="form-control" name="email" required="required">
                                </div>

                                <label>Permission</label>
                                <div class="input-group mb-3">
                                    <select name="permission">
                                        <option value="0">Read Only</option>
                                        <option value="1">Edit</option>
                                        <option value="2">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-primary" type="submit" value="Edit User" name="Edit_User">
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
            var md = modalObj.querySelector('.modal-body input[name="id"]');
            md.value = split[0];
            var md = modalObj.querySelector('.modal-body input[name="first_name"]');
            md.value = split[1];
            var md = modalObj.querySelector('.modal-body input[name="last_name"]');
            md.value = split[2];
            var md = modalObj.querySelector('.modal-body input[name="username"]');
            md.value = split[3];
            var md = modalObj.querySelector('.modal-body input[name="email"]');
            md.value = split[4];
            var md = modalObj.querySelector('.modal-body select[name="permission"]');
            md.value = split[5];

        });
    </script>
</body>

</html>