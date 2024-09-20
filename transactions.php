<?php
session_start();
ob_start();
include('constant.php');
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}
if ($admin != 1) {
    header('location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Point of Sales</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
</head> <!--end::Head--> <!--begin::Body-->


<body>
<?php include('nav2.php') ?>


<div class="app-content-header"> <!--begin::Container-->   
<div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                        <div class="col-sm-6">
                        <h2 class="mb-0">Transactions</h2>
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
    <div class="container mt-4">
        <div class="row">
        </div>
        <form method="post">
            <div class="row pt-5">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>Transaction Filter</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>From:</label>
                                    <input type="date" class="form-control" name="from" placeholder="Select Date">
                                </div>
                                <div class="col-md-3">
                                    <label>To:</label>
                                    <input type="date" class="form-control" name="to" placeholder="Select Date">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Mode of Payment</label>
                                    <select class="form-control" name="mode">
                                        <option value="">All</option>
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="pos">POS</option>

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Agent</label>
                                    <select class="form-control" name="user">
                                        <option value="">All</option>

                                        <?php $sql = $db->query("SELECT * FROM user WHERE bid='$bid' ORDER BY name");
                                        while ($row = mysqli_fetch_assoc($sql)) { ?>
                                            <option value="<?= $row['sn'] ?>"><?= $row['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2"><br>
                                    <button type="submit" class="btn btn-primary" name="SearchTransaction"><i class='bx bx-search'></i> <span>Search Transaction</span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <div class="row pb-5">
            <div class="col-md-12 pt-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Sales Summary</h6>
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
                                <th>Served By</th>
                                <th>Action</th>
                            </tr>
                            <?php $i = 1;
                            $sql = $db->query("SELECT * FROM sales WHERE bid='$bid' ORDER BY sn DESC LIMIT 20");
                            if (isset($_POST['SearchTransaction'])) {
                                extract($_POST);
                                if ($user == '' and $mode == '') {
                                    $sql = $db->query("SELECT * FROM sales WHERE bid='$bid' AND created BETWEEN '$from' AND '$to' ORDER BY sn DESC");
                                } elseif ($user == '' and $mode != '') {
                                    $sql = $db->query("SELECT * FROM sales WHERE bid='$bid' AND mode='$mode' AND created BETWEEN '$from' AND '$to' ORDER BY sn DESC");
                                } elseif ($user != '' and $mode == '') {
                                    $sql = $db->query("SELECT * FROM sales WHERE bid='$bid' AND user='$user' AND created BETWEEN '$from' AND '$to' ORDER BY sn DESC");
                                } else {
                                    $sql = $db->query("SELECT * FROM sales WHERE bid='$bid' AND user='$user' AND mode='$mode' AND created BETWEEN '$from' AND '$to' ORDER BY sn DESC");
                                }
                            } elseif (isset($_GET['date'])) {
                                $date = $_GET['date'];
                                $sql = $db->query("SELECT * FROM sales WHERE bid='$bid' AND created LIKE '%$date%' ");
                            }
                            $total = 0;
                            $mdate = array();
                            $amount = array();
                            while ($row = mysqli_fetch_assoc($sql)) {
                                $e = $i++;
                                $total += $row['total'] ?>
                                <tr>
                                    <td><?= $e ?></td>
                                    <td><?= $row['customer'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td><strike>N</strike><?= number_format($row['total']) ?></td>
                                    <td><?= $row['mode'] ?></td>
                                    <td><?= substr($row['created'], 0, 10) ?></td>
                                    <td><?= $sales->User($row['user']) ?></td>
                                    <td><a class="btn btn-sm btn-info" href="receipt.php?salesid=<?= $row['salesid'] ?>"><i class='bx bxs-receipt' style="color: #ffff;" ></i></a></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="3"></th>
                                <th><strike>N</strike><?= number_format($total) ?></th>
                                <th colspan="4"></th>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        <?php $i = -7;
                        while ($i < 1) {
                            $e = $i++;
                            $time = time() + 60 * 60 * 24 * $e;
                            $date = date('jS M, Y', $time);
                            $ymd = date('ymd', $time);
                            $d = date('Y-m-d', $time);
                            $sql = $db->query("SELECT SUM(total) AS amt FROM sales WHERE bid='$bid' AND created LIKE '%$d%' ");
                            $row = mysqli_fetch_assoc($sql);

                        ?>
                            <a class="btn btn-primary" href="?date=<?= date('Y-m-d', $time) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="NGN<?= number_format($row['amt']) ?>"><?= $date ?></a>

                            <?php $mdate[] = $date; ?>
                            <?php $amount[] = number_format($row['amt']); ?>
                        <?php } ?>


                    </div>
                    <div class="card-footer">
                        <?php $i = -9;
                        while ($i < 1) {
                            $e = $i++;
                            $time = time() + 60 * 60 * 24 * 30.5 * $e;
                            $date = date('M, Y', $time);
                            $d = date('Y-m', $time);
                            $sql = $db->query("SELECT SUM(total) AS amt FROM sales WHERE bid='$bid' AND created LIKE '%$d%' ");
                            $row = mysqli_fetch_assoc($sql);
                        ?>
                            <a class="btn btn-success" href="?date=<?= date('Y-m', $time) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="NGN<?= number_format($row['amt']) ?>"><?= $date ?></a>


                        <?php } ?>
                    </div>
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.php') ?>
        <script src="js/bootstrap.bundle.min.js"></script>


        <script type="text/javascript">
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <script>

            window.onload = (event) => {
                let labels = [];
                <?php foreach ($mdate as $element) { ?>
                    labels.push("<?php echo $element; ?>");
                <?php } ?>

                let data = [];
                <?php foreach ($amount as $element) { ?>
                    data.push("<?php echo str_replace(',', '', $element); ?>");
                <?php } ?>
                console.log(data);
                console.log(labels);
                const ctx = document.getElementById('myChart');

                new Chart("myChart", {
                    type: "bar",
                    data: {
                        labels: labels,
                        datasets: [{
                            label:"Days",
                            backgroundColor: "#31af23",
                            data: data,
                        }]
                    },
                    options: {
                        scales:{
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        </script>
        <script src="js/popper.min.js"></script>
</body>

</html>