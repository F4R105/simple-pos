<?php
    $product_id = base64_decode($_GET['pid']);
    $shop_id = base64_decode($_GET['sid']);
?>

<?php require "../../components/head.php"; ?>
<body>
<?php require "../../components/navbar.php"; ?>
    <form action="../../process/product/buyProduct.php" method="POST">
        <div>
            <label for="price">Price per unit</label>
            <input type="number" name="price" id="price" required>
        </div>

        <div>
            <label for="items">Number of units bought</label>
            <input type="number" name="items" id="items" required>
        </div>

        <input type="hidden" name="product" value="<?php echo $product_id; ?>" required>
        <input type="hidden" name="shop" value="<?php echo $shop_id; ?>" required>

        <button type="submit">Buy Product</button>
    </form>

    <?php if(isset($_GET["msg"])) { ?>
        <p><?php echo base64_decode($_GET["msg"]); ?></p>
    <?php }; ?>
    
<?php require "../../components/footer.php"; ?>
</body>
</html>