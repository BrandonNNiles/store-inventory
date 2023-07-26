<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// connect to database
try {
    $conn  = new mysqli("2.tcp.ngrok.io", "rini", "CP476", "CP476", "12808");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
} catch(Exception $e) {
    error_log($e->getMessage());
    exit('Error connecting to database');
}

// create database
$sql = "CREATE DATABASE IF NOT EXISTS CP476";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
    } else {
    echo "Error creating database: " . $conn->error . "\n";
}

// create tables
function verify_creation($conn, $sql){
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully\n";
    } else {
        echo "Error creating table: " . $conn->error . "\n";
    }
}
$sql_supplier = "CREATE TABLE IF NOT EXISTS
        SUPPLIER(
            supplier_id VARCHAR(4) PRIMARY KEY, 
            supplier_name VARCHAR(100), 
            supplier_address VARCHAR(3000), 
            phone INT(10),
            mail VARCHAR(100))";

verify_creation($conn, $sql_supplier);

// create id variabe
$sql_product = "CREATE TABLE IF NOT EXISTS
        PRODUCT(
            system_id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            product_id VARCHAR(4), 
            product_name VARCHAR(100), 
            product_description VARCHAR(1000),
            price FLOAT(10),
            quantity INT(7), 
            product_status CHAR(1),
            supplier_id VARCHAR(4))";

verify_creation($conn, $sql_product);

$sql_supplier_history = "CREATE TABLE IF NOT EXISTS
        SUPPLIER_HISTORY(
            change_id VARCHAR(5) PRIMARY KEY,
            username VARCHAR(20), 
            change_date DATETIME)";

verify_creation($conn, $sql_supplier_history);

$sql_users = "CREATE TABLE IF NOT EXISTS
        USERS(
            username VARCHAR(20) PRIMARY KEY,
            first_name VARCHAR(20), 
            last_name VARCHAR(20),
            email VARCHAR(20),
            user_password VARCHAR(20),
            permission INT(1))";

verify_creation($conn, $sql_users);

$sql_product_history = "CREATE TABLE IF NOT EXISTS
        PRODUCT_HISTORY(
            change_id VARCHAR(5) PRIMARY KEY,
            username VARCHAR(20), 
            change_date DATETIME)";

verify_creation($conn, $sql_product_history);


$dbtoSkip = array("information_schema","mysql","performance_schema","sys"); 

$result = $conn->query("show databases");
while($row = $result->fetch_array(MYSQLI_ASSOC)){
    $print = true;

    foreach($dbtoSkip as $key=>$vlue){
        if($row["Database"] == $vlue) {
            $print=false;
            unset($dbtoSkip[$key]);
        }
    }

    if($print){
        echo '<br/>'.$row["Database"]; 
    }
}
$listdbtables = array_column($conn->query('SHOW TABLES')->fetch_all(),0);
print_r($listdbtables);


// cerate records 
// should prob read this as a .txt file but i didnt want to fig how out to
$sql = "INSERT INTO PRODUCT(product_id, product_name, product_description, price, quantity, product_status, supplier_id) VALUES 
        ('2591', 'Camera', 'Camera', 799.9, 50, 'B', '7890'),
        ('3374', 'Laptop', 'MacBook Pro', 1799.9, 30, 'A', '9876'),
        ('3034', 'Telephone', 'Cordless Phone', 299.99, 40, 'A', '3456'),
        ('3034', 'Telephone', 'Home telephone', 99.9, 25, 'A', '8765'),
        ('1234', 'TV', 'Plate TV', 799.9, 20, 'C', '9144'),
        ('1234', 'TV', 'Plate TV', 1499.99, 5, 'A', '7671'),
        ('2591', 'Camera', 'Instant Camera', 179.5, 30, 'C', '8642'),
        ('1516', 'Mouse', 'Wireless Mouse', 99.5, 30, 'A', '3579'),
        ('3034', 'Telephone', 'Home Telephone', 169.99, 15, 'A', '8692'),
        ('2591', 'Camera', 'Digital Camera', 499.9, 10, 'B', '9512'),
        ('3034', 'Telephone', 'Home Telephone', 59.5, 20, 'A', '8655'),
        ('2591', 'Camera', 'Digital Camera', 449.4, 50, 'A', '3592'),
        ('1234', 'TV', 'Plate TV', 699.7, 5, 'B', '7084'),
        ('1516', 'Mouse', 'Wireless Mouse', 69.9, 25, 'C', '2345'),
        ('3374', 'Laptop', 'Laptop', 1399.2, 10, 'B', '1357'),
        ('3374', 'Laptop', 'Refurbished Laptop', 1099.1, 20, 'A', '6954'),
        ('1516', 'Mouse', 'Wireless Mouse', 49.4, 50, 'B', '9794'),
        ('1516', 'Mouse', 'Wireless Mouse', 69.5, 20, 'A', '7807'),
        ('1234', 'TV', 'Plate TV', 599.3, 5, 'B', '8672'),
        ('3374', 'Laptop', 'Laptop', 1369.9, 15, 'A', '4567')";

