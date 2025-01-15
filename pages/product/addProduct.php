<?php require("../../components/head.php"); ?>
<body>
<?php require("../../components/navbar.php"); ?>
<form action="../../process/product/addProduct.php" method="POST">
        <div>
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div>
            <label for="price">Sell Price:</label>
            <input type="number" name="price" id="price" required>
        </div>

        <input type="hidden" name="shop" id="shop" value="<?php echo base64_decode($_GET['sid']); ?>" required>

        <button type="submit">Add Product</button>
    </form>

    <?php if(isset($_GET["msg"])) { ?>
        <p><?php echo base64_decode($_GET["msg"]); ?></p>
    <?php }; ?>
    
    <?php require("../../components/footer.php"); ?>
</body>
</html>