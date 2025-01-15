<?php require("./components/head.php"); ?>
<body>
    <?php require("./components/navbar.php"); ?>
    <h1>Welcome to BiasharaNasi</h1>

    <a href="./pages/auth/login.php">Login</a>
    <a href="./pages/auth/register.php">Register</a>

    <div>
        <h3>How to</h3>
        <ul>
            <li>Register (Become admin/owner of shops)</li>
            <li>Add shops</li>
            <li>Add products to shops <b>NOTE:</b> Indicate price to be sold</li>
            <li>Add/Assign managers to shops</li>
            <li>Buy products</li>
            <li>Logout</li>
            <li>Login as manager (default password: 1234)</li>
            <li>Sell products</li>
            <li>Logout</li>
            <li>Login as admin</li>
            <li>View shop details (sales, profit etc)</li>
        </ul>
    </div>
    <?php require("./components/footer.php"); ?>
</body>
</html>