<?php
    SESSION_START();
    require_once("../../config/errorReporting.php");
    require_once("../../config/databaseConnection.php");
    date_default_timezone_set('Africa/Dar_es_Salaam');
    $user_id = $_SESSION['user_id'];

    if(isset($_POST["user_info"])){
        $username = mysqli_real_escape_string($conn, $_POST["username"]);

        // IF IT IS ADMIN
        if(isset($_POST["name"])){
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
            $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
        
            $query = "UPDATE users SET username = '$username', name = '$name', phone = '$phone' WHERE user_id = '$user_id'";
            $update_info = mysqli_query($conn, $query);

            if(!$update_info){
                $msg = base64_encode('failed to update info');
                header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
                die();
            }
            
            $msg = base64_encode('Successfully updated');
            header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
        }

        $query = "UPDATE users SET username = '$username' WHERE user_id = '$user_id'";
        $update_info = mysqli_query($conn, $query);

        if(!$update_info){
            $msg = base64_encode('failed to update info');
            header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
            die();
        }
        
        $msg = base64_encode('Successfully updated');
        header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
    }

    if(isset($_POST["user_password"])){
        $password = $_POST['password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // VALIDATE EMPTY FIELDS
        if(empty($password) || empty($new_password) || empty($confirm_password)){ 
            $msg = base64_encode('all password fields are required');
            header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
            die();
        };

        // CONFIRM PASSWORD TYPED
        if($new_password !== $confirm_password){ 
            $msg = base64_encode('new and confirm password are not the same');
            header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
            die();
        };

        // GET USER HASHED PASSWORD
        $query = "SELECT * FROM users WHERE user_id = '$user_id'";
        $data = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($data);
    
        // Validate user availability
        if($rows === 0){ 
            $msg = base64_encode('wrong username or password');
            header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
            die();
        };

        $user = mysqli_fetch_array($data);
        $db_password = $user['password'];
    
        // VALIDATE OLD PASSWORD
        if(!password_verify($password, $db_password)){ 
            $msg = base64_encode('wrong username or password');
            header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
            die();
        };
    
        // UPDATE PASSWORD
        $hashed_password = password_hash(mysqli_real_escape_string($conn,$new_password), PASSWORD_DEFAULT);

        $query = "UPDATE users SET `password` = '$hashed_password' WHERE user_id = '$user_id'";
        $update_password = mysqli_query($conn, $query);

        if(!$update_password){
            $msg = base64_encode('failed to update password');
            header("location: ../../pages/user/editUser.php?msg=$msg&f"); 
            die();
        }

        header("location: ../../process/auth/logout.php");

    }