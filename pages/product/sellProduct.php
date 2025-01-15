<?php
    $product_id = base64_decode($_GET['pid']);
    $shop_id = base64_decode($_GET['sid']);
    $remained = base64_decode($_GET['max']);
?>

<?php require "../../components/head.php"; ?>
<body>
<?php require "../../components/navbar.php"; ?>
    <p>Indicated sell price is Tsh <?php echo base64_decode($_GET['sell']); ?>/=</p>
    <form action="../../process/product/sellProduct.php" method="POST">
        <div>
            <label for="price">Price per item</label>
            <input type="number" name="price" id="price" required>
        </div>

        <div>
            <label for="items">Number of items sold</label>
            <input type="number" name="items" id="items" max="<?php echo $remained; ?>" required>
        </div>

        <input type="hidden" name="product" value="<?php echo $product_id; ?>" required>
        <input type="hidden" name="shop" value="<?php echo $shop_id; ?>" required>

        <button type="submit">Sell Product</button>
    </form>

    <?php if(isset($_GET["msg"])) { ?>
        <p><?php echo base64_decode($_GET["msg"]); ?></p>
    <?php }; ?>
    
<?php require "../../components/footer.php"; ?>
</body>
</html>