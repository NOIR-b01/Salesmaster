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

?>
<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Index</title><!--begin::Primary Meta Tags-->
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
</head> <!--end::Head--> <!--begin::Body-->
<?php include('nav2.php') ?>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
<div class="app-wrapper"> <!--begin::Header-->  
<main class="app-main"> <!--begin::App Content Header-->
<div class="app-content-header"> <!--begin::Container-->   
<div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                        <div class="col-sm-6">
                        <h2 class="mb-0">Point of Sales</h2>
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Add Items to Cart</h6>
                    </div>
                    <div class="card-body">
                        <form method="post">
                    
                        <label for="">Items</label>
                        <select class="form-control" name="item"  id="product" onchange="fetchPrice()">
                         
                        <option value="">Items</option>
                                <?php $sql = $db->query("SELECT * FROM product");
                                        while ($row = mysqli_fetch_assoc($sql)) { ?>
                                            <option value="<?= selectSn($row['sn']) ?>"><?= selectSn($row['sn']) ?></option>
                                        <?php } ?>
                        </select>
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
                                <input type="tel" class="form-control" id="amount" onkeyup="this.value = document.getElementById('qty').value * document.getElementById('price').value;" name="amount" placeholder="Enter Amount">
                            </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <div style="float:right">
                                <button type="submit" class="btn btn-primary btn-block" name="AddItem"><span>Add Item to Cart</span> <i class='bx bxs-cart-add'></i></button>
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
                                    <div>
                                        <h3><i class='bx bx-cart-alt'></i><span>Cart</span></h3>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $sales->sqL1('item', 'salesid', $salesid); ?>
                                            <span class="visually-hidden">New alerts</span>
                                        </span>
                                    </div>
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
                                global $grand;
                                $sql = $db->query("SELECT * FROM item WHERE bid='$bid' AND salesid='$salesid' AND status=1");
                                while ($row = $sql->fetch_assoc()) {
                                    $total += $row["amount"];
                                    $delete  = 'href="?delete=' . $row["sn"] . '"';
                                    echo "<tr><td>" . $row["qty"] . "</td><td>" . $row["item"] . "</td><td>" . number_format($row["price"]) . "</td><td>" . $row["amount"] . "</td><td><a " . $delete . ">Remove</a></td></tr>";
                                    // echo '<tr><th colspan="3">'. $row["sn"] .'</th></tr>';
                                }
                                echo '<tr><th colspan="3">Total</th><th>' . number_format($total) . '</th><th></th></tr><tr><th colspan="3">Discount</th><th id="demo"></th><th></th></tr><tr><th colspan="3">Grand Total</th><th id="grand"></th><th></th></tr>';
                                ?>
                            </table>
                            <?php $sql = $db->query("SELECT * FROM item WHERE bid='$bid' AND salesid='$salesid' AND status=0");
                            while ($row = $sql->fetch_assoc()) {

                                echo ' <a href="?restore=' . $row['sn'] .  '">' . $row['item'] .  '</a> | ';
                            }
                            ?>
                            <input type="hidden" name="total" id="total" value="<?= $total ?>">
                            <input type="hidden" name="mydiscount" id="mydisc" >

                            <br>
                            <label for="">Discount Type</label>
                            <select class="form-control" id="discount-type" name="discount-type" onchange="updateDiscount()">
                                <option value="">Select Option...</option>
                                <option value="percent">Percent</option>
                                <option value="amount">Amount</option>
                            </select><br>
                            <label for="">Discount</label>
                            <input type="number" id="discount" class="form-control" name="discount" onkeyup="updateDiscount()"><br>

                            <label for="">Mode of Payment</label>
                            <select class="form-control" name="mode">
                                <option value="">Select Option...</option>
                                <option value="cash">Cash</option>
                                <option value="Paystack"> PayStack</option>
                                <option value="pos">POS</option>
                            </select><br>
                            <label for="">Customer Name</label>
                            <input type="text" id="customer-name" class="form-control" name="customer"><br>
                            <label for="">Customer Phone Number</label>
                            <input type="number" class="form-control" name="phone"><br>
                        </div>
                        <div class="card-footer">
                            <div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Pay with Paystack
                                </button>
                                <button style="float:right" type="submit" class="btn btn-primary btn-block" name="Checkout">Complete Checkout</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pay with Paystack</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="paymentForm">
                                    <div class="form-group">
                                        <label class="mt-1" for="email">Email Address</label>
                                        <input class="form-control" type="email" id="email-address" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-2" for="amount">Amount</label>
                                        <input class="form-control" type="tel" id="amoun" value="<?= $total ?>" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label class="mt-2" for="first-name">Customer Name</label>
                                        <input class="form-control" type="text" id="first-name" onkeyup="this.value = document.getElementById('customer-name').value" readonly />
                                    </div>
                                    <div class="form-submit">
                                        <button type="Submit" class="btn btn-primary mt-2" onclick="payWithPaystack()">Pay</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <td><a class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-title="Edit Transaction" href="receipt.php?salesid=<?= $row['salesid'] ?>"><i class='bx bxs-receipt' style="color: #ffff;"></i></a>

                                <?php if ($e == 1 && substr($row['created'], 0, 10) == date('Y-m-d')) { ?><a style="margin-left: 10px" href="?edit=<?= $row['sn'] ?>&salesid=<?= $row['salesid'] ?>" class="btn btn-sm btn-primary"><i class='bx bxs-message-square-edit'></i></a><?php } ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>
