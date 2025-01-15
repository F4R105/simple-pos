<?php

    require_once("../../config/errorReporting.php");
    require_once("../../config/databaseConnection.php");
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $password = password_hash(mysqli_real_escape_string($conn,"1234"), PASSWORD_DEFAULT);
    $shop = mysqli_real_escape_string($conn,$_POST['shop']);
    $role = "MANAGER";

    // VALIDATE EMPTY FIELDS
    if(empty($username) || empty($name) || empty($password) || empty($phone)){ 
        $msg = base64_encode('All fields are required!..');
        header("location: ../../pages/user/addManager.php?msg=$msg&f"); 
        die();
    };

    // VALIDATE DUPLICATE USER
    $query = "SELECT user_id FROM users WHERE username='$username'";
    $fetch_user = mysqli_query($conn,$query);
    $verify_user_id = mysqli_num_rows($fetch_user);

    if($verify_user_id !== 0){ 
        $msg = base64_encode('User already exist!..');
        header("location: ../../pages/user/addManager.php?msg=$msg&f"); 
        die();
    }

    // ADD USER
    $query = "INSERT INTO 
        users(`username`,`name`,`password`,`phone`,`role`) 
        VALUES('$username','$name','$password','$phone','$role')";

    $add_user = mysqli_query($conn, $query);

    // CHECK IF USER ADDED
    if(!$add_user){ 
        $msg = base64_encode('Failed to add guard!..');
        header("location: ../../pages/user/addManager.php?msg=$msg&f");  
        die();
    }

    //ADD MANAGER
    $query = "SELECT user_id FROM users WHERE username='$username'";
    $fetch_user = mysqli_query($conn,$query);
    $user = mysqli_fetch_assoc($fetch_user);
    $user_id = $user['user_id'];

    $query = "INSERT INTO managers(`manager`,`shop`) VALUES('$user_id', '$shop')";
    $add_manager = mysqli_query($conn,$query);

    // CHECK IF MANAGER ADDED
    if(!$add_manager){ 
        $msg = base64_encode('Failed to add manager!..');
        header("location: ../../pages/user/addManager.php?msg=$msg&f");   
        die();
    }

    header("location: ../../pages/user/viewManagers.php?msg=$msg&f"); 
