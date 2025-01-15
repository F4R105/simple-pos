<?php

    SESSION_START();
    require_once("../../config/errorReporting.php");
    require_once("../../config/databaseConnection.php");
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $name = mysqli_real_escape_string($conn,$_POST['shop_name']);
    $owner = $_SESSION['user_id'];

    // VALIDATE EMPTY FIELDS
    if(empty($name)){ 
        $msg = base64_encode('All fields are required!..');
        header("location: ../../pages/shop/addShop.php?msg=$msg&f"); 
        die();
    };

    // ADD SHOP
    $query = "INSERT INTO 
        shops(`name`,`owner`) 
        VALUES('$name','$owner')";

    $add_shop = mysqli_query($conn, $query);

    // CHECK IF SHOP ADDED
    if(!$add_shop){ 
        $msg = base64_encode('Failed to add guard!..');
        header("location: ../../pages/shop/addShop.php?msg=$msg&f"); 
        die();
    }

    header("location: ../../pages/shop/viewShops.php");
