<?php
    SESSION_START();
    if(!isset($_SESSION['user_id'])){ 
        header('location: ../../pages/auth/login.php'); 
    }

    require_once "../../config/errorReporting.php";
    require_once "../../config/databaseConnection.php";
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    $username = $user["username"];
    $name = $user['name'];
    $phone = $user['phone'];
?>

<?php require "../../components/head.php"; ?>
<body>
    <?php require "../../components/navbar.php"; ?>
    
    <p>Info</p>
    <form action="../../process/user/editUser.php" method="POST">
        <input type="text" name="username" value="<?php echo $username; ?>">
        <?php if($_SESSION['user_role'] == "ADMIN"){ ?>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <input type="text" name="phone" value="<?php echo $phone; ?>">
        <?php } ?>
        <button type="submit" name="user_info">Update</button>
    </form>

    <p>Password</p>
    <form action="../../process/user/editUser.php" method="POST">
        <input type="password" name="password" placeholder="Current password">
        <input type="password" name="new_password" placeholder="New password">
        <input type="password" name="confirm_password" placeholder="Confirm new password">
        <button type="submit" name="user_password">Update</button>
    </form>

    <?php if($_SESSION['user_role'] == "ADMIN"){ ?>
    <p>Account</p>
    <form action="../../process/user/deleteUser.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <button type="submit" name="delete_account" style="background-color: red; color: white;">Delete my account</button>
    </form>
    <?php } ?>

    <?php if(isset($_GET["msg"])) { ?>
        <p><?php echo base64_decode($_GET["msg"]); ?></p>
    <?php }; ?>
    
    <?php require "../../components/footer.php"; ?>
</body>
</html>