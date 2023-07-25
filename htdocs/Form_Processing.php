<?php

// File holds all the form processing data
require_once('server.php');

// Prepared Statements
$addStatement = $conn->prepare("INSERT INTO PRODUCT(product_id, product_name, product_description, price, quantity, product_status, supplier_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$addStatement->bind_param("issdisi", $product_id, $product_name, $product_desciption, $price, $quanity, $product_status, $supplier_id);

$editStatement = $conn->prepare("UPDATE PRODUCT SET product_id=?, product_name=?, product_description=?, price=?, quantity=?, product_status=?, supplier_id=? WHERE system_id=?");
$editStatement->bind_param("issdisis",$product_id, $product_name, $product_desciption, $price, $quanity, $product_status, $supplier_id, $system_id);

$deleteStatement = $conn->prepare("DELETE FROM PRODUCT WHERE system_id=?");
$deleteStatement->bind_param("i", $system_id);

$addSupplier = $conn->prepare("INSERT INTO SUPPLIER(supplier_id, supplier_name, supplier_address, phone, email) VALUES (?, ?, ?, ?, ?");
$addSupplier->bind_param("sssss", $supplier_id, $supplier_name, $supplier_address, $phone, $email);

$editSupplier = $conn->prepare("UPDATE SUPPLIER SET supplier_id=?, supplier_name=?, supplier_address=?, phone=?, email=? WHERE supplier_id=?");
$editSupplier->bind_param("sssss", $supplier_id, $supplier_name, $supplier_address, $phone, $email); // Need to add auto-increment here too

$deleteSupplier = $conn->prepare("DELETE FROM SUPPLIER WHERE supplier_id=?");
$deleteSupplier->bind_param("i", $supplier_id);


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
else if(isset($_POST['DELETE_PRODUCT'])){

    // Get the id of the record
    $system_id = $_POST['system_id'];

    $deleteStatement->execute();

    // Send back to products page
    header("location:Products.php");
}

if(isset($_POST['Add_Supplier'])){
    
    // Get all inputs
    $supplier_id = $_POST['supplier_id'];
    $supplier_name = $_POST['supplier_name'];
    $supplier_address = $_POST['supplier_address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Sanitize
    $supplier_name = filter_var($supplier_name, FILTER_SANITIZE_STRING);
    $supplier_address = filter_var($supplier_address, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Excecute command
    $addSupplier->execute();

    header("location:Suppliers.php");
}
else if(isset($_POST['Edit_Supplier'])){

    // Get all inputs
    $supplier_id = $_POST['supplier_id'];
    $supplier_name = $_POST['supplier_name'];
    $supplier_address = $_POST['supplier_address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
 
    // Sanitize
    $supplier_name = filter_var($supplier_name, FILTER_SANITIZE_STRING);
    $supplier_address = filter_var($supplier_address, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
 
    // Excecute command
    $editSupplier->execute();
 
    // send back to suppliers page
    header("location:Suppliers.php");
}
else if(isset($_POST['DELETE_SUPPLIER'])){

    // Get supplier Id
    $supplier_id = $_POST['supplier_id'];

    // Execute Statment
    $deleteSupplier->execute();

    // Send back to suppliers page
    header("location:Suppliers.php");
}
