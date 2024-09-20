<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="navbar navbar-expand-sm">
            <a class="navbar-brand" href="#"> <strong><?php if (isset($_COOKIE['biztitle'])) {
                                                            echo strtoupper($_COOKIE['biztitle']);
                                                        } ?></strong></a>
            <ul class="navbar-nav ms-auto">
            <a href="#" class="nav-link">
                        <?= $name ?></a>
                    <?php if ($admin == 1) { ?>

                <li class="nav-item">
                    <a href="sales.php" class="nav-link">POS</a>
                </li>
                <li class="nav-item">
                    <a href="categories.php" class="nav-link">Categories</a>
                </li> 
                <li class="nav-item">
                    <a href="transactions.php" class="nav-link">Transactions</a>
                </li>
                <li class="nav-item">
                    <a href="admin.php" class="nav-link">Track</a>
                </li>
                <li class="nav-item">
                    <a href="Product.php" class="nav-link">Store</a>
                </li>
                <li class="nav-item">
                    <a href="user.php" class="nav-link">Users</a>
                    </li>
                </li><?php } ?>
            </ul>
        </div>
    </div>
    </div>
</body>

</html>