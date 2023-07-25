<nav class="navbar navbar-expand-lg navbar-light bg-light"  style="background-color: #010e18;" >
    <div class="container-fluid">
        <a class="navbar-brand">CP476</a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="nvbar">
            <div class="navbar-nav">
                <a class="nav-link" href="/Inventory.php">Inventory</a>
                <a class="nav-link" href="/Products.php">Products</a>
                <a class="nav-link" href="/Suppliers.php">Suppliers</a>
                <a class="nav-link" href="/Admin.php">Admin</a>
            </div>
            <div class="col-2">
                <a class="nav-link" href="/logout.php">Logout</a>
                Logged in as: 
                <?php 
                    session_start();
                    echo($_SESSION["username"])
                ?>
            </div>
        </div>
    </div>
</nav>