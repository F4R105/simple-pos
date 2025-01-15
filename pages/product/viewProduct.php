<?php 
require '../../config/databaseConnection.php';
require '../../config/errorReporting.php';

$shop = base64_decode($_GET['sid']);
$product = base64_decode($_GET['pid']);

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
    shops.shop_id = $shop AND products.product_id = $product
    GROUP BY
    products.product_id, products.name, products.sell_price, unit_purchases_subquery.price_per_item, unit_purchases_subquery.units_purchased, unit_purchases_subquery.total_buy_cost, unit_sales_subquery.units_sold;
";
$data = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($data)
?>
<body>
    <table id="productTable" border="2">
        <thead>
            <tr>
                <th>Product</th>
                <th><?php echo $product['product']; ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Buy price per unit</td>
                <td><?php echo $product['buy_price_per_unit']; ?></td>
            </tr>
            <tr>
                <td>Sell Price per unit</td>
                <td><?php echo $product['indicated_sell_price']; ?></td>
            </tr>
            <tr>
                <td>Lifetime Units purchased</td>
                <td><?php echo $product['units_purchased']; ?></td>
            </tr>
            <tr>
                <td>Lifetime Total Cost</td>
                <td><?php echo $product['total_buy_cost']; ?></td>
            </tr>
            <tr>
                <td>~ Units sold</td>
                <td><?php echo $product['units_sold']; ?></td>
            </tr>
            <tr>
                <td>~ Total Sales</td>
                <td><?php echo $product['total_sell_cost']; ?></td>
            </tr>
            <tr>
                <td>~ Profit</td>
                <td><?php echo $product['profit']; ?></td>
            </tr>
            <tr>
                <td>Units remained</td>
                <td><?php echo $product['units_remained']; ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>