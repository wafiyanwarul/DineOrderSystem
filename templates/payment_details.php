<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (!isset($_SESSION['username'])) {
    die("<h1><center>Anda belum login</h1></center>");
}
// Mendapatkan data user dari session atau database
$username = $_SESSION['username'];
$sql = "SELECT username, level FROM user WHERE username = '$username'";
$result = $koneksi->query($sql);
$user = $result->fetch_assoc();

$username = $user['username'] ?? 'Guest';
$level = $user['level'] ?? 'unknown';

if ($level == 'customer') {
    $role = 'Customer';
} else if ($level == 'admin') {
    $role = 'Admin';
} else {
    $role = 'Unknown';
}

// Query untuk mengambil data voucher
$sql_vouchers = "SELECT voucher_id, nama_voucher, code, discount FROM voucher";
$result_vouchers = $koneksi->query($sql_vouchers);
$vouchers = [];
if ($result_vouchers->num_rows > 0) {
    while ($row = $result_vouchers->fetch_assoc()) {
        $vouchers[] = $row;
    }
}
?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Dine In Hub | Orders</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon_io/apple-touch-icon.png">

    <link rel="manifest" href="../assets/favicon_io/site.webmanifest">

    <!-- Main Favicon -->
    <link rel="shortcut icon" href="../assets/favicon_io/favicon.ico" type="image/x-icon">

    <link href="../assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="../assets/inspinia/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="../assets/inspinia/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="../assets/inspinia/css/animate.css" rel="stylesheet">
    <link href="../assets/inspinia/css/style.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/ce1fc2061c.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="gray-bg dashboard-1">
        <?php if ($level == 'admin') { ?>
            <div class="row wrapper-content">
                <div class="col-lg-12 ">
                    <div class="ibox-title">
                        <h2>Hi <strong><?php echo htmlspecialchars($username) ?></strong></h2>
                    </div>
                    <div class="ibox-title bg-primary">
                        <h2>Welcome to <strong>Dine In Hub | Orders Page</strong></h2>
                    </div>
                    <div class="ibox-content">
                    </div>
                </div>
            </div>
    </div>

<?php } elseif ($level == 'customer') { ?>
    <div class="wrapper wrapper-content animated fadeInLeft">
        <div class="row">
        <div class="col-lg-12">
                <?php
                // Query untuk mengambil data order dari tabel orders
                if (isset($_GET['order_id'])) {
                    $order_id = $_GET['order_id'];

                    // Query untuk mengambil data order dari tabel orders
                    $sql_order = "SELECT * FROM orders WHERE order_id = '$order_id'";
                    $result_order = $koneksi->query($sql_order);

                    if ($result_order) {
                        if ($result_order->num_rows > 0) {
                            $order = $result_order->fetch_assoc();
                        }
                    }
                }

                // Query untuk mengambil metode pembayaran
                $sql_payment_methods = "SELECT * FROM payment_methods";
                $result_payment_methods = $koneksi->query($sql_payment_methods);
                $payment_methods = [];
                if ($result_payment_methods->num_rows > 0) {
                    while ($row = $result_payment_methods->fetch_assoc()) {
                        $payment_methods[] = $row;
                    }
                }
                ?>

                <div class="ibox">
                    <div class="ibox-title bg-success">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h2><strong>Dine In Hub</strong></h2>
                    </div>
                    <div class="ibox-title">
                        <h2 class="border-top-bottom border-left-right p-sm text-center"><strong>Payment Details</strong></h2>
                        <span class="form-control bg-primary">
                            <h4 class="pull-right">Order ID : <?php echo htmlspecialchars($order['order_id']); ?></h4>
                        </span>

                        <?php
                        $sql_customers = "SELECT 
                        customer.customer_id,
                        customer.user_id,
                        user.username
                      FROM
                        customer
                      JOIN
                        user ON customer.user_id = user.user_id
                      WHERE 
                        user.username = '$username'";
                        $result_customers = $koneksi->query($sql_customers);
                        $customer_id = null;
                        if ($result_customers->num_rows > 0) {
                            $row = $result_customers->fetch_assoc();
                            $customer_id = $row['customer_id'];
                        }

                        if ($customer_id === null) {
                            die("<h1><center>Customer ID tidak ditemukan</h1></center>");
                        }

                        // Ambil informasi order termasuk nama restoran
                        $sql_order_restaurant = "SELECT 
                                o.order_id,
                                r.restaurant_name
                             FROM
                                orders o
                             JOIN
                                restaurant r ON o.restaurant_id = r.restaurant_id
                             WHERE 
                                o.order_id = '$order_id'";
                        $result_order_restaurant = $koneksi->query($sql_order_restaurant);
                        $order_restaurant = null;
                        if ($result_order_restaurant->num_rows > 0) {
                            $order_restaurant = $result_order_restaurant->fetch_assoc();
                        }

                        if ($order_restaurant === null) {
                            die("<h1><center>Order ID atau Restaurant tidak ditemukan</h1></center>");
                        }
                        ?>
                        <h4 class="m-l-sm">Nama Customer : <?php echo htmlspecialchars($row['username']); ?></h4>
                        <h4 class="m-l-sm">Nama Restoran : <?php echo htmlspecialchars($order_restaurant['restaurant_name']); ?></h4>
                    </div>


                    <?php if (isset($_SESSION['payment_success'])) : ?>
                        <?php if ($_SESSION['payment_success']) : ?>
                            <div class="alert alert-warning">Pembayaran Berhasil Dibuat. Mohon Konfirmasi Pembayaran.</div>
                        <?php endif; ?>
                        <?php unset($_SESSION['payment_success']); ?>
                    <?php endif; ?>

                    <?php
                    if (isset($order_id) && is_numeric($order_id)) {
                        $sql_order_detail = "SELECT order_detail.order_id, order_detail.food_id, order_detail.quantity, order_detail.total_price, 
                        orders.order_id, orders.voucher_id, orders.customer_id, orders.restaurant_id, orders.order_date, orders.status, 
                        food.food_name, food.price, food.description, food.image, category.category_name, restaurant.restaurant_name, 
                        voucher.nama_voucher, voucher.discount
                        FROM order_detail 
                        JOIN orders ON order_detail.order_id = orders.order_id
                        JOIN food ON order_detail.food_id = food.food_id
                        JOIN category ON food.category_id = category.category_id
                        JOIN restaurant ON food.restaurant_id = restaurant.restaurant_id
                        LEFT JOIN voucher ON orders.voucher_id = voucher.voucher_id
                        WHERE order_detail.order_id = ?";
                        $stmt_order_detail = $koneksi->prepare($sql_order_detail);
                        $stmt_order_detail->bind_param("i", $order_id);
                        $stmt_order_detail->execute();
                        $result_order_details = $stmt_order_detail->get_result();

                        $order_details = [];
                        $total_amount = 0;
                        $voucher_name = '';
                        $voucher_discount = 0;
                        if ($result_order_details->num_rows > 0) {
                            while ($row = $result_order_details->fetch_assoc()) {
                                $order_details[] = $row;
                                $total_amount += $row['total_price'];
                                $voucher_name = $row['nama_voucher'];
                                $voucher_discount = $row['discount'];
                            }
                        } else {
                            echo "<div class='alert alert-warning m-t-md'>No order details found for order ID: " . htmlspecialchars($order_id) . ". | <strong>COMPLETE YOUR ORDER DETAIL FIRST ON PAGE ORDERS</strong></div>";
                        }
                        $stmt_order_detail->close();
                        $final_amount = $total_amount - ($total_amount * ($voucher_discount / 100));
                    } else {
                        echo "<div class='alert alert-danger'>Invalid order ID.</div>";
                    }
                    ?>
                    <?php if (!empty($order_details)) : ?>
                        <?php foreach ($order_details as $row) : ?>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table shoping-cart-table m-t-xs">
                                        <tbody>
                                            <tr>
                                                <td width="90">
                                                    <div class="img-container">
                                                        <img src="<?php echo htmlspecialchars($row['image'] ?? ''); ?>" alt="product-image" class="img-container">
                                                    </div>
                                                </td>
                                                <td class="desc">
                                                    <h3>
                                                        <a href="./food_detail.php?id=<?php echo htmlspecialchars($row['food_id'] ?? ''); ?>" class="text-navy">
                                                            <?php echo htmlspecialchars($row['food_name'] ?? ''); ?>
                                                        </a>
                                                    </h3>
                                                    <h4><?php echo htmlspecialchars($row['category_name'] ?? ''); ?></h4>
                                                    <dl class="small m-b-none">
                                                        <dt>Description</dt>
                                                        <dd><?php echo htmlspecialchars($row['description'] ?? ''); ?></dd>
                                                    </dl>
                                                </td>
                                                <td>
                                                    Rp. <?php echo number_format($row['price'] ?? 0, 2); ?>
                                                </td>
                                                <td width="65">
                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['quantity'] ?? ''); ?>" readonly>
                                                </td>
                                                <td>
                                                    <h4>
                                                        Rp. <?php echo number_format($row['total_price'] ?? 0, 2); ?>
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table shoping-cart-table m-t-xs">
                                    <tbody>
                                        <tr>
                                            <td class="text-right">
                                                <h4>Total Amount: Rp. <?php echo number_format($total_amount, 2); ?></h4>
                                                <h4>Voucher: <?php echo htmlspecialchars($voucher_name); ?></h4>
                                                <h4>Discount: <?php echo number_format($voucher_discount, 2); ?>%</h4>
                                                <h4>Final Amount: Rp. <?php echo number_format($final_amount, 2); ?></h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Add data to Payment Table -->
                    <div class="ibox-content">
                        <form action="../actions/process_payment.php" method="post">
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select name="pmethod_id" id="payment_method" class="form-control">
                                    <?php foreach ($payment_methods as $method) : ?>
                                        <option value="<?php echo htmlspecialchars($method['pmethod_id']); ?>"><?php echo htmlspecialchars($method['pmethod_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                            <input type="hidden" name="amount" value="<?php echo htmlspecialchars($final_amount); ?>">
                            <button type="submit" class="btn btn-primary pull-right m-l-sm"><i class="fa fa fa-shopping-cart"></i> Checkout</button>
                        </form>
                        <button type="button" class="btn btn-danger pull-right" onclick="window.location.href='../actions/generate_pdf.php?order_id=<?php echo htmlspecialchars($order['order_id']); ?>'"><i class="fa fa-file-pdf-o"></i> Download PDF</button>
                        <button type="button" class="btn btn-info pull-left m-r-sm" onclick="window.location.href='./order_details.php?order_id=<?php echo htmlspecialchars($order['order_id']); ?>'"><i class="fa fa-arrow-left"></i> Continue shopping</button>
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
<? } else { ?>
<?php } ?>

<!-- Mainly scripts -->
<script src="../assets/inspinia/js/jquery-3.1.1.min.js"></script>
<script src="../assets/inspinia/js/bootstrap.min.js"></script>
<script src="../assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Peity -->
<script src="../assets/inspinia/js/plugins/peity/jquery.peity.min.js"></script>
<script src="../assets/inspinia/js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="../assets/inspinia/js/inspinia.js"></script>
<script src="../assets/inspinia/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="../assets/inspinia/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- GITTER -->
<script src="../assets/inspinia/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Toastr -->
<script src="../assets/inspinia/js/plugins/toastr/toastr.min.js"></script>
</body>

</html>