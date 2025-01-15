<?php
    SESSION_START();
    if(!isset($_SESSION['user_id'])){ header('location: ../../pages/auth/login.php'); }

    require '../../config/databaseConnection.php';
    require '../../config/errorReporting.php';

    $manager = base64_decode($_GET['id']);
    $sql = "SELECT * FROM `managers` LEFT JOIN users ON managers.manager = users.user_id WHERE manager = $manager";
    $fetch_manager = mysqli_query($conn, $sql);
    $manager = mysqli_fetch_assoc($fetch_manager);

?>

<?php require("../../components/head.php"); ?>
<body>
    <?php require("../../components/navbar.php"); ?>
    <h1><?php echo $manager['name']; ?></h1>
    <p>Phone: <?php echo $manager['phone']; ?></p>

    <?php require("../../components/footer.php"); ?>
</body>
</html>