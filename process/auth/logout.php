<?php

    SESSION_START();    
    SESSION_DESTROY();
    UNSET($_SESSION['user_id']);
    UNSET($_SESSION["user_role"]);
    UNSET($_SESSION["manager_shop"]);

    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
        header("location: ../../pages/auth/login.php?msg=$msg");
    }

    header("location: ../../pages/auth/login.php");
