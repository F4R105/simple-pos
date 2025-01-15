<?php
    require_once "../../config/errorReporting.php";
    require_once "../../config/databaseConnection.php";
    date_default_timezone_set('Africa/Dar_es_Salaam');

    // IS SET FROM REMOVING MANAGERS IN ADMIN ACCOUNT
    if(isset($_GET['id'])){
        $user_id = base64_decode($_GET['id']);

        $sql = "DELETE FROM users WHERE user_id='$user_id'";
        $deleteUser = mysqli_query($conn,$sql);
    
        if(!$deleteUser){
            $msg = base64_encode('Failed to remove manager!..');
            header("location: ../../pages/user/viewManagers.php?msg=$msg&f"); 
            die();
        }
        
        $msg = base64_encode('Manager removed successfully!..');
        header("location: ../../pages/user/viewManagers.php?msg=$msg&f");
    } 

    // IS SET WHEN DELETING ADMIN ACCOUNT
    if(isset($_POST['delete_account'])){
        $user_id = $_POST['user_id'];

        $sql = "DELETE FROM users WHERE user_id='$user_id'";
        $deleteUser = mysqli_query($conn,$sql);
    
        if(!$deleteUser){
            $msg = base64_encode('Failed to remove account!..');
            $shop = base64_encode($shop);
            header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
            die();
        }
        
        $msg = base64_encode('Account removed successfully!..');
        header("location: ../../process/auth/logout.php?msg=$msg&f");
    }