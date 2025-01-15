<nav>
    <a href="#"><h1>Simple POS</h1></a>
    <ul>
        <li>About us</li>
        <?php if($_SESSION['user_role'] == "ADMIN"){ ?>
            <li>
                <a href="../../pages/user/dashboard.php">Dashboard</a>
            </li>
            <li>
                <a href="../../pages/user/viewManagers.php">Managers</a>
            </li>
            <li>
                <a href="../../pages/shop/viewShops.php">Shops</a>
            </li>
        <?php } ?>
        <?php if(isset($_SESSION['user_id'])){ ?>
            <li>
                <a href="../../pages/user/editUser.php">
                <?php 
                    $user = $_SESSION['user_id'];
                    $query = "SELECT `name` FROM users WHERE user_id = $user";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_array($result);
                    $name = $row["name"];
                    echo $name;
                ?>
                </a>
            </li>
            <li><a href="../../process/auth/logout.php">Logout</a></li>
        <?php } ?>
    </ul>
</nav>