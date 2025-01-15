<?php
    SESSION_START();
    if(isset($_SESSION['user_id'])){ 
        if($_SESSION['user_role'] == "ADMIN") {
            header('location: ../../pages/user/dashboard.php'); 
        }else{
            $shop = $_SESSION['manager_shop'];
            header("location: ../../pages/shop/viewShop.php?sid=$shop");
        }
    }
?>

<?php require("../../components/head.php"); ?>
<body>
    <?php require("../../components/navbar.php"); ?>
    
    <form action="../../process/auth/register.php" method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="phone" placeholder="Phone number">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="confirm_password" placeholder="Confirm Password">
        <button type="submit">Register</button>
    </form>

    <?php if(isset($_GET["msg"])) { ?>
        <p><?php echo base64_decode($_GET["msg"]); ?></p>
    <?php }; ?>
    
    <?php require("../../components/footer.php"); ?>
</body>
</html>