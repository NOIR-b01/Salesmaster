<?php
session_start();
ob_start();
include('constant.php');
if ($status == 0) {
    header('location: login.php');
}
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}

if (!isset($_SESSION["salesid"])) {
    $_SESSION["salesid"] = rand();
}

if (isset($_GET["delete"])) {
    $sn =  $_GET["delete"];
    $sql = $db->query("DELETE FROM item WHERE sn = '$sn'");
    if ($sql) { //Alert('Successfully deleted');
    } else { //Alert('Error deleting data',0);
    }
}


if (isset($_GET['edit'])) {
    $sn = $_GET['edit'];
    $_SESSION["salesid"] = $_GET['salesid'];
    $sql = $db->query("DELETE FROM sales WHERE sn='$sn' ");
    header('location: ?');
}

$salesid = $_SESSION["salesid"];

if (array_key_exists("AddItem", $_POST)) {
    extract($_POST);

    $sql =  $db->query("INSERT INTO item (item,price,qty,amount,salesid,user,bid) VALUES ('$item','$price','$qty','$amount','$salesid','$user','$bid') ");
    if ($sql) {
        Alert('Successfully Added to cart');
    } else {
        Alert('Error Submitting data', 0);
    }
}

//PHP function

// if (isset($_POST['Empty'])) {
//     $sql = $db->query("DELETE FROM item WHERE salesid='$salesid'");
//     if ($sql) {
//         // Optionally, you can provide feedback to the user
//         Alert('Cart Emptied Successfully');
//         // Redirect or refresh after emptying the cart
//         header('Location: ?');
//         exit;
//     } else {
//         Alert('Error Emptying Cart', 0);
//     }
// }


if (array_key_exists("Checkout", $_POST)) {
    extract($_POST);
    if ($total == 0) {
        header('location: ?');
    }
    $sql =  $db->query("INSERT INTO sales (customer,phone,total,salesid,user,mode,bid) VALUES ('$customer','$phone','$total','$salesid','$user','$mode','$bid') ");

    $sq = $db->query("SELECT * FROM customer WHERE bid='$bid' AND phone = '$phone' ");
    if (mysqli_num_rows($sq) == 0) {
        $sql2 =  $db->query("INSERT INTO customer (name,phone,bid) VALUES ('$customer','$phone','$bid') ");
        //echo 'Customer added successfully<br>';
    }

    if ($sql) {
        Alert('Successfully Submitted');;
        unset($_SESSION['salesid']);
        $salesid = '';
    } else {
        Alert('Error Submitting data', 0);
    }
}

if (isset($_POST['clearAll'])) {  
    $db->query("DELETE FROM item WHERE salesid ='$salesid'");
}

// $sql = $db->query("SELECT * FROM sales ");
// while($row = mysqli_fetch_assoc($sql)){
//     $name = $row['customer']; 
//     $phone = $row['phone'];

//     $sq = $db->query("SELECT * FROM customer WHERE phone = '$phone' ");
//     if(mysqli_num_rows($sq)==0){
//     $sql2 =  $db->query("INSERT INTO customer (name,phone) VALUES ('$name','$phone') ");
//     echo 'Customer added successfully<br>';
//     }
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        /*h4{color:red; font-family:'Courier New', Courier, monospace; text-decoration:underline;}
   tr{border-color: black !important;}*/
    </style>
</head>

