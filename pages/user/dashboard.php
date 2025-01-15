<?php
    SESSION_START();
    if(!isset($_SESSION['user_id'])){ header('location: ../../pages/auth/login.php'); }
    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == "MANAGER") {
        $shop = $_SESSION['manager_shop'];
        header("location: ../../pages/shop/viewShop.php?sid=$shop");
        die();
    }

    require_once("../../config/errorReporting.php");
    require_once("../../config/databaseConnection.php");
    date_default_timezone_set('Africa/Dar_es_Salaam');

    $user_id = $_SESSION['user_id'];
    $query = "SELECT name FROM users WHERE user_id = $user_id";
    $fetch_user = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc(( $fetch_user));
    $name = $user["name"];
?>

<?php require("../../components/head.php"); ?>
<body>
    <?php require("../../components/navbar.php"); ?>
    <h1>Welcome <?php echo $name; ?> | Dashboard</h1>

    <a href="../shop/viewShops.php">View shops</a>
    <a href="./viewManagers.php">View managers</a>

    <?php require("../../components/footer.php"); ?>
</body>
</html>