<?php

// File holds all the form processing data
require_once('server.php');


// Adding a Product Record
if (isset($_POST ['Add_Product'])){

    // Prepared Statement
    $addStatement = $conn->prepare("INSERT INTO PRODUCT(product_id, product_name, product_description, price, quantity, product_status, supplier_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $addStatement->bind_param("issdisi", $product_id, $product_name, $product_desciption, $price, $quanity, $product_status, $supplier_id);

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

    // Prepared Statement
    $editStatement = $conn->prepare("UPDATE PRODUCT SET product_id=?, product_name=?, product_description=?, price=?, quantity=?, product_status=?, supplier_id=? WHERE system_id=?");
    $editStatement->bind_param("issdisis",$product_id, $product_name, $product_desciption, $price, $quanity, $product_status, $supplier_id, $system_id);

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

    // Prepared Statement
    $deleteStatement = $conn->prepare("DELETE FROM PRODUCT WHERE system_id=?");
    $deleteStatement->bind_param("i", $system_id);

    // Get the id of the record
    $system_id = $_POST['system_id'];

    $deleteStatement->execute();

    // Send back to products page
    header("location:Products.php");
}

if(isset($_POST['Add_Supplier'])){
    
    // Prepared Statement
    $addStatement = $conn->prepare("INSERT INTO SUPPLIER(supplier_id, supplier_name, supplier_address, phone, email) VALUES (?, ?, ?, ?, ?)");
    $addStatement->bind_param("issss", $supplier_id, $supplier_name, $supplier_address, $phone, $email);

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
    $addStatement->execute();

    header("location:Suppliers.php");
}
else if(isset($_POST['Edit_Supplier'])){

    // Prepared Statement
    $editStatement = $conn->prepare("UPDATE SUPPLIER SET supplier_name=?, supplier_address=?, phone=?, email=? WHERE supplier_id=?");
    $editStatement->bind_param("ssssi", $supplier_name, $supplier_address, $phone, $email, $supplier_id);

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
    $editStatement->execute();
 
    // send back to suppliers page
    header("location:Suppliers.php");
}
else if(isset($_POST['DELETE_SUPPLIER'])){

    // Prepared Statement
    $deleteStatement = $conn->prepare("DELETE FROM SUPPLIER WHERE supplier_id=?");
    $deleteStatement->bind_param("i", $supplier_id);

    // Get supplier Id
    $supplier_id = $_POST['supplier_id'];

    // Execute Statment
    $deleteStatement->execute();

    // Send back to suppliers page
    header("location:Suppliers.php");
}

if (isset($_POST['Add_User'])){

    // Prepared Statement
    $addStatement = $conn->prepare("INSERT INTO USERS(username, first_name, last_name, email, user_password, permission) VALUES (?, ?, ?, ?, ?, ?)");
    $addStatement->bind_param("sssssi", $username, $first_name, $last_name, $email, $password, $permission);

    // Get info
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $permission = $_POST['permission'];

    // Clean data
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
    $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Execute
    $addStatement->execute();

    header("location:Admin.php");
}
else if (isset($_POST['Edit_User'])){
    
    // Prepared Statement
    $editStatement = $conn->prepare("UPDATE USERS SET username=?, first_name=?, last_name=?, email=?, user_password=?, permission=? WHERE id=?");
    $editStatement->bind_param("sssssii", $username, $first_name, $last_name, $email, $password, $permission, $id);

    // Get info
    $id = $_POST['id'];
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $permission = $_POST['permission'];

    // Clean data
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
    $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Execute
    $editStatement->execute();

    // Send back to admin
    header("location:Admin.php");

}
else if (isset($_POST['DELETE_USER'])){

    // Prepared Statement
    $deleteStatement = $conn->prepare("DELETE FROM USERS WHERE id=?");
    $deleteStatement->bind_param("i", $id);

    // Get supplier Id
    $id = $_POST['id'];

    // Execute Statment
    $deleteStatement->execute();

    // Send back to suppliers page
    header("location:Admin.php");
}
