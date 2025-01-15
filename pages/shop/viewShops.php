<?php
    SESSION_START();
    if(!isset($_SESSION['user_id'])){ header('location: ../../pages/auth/login.php'); }
    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == "MANAGER") {
        $shop = $_SESSION['manager_shop'];
        header("location: ../../pages/shop/viewShop.php?sid=$shop");
        die();
    }

    require '../../config/databaseConnection.php';
    require '../../config/errorReporting.php';

    $owner = $_SESSION['user_id'];
    $sql = "SELECT 
    shop_id,
    shops.name AS shop,
    users.name AS manager,
    users.user_id AS manager_id
    FROM shops
    LEFT JOIN managers ON shops.shop_id = managers.shop
    LEFT JOIN users ON managers.manager = users.user_id
    WHERE `owner` =  $owner";
    $fetch_shops = mysqli_query($conn, $sql);

?>

<?php require "../../components/head.php"; ?>
<body>
    <?php require "../../components/navbar.php"; ?>
    <h1>My shops</h1>

    <a href="./addShop.php">Add new shop</a>

    <table border="2">
        <thead>
            <th>Shop Name</th>
            <th>Manager</th>
            <th colspan="2">Actions</th>
        </thead>
        <tbody>
        <?php while($shop = mysqli_fetch_assoc($fetch_shops)){ ?>
            <tr>
                <td><?php echo $shop['shop']; ?></td>
                <td>
                <?php if($shop['manager']){ ?>
                    <a href="../../pages/user/viewManager.php?id=<?php echo base64_encode($shop['manager_id']); ?>"><?php echo $shop['manager']; ?></a>
                <?php }else{ echo "Not assigned"; } ?></td>
                <td><a href="../../process/shop/deleteShop.php?sid=<?php echo base64_encode($shop['shop_id']); ?>">Delete</a></td>
                <td><a href="./viewShop.php?sid=<?php echo base64_encode($shop['shop_id']); ?>">View</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <?php require "../../components/footer.php"; ?>
</body>
</html>