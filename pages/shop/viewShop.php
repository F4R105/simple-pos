<?php
    SESSION_START();
    if(!isset($_SESSION['user_id'])){ header('location: ../../pages/auth/login.php'); }

    require '../../config/databaseConnection.php';
    require '../../config/errorReporting.php';

    $sid = base64_decode($_GET['sid']);
    $sql = "SELECT 
        shops.name AS shop,
        users.name AS manager
    FROM `shops` 
    LEFT JOIN managers ON shops.shop_id = managers.shop
    LEFT JOIN users ON managers.manager = users.user_id
    WHERE shop_id = $sid";
    $fetch_shops = mysqli_query($conn, $sql);
    $shop = mysqli_fetch_assoc($fetch_shops);

?>

<?php require "../../components/head.php"; ?>
<body>
    <?php require "../../components/navbar.php"; ?>
    <h1><?php echo $shop['shop']; ?></h1>
    <p>Manager: <?php if($shop['manager']) { echo $shop['manager']; } else { echo "Not assigned"; } ?></p>

    <a href="../product/viewProducts.php?sid=<?php echo $_GET['sid']; ?>">View products</a>

    <?php require "../../components/footer.php"; ?>
</body>
</html>