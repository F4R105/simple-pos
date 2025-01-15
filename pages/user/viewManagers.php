<?php

    SESSION_START();
    if(!isset($_SESSION['user_id'])){ header('location: ../../pages/auth/login.php'); }

    require '../../config/databaseConnection.php';
    require '../../config/errorReporting.php' ;

    $owner = $_SESSION['user_id'];
    $query = "SELECT
    shop_id, 
    managers.manager AS manager_id,
    shops.name AS shop,
    users.name AS manager,
    phone
    FROM managers 
    JOIN shops ON managers.shop = shops.shop_id
    JOIN users ON managers.manager = users.user_id
    WHERE owner = $owner";
    $fetch_managers = mysqli_query($conn, $query);

?>
<?php require("../../components/head.php"); ?>
<body>
<?php require("../../components/navbar.php"); ?>

<?php if(isset($_GET["msg"])) { ?>
    <p><?php echo base64_decode($_GET["msg"]); ?></p>
<?php }; ?>

<h2>Managers</h2>
    <a href="./addManager.php">Add new manager</a>
    <table id="productTable" border="2">
        <thead>
            <tr>
                <th>Manager</th>
                <th>Shop</th>
                <th>Phone</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($manager = mysqli_fetch_assoc($fetch_managers)){ ?>
            <tr>
                <td><?php echo $manager['manager']; ?></td>
                <td><a href="../../pages/shop/viewShop.php?sid=<?php echo base64_encode($manager['shop_id']); ?>"><?php echo $manager['shop']; ?></a></td>
                <td><?php echo $manager['phone']; ?></td>
                <td>
                    <a href="./viewManager.php?id=<?php echo base64_encode($manager['manager_id']); ?>">View</a>
                </td>
                <td>
                    <a href="#?id=<?php echo base64_encode($manager['manager_id']); ?>">Edit</a>
                </td>
                <td>
                    <a href="../../process/user/deleteUser.php?id=<?php echo base64_encode($manager['manager_id']); ?>">Remove</a>
                </td>
            </tr>
        <?php }; ?>
        </tbody>
    </table>

    <?php require("../../components/footer.php"); ?>
</body>
</html>