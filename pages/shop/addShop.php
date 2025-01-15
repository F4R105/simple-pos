<?php require("../../components/head.php"); ?>
<body>
    <?php require("../../components/navbar.php"); ?>

    <form action="../../process/shop/addShop.php" method="POST">
        <input type="text" name="shop_name" placeholder="Name">
        <button type="submit">Add shop</button>
    </form>

    <?php if(isset($_GET["msg"])) { ?>
        <p><?php echo base64_decode($_GET["msg"]); ?></p>
    <?php }; ?>

    <?php require("../../components/footer.php"); ?>
</body>
</html>