<?php
    SESSION_START();
    require_once "../../config/errorReporting.php";
    require_once "../../config/databaseConnection.php";
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $product = $_POST['product'];
    $shop = $_POST['shop']; //for redirection
    $price_per_item = $_POST['price'];
    $no_of_items_bought = $_POST['items'];
    $owner = $_SESSION['user_id'];
    $query = "INSERT INTO unit_purchases(`product`,`owner`,`price_per_item`,`items`) VALUES('$product', '$owner', '$price_per_item','$no_of_items_bought')";
    $record_purchase = mysqli_query($conn, $query);

    if(!$record_purchase){
        $msg = base64_encode('Failed to record purchase!..');
        $shop = base64_encode($shop);
        header("location: ../../pages/shop/viewProducts.php?sid=$shop&msg=$msg&f"); 
        die();
    }
    
    $shop = base64_encode($shop);
    $msg = base64_encode('Purchase recorded!..');
    header("location: ../../pages/product/viewProducts.php?sid=$shop&msg=$msg&f"); 