$conn->query($sql);

$sql = "INSERT INTO SUPPLIER(supplier_id, supplier_name, supplier_address, phone, mail) VALUES 
        ('9512', 'Acme Corporation', '123 Main St', 2052888591, 'info@acme-corp.com'),
        ('8642', 'Xerox Inc.', '456 High St', 5053988414, 'info@xrx.com'),
        ('3579', 'RedPark Ltd.', '789 Park Ave', 6046832555, 'info@redpark.ca'),
        ('7890', 'Samsung', '456 Seoul St', 9097634442, 'support@samsung.com'),
        ('7671', 'LG Electronics', '789 Busan St', 6682865378, 'support@lge.kr'),
        ('9876', 'Toshiba', '246 Osaka St', 9063780835, 'support@toshiba.co.jp'),
        ('3456', 'Panasonic', '246 Osaka St', 4438879967, 'support@panasonic.co.jp'),
        ('8765', 'Philips', '789 Amsterdam St', 61483898670, 'support@philips.au'),
        ('1357', 'Sharp', '123 Tokyo St', 8047453107, 'support@sharp.co.jp'),
        ('9144', 'Fujitsu', '456 Tokyo St', 0335567890, 'support@fujitsu.co.jp'),
        ('8655', 'Dell', '246 Austin St', 5053513181, 'support@dell.com'),
        ('3592', 'IBM', '456 New York St', 2013359423, 'support@ibm.com'),
        ('7084', 'Acer', '135 Taipei St', 905926031, 'support@acer.tw'),
        ('2345', 'MSI', '789 Mofan St', 943299465, 'support@msi.tw'),
        ('6954', 'Apple', '246 Cupertino St', 2029182132, 'support@apple.com'),
        ('9794', 'Amazon', '246 Seattle St', 5553438950, 'support@amazon.com'),
        ('8692', 'Microsoft', '123 Redmond St', 5055490420, 'support@microsoft.com'),
        ('7807', 'Intel', '2200 Mission College Blvd', 4086467611, 'support@intel.com'),
        ('8672', 'AMD', '246 Santa Clara St', 3128662043, 'support@amd.com'),
        ('4567', 'Qualcomm', '456 San Diego St', 447700087231, 'info@qualcomm.co.uk')";

$conn->query($sql);

//$result = $conn->query("SELECT product_id FROM PRODUCT");

$listdbtables = array_column($conn->query('SELECT product_id FROM PRODUCT')->fetch_all(),0);
print_r($listdbtables);

//prepared statement inserting records into PRODUCT table
$sql = $conn->prepare("INSERT INTO PRODUCT(product_id, product_name, product_description, price, quantity, product_status, supplier_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("sssdiss", $product_id, $product_name, $product_description, $price, $quantity, $product_status, $suplier_id); // “sss" means that $fn, $ln and $email as a string
$product_id = '1111';
$product_name = 'Keyboard';
$product_description = 'wireless keyboard';
$price = 100.00;
$quantity = 40;
$product_status = 'A';
$suplier_id = '4567';
$sql->execute();

$listdbtables = array_column($conn->query('SELECT product_id FROM PRODUCT')->fetch_all(),0);
print_r($listdbtables);

$conn->query("DROP TABLE PRODUCT");
$conn->close();
?>