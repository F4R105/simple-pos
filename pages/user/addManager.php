<?php
    SESSION_START();
    if(!isset($_SESSION['user_id'])){ header('location: ../../pages/auth/login.php'); }

    require_once "../../config/errorReporting.php";
    require_once "../../config/databaseConnection.php";
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $owner = $_SESSION['user_id'];
    $query = "SELECT 
        * 
        FROM shops 
        LEFT JOIN managers ON shops.shop_id = managers.shop 
        WHERE owner = $owner";
    $fetch_shops = mysqli_query($conn, $query);

?>

<?php require "../../components/head.php"; ?>
<body>
    <?php require "../../components/navbar.php"; ?>
    
    <form action="../../process/user/addManager.php" method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="phone" placeholder="Phone number">
        <select name="shop">
            <option value="">Choose shop</option>
            <?php while($shop = mysqli_fetch_assoc($fetch_shops)){ ?>
                <?php if(!$shop['manager']){ ?>
                    <option value="<?php echo $shop['shop_id']; ?>"><?php echo $shop['name']; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
        <button type="submit">Add manager</button>
    </form>

    <?php if(isset($_GET["msg"])) { ?>
        <p><?php echo base64_decode($_GET["msg"]); ?></p>
    <?php }; ?>
    
    <?php require "../../components/footer.php"; ?>
</body>
</html>