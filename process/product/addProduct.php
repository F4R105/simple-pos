<?php

    SESSION_START();
    require_once("../../config/errorReporting.php");
    require_once("../../config/databaseConnection.php");
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $sell_price = mysqli_real_escape_string($conn, $_POST['price']);
    $shop = mysqli_real_escape_string($conn, $_POST['shop']);

    $sql = "INSERT INTO products(`name`, `sell_price`,`shop`) 
            VALUES ('$name','$sell_price','$shop')";

    $query = mysqli_query($conn, $sql);

    // CHECK IF PRODUCT ADDED
    if(!$query){ 
        $msg = base64_encode('Failed to add product!..');
        $shop = base64_encode($shop);
        header("location: ../../pages/product/addProduct.php?sid=$shop&msg=$msg&f"); 
        die();
    }

    $msg = base64_encode('Product added successfully!..');
    $shop = base64_encode($shop);
    header("location: ../../pages/product/viewProducts.php?sid=$shop&msg=$msg&f"); 