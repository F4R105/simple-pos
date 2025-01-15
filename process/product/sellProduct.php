<?php
    SESSION_START();
    require_once "../../config/errorReporting.php";
    require_once "../../config/databaseConnection.php";
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $product = $_POST['product'];
    $shop = $_POST['shop']; //for redirection
    $price_per_unit = $_POST['price'];
    $no_of_units_sold = $_POST['items'];
    $manager = $_SESSION['user_id'];
    $query = "INSERT INTO unit_sales(`product`,`manager`,`price_per_unit`,`units`) VALUES('$product', '$manager', '$price_per_unit','$no_of_units_sold')";
    $record_sale = mysqli_query($conn, $query);

    if(!$record_sale){
        $msg = base64_encode('Failed to record sale!..');
        $shop = base64_encode($shop);
        header("location: ../../pages/shop/viewProducts.php?sid=$shop&msg=$msg&f"); 
        die();
    }
    
    $shop = base64_encode($shop);
    $msg = base64_encode('Sale recorded!..');
    header("location: ../../pages/product/viewProducts.php?sid=$shop&msg=$msg&f"); 
