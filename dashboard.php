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
    <title>Dashboard</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(       Scrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
</head> <!--end::Head-->
<body>
  <?php include('nav2.php') ?> 
  <div class="container mt-4">
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