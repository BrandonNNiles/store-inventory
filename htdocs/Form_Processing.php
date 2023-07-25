<?php

// File holds all the form processing data
require_once('server.php');

// Prepared Statements
$addStatement = $conn->prepare("INSERT INTO PRODUCT(product_id, product_name, product_description, price, quantity, product_status, supplier_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$addStatement->bind_param("issdisi", $product_id, $product_name, $product_desciption, $price, $quanity, $product_status, $supplier_id);

$editStatement = $conn->prepare("UPDATE PRODUCT SET product_id=?, product_name=?, product_description=?, price=?, quantity=?, product_status=?, supplier_id=? WHERE system_id=?");
$editStatement->bind_param("issdisis",$product_id, $product_name, $product_desciption, $price, $quanity, $product_status, $supplier_id, $system_id);

$deleteStatement = $conn->prepare("DELETE FROM PRODUCT WHERE system_id=?");
$deleteStatement->bind_param("s", $system_id);


// Adding a Product Record
if (isset($_POST ['Add_Product'])){

    // Get all inputs for new record
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_desciption = $_POST['product_description'];
    $price = (string)$_POST['price_dollars'] . "." . (string)$_POST['price_cents'];
    $quanity = $_POST['quantity'];
    $product_status = $_POST['product_status'];
    $supplier_id = $_POST['supplier_id'];

    // Sanitize input
    $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);

    // Add to database
    $addStatement->execute();

    // Send Back to products page
    header("location:Products.php");
}
else if(isset($_POST['Edit_Product'])){

    // Get all inputs
    $system_id = $_POST['system_id'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_desciption = $_POST['product_description'];
    $price = (string)$_POST['price_dollars'] . "." . (string)$_POST['price_cents'];
    $quanity = $_POST['quantity'];
    $product_status = $_POST['product_status'];
    $supplier_id = $_POST['supplier_id'];

    // Sanitize input
    $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);

    // Update record
    $editStatement->execute();

    // Send Back to products page
    header("location:Products.php");

}
else if(isset($_POST['DELETE'])){

    // Get the id of the record
    $system_id = $_POST['system_id'];

    $deleteStatement->execute();

    // Send back to products page
    header("location:Products.php");
}
?>