<body>

    <?php include('nav.php') ?>

    <div class="container mt-4">

        <div class="row">
            <div class="col-md-12">
                <h2>Point of Sale</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Add Items to Cart</h6>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="">Item</label>
                                <input type="text" class="form-control" name="item" placeholder="Item name">
                            </div>
                            <div class="form-group">
                                <label for="">price</label>
                                <input type="number" class="form-control" id="price" name="price" onkeyup="document.getElementById('amount').value = this.value * document.getElementById('qty').value;" placeholder="Enter price" required>
                            </div>
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="number" class="form-control" id="qty" name="qty" onkeyup="document.getElementById('amount').value = this.value * document.getElementById('price').value;" placeholder="Enter Qty" required>
                            </div>
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="number" class="form-control" id="amount" onkeyup="this.value = document.getElementById('qty').value * document.getElementById('price').value;" name="amount" placeholder="Enter Amount">
                            </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <div style="float:right">
                                <button type="submit" class="btn btn-primary btn-block" name="AddItem">Add Item to Cart</button>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>

            </div>





            <div class="col-md-6">
                <form method="post">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Cart</h6>
                                    <!-- <button class="btn btn-danger" name="clearall">Clear All</button> -->
                                </div>
                <div class="col-md-6">
                   <button name="clearAll" class="btn btn-danger" style="float:right;">Clear All</button>
                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="cart-items" class="table">
                                <tr>
                                    <th>Qty</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>

                                <?php $total  = 0;
                                $sql = $db->query("SELECT * FROM item WHERE bid='$bid' AND salesid='$salesid'");
                                while ($row = $sql->fetch_assoc()) {
                                    $total += $row["amount"];
                                    $delete  = 'href="?delete=' . $row["sn"] . '"';
                                    echo "<tr><td>" . $row["qty"] . "</td><td>" . $row["item"] . "</td><td>" . number_format($row["price"]) . "</td><td>" . number_format($row["amount"]) . "</td><td><a " . $delete . ">Remove</a></td></tr>";
                                }
                                echo '<tr><th colspan="3">Grand Total</th><th>' . number_format($total) . '</th><th></th></tr>';
                                ?>
                            </table>
                            <input type="hidden" name="total" value="<?= $total ?>">
                            <label for="">Mode of Payment</label>
                            <select class="form-control" name="mode">
                                <option value="">Select Option...</option>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                                <option value="pos">POS</option>
                            </select><br>
                            <label for="">Customer Name</label>
                            <input type="text" class="form-control" name="customer"><br>
                            <label for="">Customer Phone Number</label>
                            <input type="number" class="form-control" name="phone"><br>
                        </div>
                        <div class="card-footer">

                            <div style="float:right">
                                <button type="submit" class="btn btn-primary btn-block" name="Checkout">Complete Checkout</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>


        </div>

        <div class="row">
            <div class="col-md-12 pt-4 pb-5">
                <div class="card">
                    <div class="card-header">
                        <h6>Recent Transactions</h6>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table">
                            <tr>
                                <th>SN</th>
                                <th>Customer</th>
                                <th>Customer phone</th>
                                <th>Total Amount</th>
                                <th>Payment Mode</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            <?php $i = 1;
                            $sql = $db->query("SELECT * FROM sales WHERE bid='$bid' AND user='$user' ORDER BY sn DESC LIMIT 20");
                            while ($row = mysqli_fetch_assoc($sql)) {
                                $e = $i++ ?>
                                <tr>
                                    <td><?= $e ?></td>
                                    <td><?= $row['customer'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td><strike>N</strike><?= number_format($row['total']) ?></td>
                                    <td><?= $row['mode'] ?></td>
                                    <td><?= substr($row['created'], 0, 10) ?></td>
                                    <td><a class="btn btn-sm btn-info" href="receipt.php?salesid=<?= $row['salesid'] ?>">Receipt</a>

                                        <?php if ($e == 1 && substr($row['created'], 0, 10) == date('Y-m-d')) { ?><a style="margin-left: 10px" href="?edit=<?= $row['sn'] ?>&salesid=<?= $row['salesid'] ?>" class="btn btn-sm btn-primary">Edit</a><?php } ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

        <script>
            let emptyCart = document.getElementById("empty-cart");
            let cartItems = document.getElementById("cart-items");

            let emptyAction = () => {
                // Assuming you might want to confirm before emptying the cart
                if (confirm('Are you sure you want to empty the cart?')) {
                    // You can optionally do more here, such as showing a loading spinner
                    // Send an AJAX request to inform PHP to empty the cart
                    fetch('sales.php', {
                            method: 'POST',
                            body: new URLSearchParams('Empty=1'),
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                // Handle success (maybe refresh the page or update UI)
                                location.reload(); // Refresh the page after successful emptying
                            } else {
                                // Handle errors
                                console.error('Failed to empty cart');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }
        </script>

        <script src="js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript">
            const toastTrigger = document.getElementById('liveToastBtn')
            const toastLiveExample = document.getElementById('liveToast')
        </script>
</body>

</html>