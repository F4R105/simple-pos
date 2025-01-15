<?php
    if(!isset($_GET['id'])){ header('location: ../../'); }
    require_once "../../config/errorReporting.php";
    require_once "../../config/databaseConnection.php";
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $product_id = base64_decode($_GET['pid']);
    $shop = base64_decode($_GET['sid']);

    $sql = "DELETE FROM shops WHERE shop_id='$shop'";
    $deleteProduct = mysqli_query($conn,$sql);

    if(!$deleteProduct){
        $msg = base64_encode('Failed to delete product!..');
        $shop = base64_encode($shop);
        header("location: ../../pages/shop/viewShops.php"); 
        die();
    }
    
    $shop = base64_encode($shop);
    $msg = base64_encode('Product deleted!..');
    header("location: ../../pages/shop/viewShops.php"); 