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

// if(isset($_POST['Updatecategories']))
// {
//     $sn = $_GET['update'];

//     $title = $_POST['title'];
//     $description = $_POST['description'];

//     $sql=$db->query("UPDATE categories SET title = '$title', description = '$description' WHERE sn = '$sn'");
// }


if(isset($_GET['delete'])){
    $sn = $_GET['delete'];
    $sql=$db->query("DELETE FROM categories WHERE sn = '$sn'");
}

// if ($sql) {
//     Alert('Successfully Deleted');
// }

?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Categories</title><!--begin::Primary Meta Tags-->
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

<?php include('nav2.php') ?>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <br>
    <main class="app-main"> <!--begin::App Content Header-->
    <div class="container mt-4">
    <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                        <div class="col-sm-6">
                        <h2 class="mb-0">Categories</h2>
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
    <!-- <div class="container mt-4"> -->
        <!-- Categories Form Start         -->
        <div class="col-md-4">
            <div class="row">
                <form method="post">
                    <div class="card">
                        <div class="card-header">
                            <h2>Add Categories</h2>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Item title">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" class="form-control" name="description" placeholder="Enter description">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group">
                                <div style="float:right">
                                    <button type="submit" class="btn btn-primary btn-block" name="AddCategories"><span>Add Categories</span></button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div> <br>
        <!-- Categories Form Start         -->

        <!-- Categories Table Start         -->
        <!-- <div class="row pb-5"> -->
        <!-- <div class="col-md-12 pt-4"> -->
        <div class="card">
            <div class="card-header">
                <h1>Categories</h1>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php $i = 1;
                    $sql = $db->query("SELECT * FROM categories");
                    while ($row = mysqli_fetch_assoc($sql)) {
                        $e = $i++ ?>
                        <tr>
                            <td><?= $e ?></td>
                            <td><?= $row['title'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td><?= $row['created'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td><a href="?update=<?= $row['sn'] ?>" class="btn btn-success">edit</a></td>
                            <td><a href="?delete=<?= $row['sn'] ?>" class="btn btn-danger">delete</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="card-footer"></div>
        <!-- Categories Table End         -->
    </div>
    </main>

    <?php include('footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body><!--end::Body-->

</html>