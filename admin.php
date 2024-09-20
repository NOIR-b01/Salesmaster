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
if ($admin != 1) {
    header('location: login.php');
    exit;
}

$salesid = $_SESSION["salesid"];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        /*h4{color:red; font-family:'Courier New', Courier, monospace; text-decoration:underline;}
   tr{border-color: black !important;}*/
    </style>
</head>

<body>

    <?php include('nav2.php') ?>


    <div class="container mt-4">
    <div class="app-content-header"> <!--begin::Container-->   
<div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                        <div class="col-sm-6">
                        <h2 class="mb-0">Admin Page</h2>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Dashboard
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
</div> <!--end::Container-->
</div> <!--end::App Content Header--> <!--begin::App Content-->
        <div class="row">
            <div class="col-md-12">
                <h2></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 pt-4 pb-5">
                <div class="card">
                    <div class="card-header">
                        <h6>Ongoing Transactions</h6>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table">
                            <tr>
                                <th>Agent</th>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            <?php $total  = 0;
                            $sql = $db->query("SELECT * FROM item WHERE bid='$bid' ORDER BY sn DESC LIMIT 50");
                            while ($row = $sql->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $sales->User($row['user']) ?></td>
                                    <td><?= $row['item'] ?></td>
                                    <td><?=number_format($row['price']) ?></td>
                                    <td><?= $row['qty'] ?></td>
                                    <td><?= number_format($row["amount"]) ?></td>
                                    <td style=<?php if ($row['status'] == 0) {
                                        echo "color:red";
                                    } elseif ($row['status'] == 1) {
                                        echo "color:blue";
                                    } else {
                                        echo "color:green";
                                    }
                                     ?>><?php status($row['status']) ?></td>
                                    <td><?= substr($row['created'], 0, 10) ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript">
            const toastTrigger = document.getElementById('liveToastBtn')
            const toastLiveExample = document.getElementById('liveToast')
        </script>
</body>

</html>