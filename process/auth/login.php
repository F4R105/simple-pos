<?php
    require_once("../../config/errorReporting.php");
    require_once("../../config/databaseConnection.php");
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $data = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($data);

    if($rows === 0){ 
        $msg = base64_encode('wrong username or password');
        header("location: ../../pages/auth/login.php?msg=$msg&f"); 
        die();
    };

    $user = mysqli_fetch_array($data);
    $db_password = $user['password'];

    if(!password_verify($password, $db_password)){ 
        $msg = base64_encode('wrong username or password');
        header("location: ../../pages/auth/login.php?msg=$msg&f"); 
        die();
    };

    $user_role = $user['role'];
    if($user_role == "ADMIN"){
        SESSION_START();
        $user_id = $user['user_id'];
        $_SESSION["user_id"] = $user_id;
        $_SESSION["user_role"] = $user_role;
        header("location: ../../pages/user/dashboard.php?msg=$msg&f");
    }else{
        // GET MANAGER'S SHOP FOR REDIRECTION
        $user_id = $user['user_id'];
        $query = "SELECT * FROM managers WHERE manager = '$user_id'";
        $fetch_manager = mysqli_query($conn, $query);
        $manager = mysqli_fetch_assoc( $fetch_manager );
        $shop = base64_encode($manager['shop']);

        SESSION_START();
        $_SESSION["user_id"] = $user_id;
        $_SESSION["user_role"] = $user_role;
        $_SESSION["manager_shop"] = $shop;
        header("location: ../../pages/shop/viewShop.php?sid=$shop");
    }