</div>
</div>


</main> <!--end::App Main--> <!--begin::Footer-->
        <footer class="app-footer"> <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline"><strong> All rights reserved.</strong></div> <!--end::To the end--> <!--begin::Copyright--> <strong>
            <div>Facebook</div>
            <p>Livepetalsupermarket@gmail.com</p>
            <p>&copy; 2024 LIVEPETAL SUPERMARKET
            .</p>
            </strong>       
            <!--end::Copyright-->
        </footer> <!--end::Footer-->
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->




    <script src="js/bootstrap.bundle.min.js"></script>



<script src="https://js.paystack.co/v2/inline.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@floating-ui/core@1.6.3"></script>
<script src="https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.6.6"></script>



<script>
// Paystack script link
    const paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener("submit", payWithPaystack, false);

    function payWithPaystack(e) {
        e.preventDefault();

        let handler = PaystackPop.setup({
            key: 'pk_test_795d779e21245d2bb3c349d193ee41572af57971', // Replace with your public key
            email: document.getElementById("email-address").value,
            amount: document.getElementById("amoun").value * 100,
            // currency: NGN,
            ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            // label: "Optional string that replaces customer email"
            onClose: function() {
                alert('Window closed.');
            },
            callback: function(response) {
                let message = 'Payment complete! Reference: ' + response.reference;
                alert(message);
            }
        });

        handler.openIframe();
    }

</script>

<!-- Discount script -->
<script>
    function updateDiscount() {
        let discountValue = document.getElementById('discount').value;
        let totalValue = document.getElementById('total').value;
        let discountType = document.getElementById('discount-type').value;
        let discountAmount;

        if (discountType === 'percent') {
            if (discountValue > 100) {
                alert('Percentage discount cannot be more than 100%');
                document.getElementById('discount').value = 0;
                discountValue = 0;
            }
            discountAmount = (totalValue * discountValue) / 100;
        } else if (discountType === 'amount') {
            if (discountValue > totalValue) {
                // alert('Discount amount cannot be more than total');
                // document.getElementById('discount').value = 0;
                // discountValue = 0;
            }
            discountAmount = discountValue;
        } else {
            discountAmount = 0;
            document.getElementById('discount').value = 0;
            discountValue = 0;
        }

        document.getElementById("demo").innerHTML = discountAmount;
        let grandTotal = totalValue - discountAmount;
        document.getElementById("grand").innerHTML = grandTotal; 
        document.getElementById('mydisc').value = discountAmount;      

        console.log('Total:', totalValue);
        console.log('Discount:', discountValue);
        console.log('Grand Total:', grandTotal);
    }
</script>

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    let emptyCart = document.getElementById("empty-cart");
    let cartItems = document.getElementById("cart-items");

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

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

    const toastTrigger = document.getElementById('liveToastBtn')
    const toastLiveExample = document.getElementById('liveToast')


    
</script>
 
</body><!--end::Body-->

</html>
