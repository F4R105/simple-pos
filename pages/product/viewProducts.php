<?php

require '../../config/databaseConnection.php';
require '../../config/errorReporting.php';

SESSION_START();
$role = $_SESSION['user_role'];
$shop = base64_decode($_GET['sid']);

// PAGINATION LOGIC STARTS
$productsPerPage = 2;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
$sql = "SELECT * FROM products WHERE shop = $shop";
$data = mysqli_query($conn, $sql);
$noOfProducts = mysqli_num_rows($data);
$noOfPages = round($noOfProducts / $productsPerPage);
$nextPage = $page >= $noOfPages ? $noOfPages : $page + 1;
$prevPage = $page - 1;
$offset = ($page - 1) * $productsPerPage;
// PAGINATION LOGIC ENDS

$sql = "SELECT
    product_id,
    products.name AS product,
    COALESCE(unit_purchases_subquery.price_per_item, 0) AS buy_price_per_unit,
    products.sell_price AS indicated_sell_price,
    COALESCE(unit_purchases_subquery.units_purchased, 0) AS units_purchased,
    COALESCE(unit_purchases_subquery.total_buy_cost, 0) AS total_buy_cost,
    COALESCE(unit_sales_subquery.total_sell_cost, 0) AS total_sell_cost,
    COALESCE(unit_sales_subquery.units_sold, 0) AS units_sold,
    COALESCE(unit_purchases_subquery.units_purchased - unit_sales_subquery.units_sold, 0) AS units_remained,
    COALESCE(unit_sales_subquery.total_sell_cost - unit_purchases_subquery.total_buy_cost, 0) AS profit
    FROM
    products
    LEFT JOIN (
    SELECT
        product,
        SUM(items) AS units_purchased,
        price_per_item,
        SUM(items * price_per_item) AS total_buy_cost,
        `time` AS purchase_time
    FROM
        unit_purchases
    GROUP BY
        product, price_per_item
    ) unit_purchases_subquery ON products.product_id = unit_purchases_subquery.product
    LEFT JOIN (
    SELECT
        product,
        SUM(units) AS units_sold,
        price_per_unit,
        SUM(units * price_per_unit) AS total_sell_cost,
        `time` AS sale_time
    FROM
        unit_sales
    GROUP BY
        product
    ) unit_sales_subquery ON products.product_id = unit_sales_subquery.product
    LEFT JOIN shops ON products.shop = shops.shop_id
    WHERE
    shops.shop_id = $shop
    GROUP BY
    products.product_id, products.name, products.sell_price, unit_purchases_subquery.price_per_item, unit_purchases_subquery.units_purchased, unit_purchases_subquery.total_buy_cost, unit_sales_subquery.units_sold
    LIMIT $offset,$productsPerPage;
";
$data = mysqli_query($conn, $sql);

if (!$data) {
    header('location: ./errorPage.php');
}

?>
<?php require "../../components/head.php"; ?>
<body>
<?php require "../../components/navbar.php"; ?>

<?php if(isset($_GET["msg"])) { ?>
    <p><?php echo base64_decode($_GET["msg"]); ?></p>
<?php }; ?>

<h2>Product List</h2>
    <?php if ($role == "ADMIN") { ?>  
        <form action="../../pages/product/searchResults.php" method="post">
            <input type="text" name="query">
            <input type="hidden" name="shop" value="<?php echo $shop; ?>">
            <button type="submit">Search</button>
        </form>
        <a href="./addProduct.php?sid=<?php echo base64_encode($shop); ?>">Add new product</a>
        <div>
            <select name="" id="">
                <option value="">Order</option>
                <option value="">Date added</option>
                <option value="">Profit (High to Low)</option>
                <option value="">Profit (Low to Hight)</option>
                <option value="">Units remained (High to Low)</option>
                <option value="">Units remained (Low to high)</option>
            </select>
            <select name="" id="">
                <option value="">Filter</option>
                <option value="">Zero units</option>
                <option value="">Loss</option>
                <option value="">Profit</option>
                <option value=""></option>
            </select>
        </div>
        <div>
            <a href="./viewProducts.php?sid=<?php echo $_GET['sid']; ?>&page=<?php echo $prevPage; ?>">Prev</a>
            <span><?php echo $page;echo "/"; echo $noOfPages; ?></span>
            <a href="./viewProducts.php?sid=<?php echo $_GET['sid']; ?>&page=<?php echo $nextPage; ?>">Next</a>
        </div>
        <table id="productTable" border="2">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Buy price per unit</th>
                    <th>Sell Price per unit</th>
                    <th>Lifetime Units purchased</th>
                    <th>Lifetime Total Cost</th>
                    <th>~ Units sold</th>
                    <th>~ Total Sales</th>
                    <th>~ Profit</th>
                    <th>Units remained</th>
                    <th colspan="3">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($product = mysqli_fetch_assoc($data)) { ?>
                <tr>
                    <td><a href="../../pages/product/viewProduct.php?pid=<?php echo base64_encode($product['product_id']); ?>&sid=<?php echo base64_encode($shop); ?>"><?php echo $product['product']; ?></a></td>
                    <td><?php echo $product['buy_price_per_unit']; ?></td>
                    <td><?php echo $product['indicated_sell_price']; ?></td>
                    <td><?php echo $product['units_purchased']; ?></td>
                    <td><?php echo $product['total_buy_cost']; ?></td>
                    <td><?php echo $product['units_sold']; ?></td>
                    <td><?php echo $product['total_sell_cost']; ?></td>
                    <td><?php echo $product['profit']; ?></td>
                    <td><?php echo $product['units_remained']; ?></td>
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
            <a href="./viewProducts.php?sid=<?php echo $_GET['sid']; ?>&page=<?php echo $prevPage; ?>">Prev</a>
            <span><?php echo $page;echo "/"; echo $noOfPages; ?></span>
            <a href="./viewProducts.php?sid=<?php echo $_GET['sid']; ?>&page=<?php echo $nextPage; ?>">Next</a>
        </div>
    <?php } else { ?> 
            <form action="../../pages/product/searchResults.php" method="post">
                <input type="text" name="query">
                <input type="hidden" name="shop" value="<?php echo $shop; ?>">
                <button type="submit">Search</button>
            </form>
            <table id="productTable" border="2">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Sell Price</th>
                    <th>Lifetime Unit sold</th>
                    <th>Unit remained</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($product = mysqli_fetch_assoc($data)) { ?>
                <?php if($product['units_purchased'] &&  ($product['units_remained'] > 0)){ ?>
                <tr>
                    <td><?php echo $product['product']; ?></td>
                    <td><?php echo $product['indicated_sell_price']; ?></td>
                    <td><?php echo $product['units_sold']; ?></td>
                    <td><?php echo $product['units_remained']; ?></td>
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

    <!-- Modal for Sell Product -->
    <div id="sellModal" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid black;">
        <h2>Sell Product</h2>
        <div class="form-group">
            <label for="modalNoSellProduct">No. of Sold Products:</label>
            <input type="number" id="modalNoSellProduct" required>
        </div>
        <div class="form-group">
            <label for="modalAdjustment">Adjustment:</label>
            <input type="number" id="modalAdjustment">
        </div>
        <button id="confirmSellButton">Confirm</button>
        <button id="closeModalButton">Close</button>
    </div>
    <?php require("../../components/footer.php"); ?>
</body>
</html>