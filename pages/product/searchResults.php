<?php
require '../../config/databaseConnection.php';
require '../../config/errorReporting.php';

    SESSION_START();
    $role = $_SESSION['user_role'];
    $searchQuery = $_POST['query'];
    $shop = $_POST['shop'];

    // PAGINATION LOGIC STARTS
    $productsPerPage = 2;
    $page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
    $sql = "SELECT * FROM products WHERE shop = $shop AND `name` LIKE '%$searchQuery%'";
    $data = mysqli_query($conn, $sql);
    $noOfProducts = mysqli_num_rows($data);
    $noOfPages = round($noOfProducts / $productsPerPage);
    $nextPage = $page >= $noOfPages ? $noOfPages : $page + 1;
    $prevPage = $page - 1;
    $offset = ($page - 1) * $productsPerPage;
    // PAGINATION LOGIC ENDS


?>

<?php require "../../components/head.php"; ?>
<body>
<?php require "../../components/navbar.php"; ?>
    <h2>Search results</h2>
    <p><?php echo $noOfProducts; ?> results found.</p>
    <?php if ($role == "ADMIN") { ?>  
        <div>
            <a href="./viewProducts.php?page=<?php echo $prevPage; ?>">Prev</a>
            <span><?php echo $page;echo "/"; echo $noOfPages; ?></span>
            <a href="./viewProducts.php?page=<?php echo $nextPage; ?>">Next</a>
        </div>
        <table id="productTable" border="2">
            <thead>
                <tr>
                    <th>Product</th>
                    <th colspan="3">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($product = mysqli_fetch_assoc($data)) { ?>
                <tr>
                    <td><a href="../../pages/product/viewProduct.php?pid=<?php echo base64_encode($product['product_id']); ?>&sid=<?php echo base64_encode($shop); ?>"><?php echo $product['name']; ?></a></td>
                    <td>
                        <a href="../../pages/product/buyProduct.php?pid=<?php echo base64_encode($product['product_id']); ?>&sid=<?php echo base64_encode($shop); ?>">Buy</a>
                    </td>
                    <td>
                        <a href="../../pages/product/editProduct.php?pid=<?php echo base64_encode($product['product_id']); ?>&sid=<?php echo base64_encode($shop); ?>">Update sell price</a>
                    </td>
                    <td>
                        <a href="../../process/product/deleteProduct.php?pid=<?php echo base64_encode($product['product_id']); ?>&sid=<?php echo base64_encode($shop); ?>">Delete</a>
                    </td>
                </tr>
            <?php }
            ; ?>
            </tbody>
        </table>
        <div>
            <a href="./viewProducts.php?page=<?php echo $prevPage; ?>">Prev</a>
            <span><?php echo $page;echo "/"; echo $noOfPages; ?></span>
            <a href="./viewProducts.php?page=<?php echo $nextPage; ?>">Next</a>
        </div>
    <?php } else { ?> 
            <table id="productTable" border="2">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($product = mysqli_fetch_assoc($data)) { ?>
                <?php if($product['units_purchased'] &&  ($product['units_remained'] > 0)){ ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td>
                        <a href="../../pages/product/sellProduct.php?sid=<?php echo base64_encode($shop); ?>&pid=<?php echo base64_encode($product['product_id']); ?>&sell=<?php echo base64_encode($product['indicated_sell_price']); ?>&max=<?php echo base64_encode($product['units_remained']); ?>">Sell</a>
                    </td>
                </tr>
                <?php } ?>
            <?php }
            ; ?>
            </tbody>
        </table>
    <?php } ?>
</body>