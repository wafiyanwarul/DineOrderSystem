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

// Query untuk mengambil data customer
$sql_customers = "SELECT 
                    customer.customer_id,
                    customer.user_id
                FROM
                    customer
                JOIN
                    user ON customer.user_id = user.user_id
                WHERE 
                    user.username = '$username'";
$result_customers = $koneksi->query($sql_customers);
$customers = [];
if ($result_customers->num_rows > 0) {
    while ($row = $result_customers->fetch_assoc()) {
        $customers[] = $row;
    }
}

// Query untuk mengambil data restaurant
$sql_restaurants = "SELECT restaurant_id, restaurant_name FROM restaurant";
$result_restaurants = $koneksi->query($sql_restaurants);
$restaurants = [];
if ($result_restaurants->num_rows > 0) {
    while ($row = $result_restaurants->fetch_assoc()) {
        $restaurants[] = $row;
    }
}

// Query untuk mengambil data food
$sql_foods = "SELECT food.food_id, food.restaurant_id, food.food_name, food.price FROM food JOIN restaurant ON food.restaurant_id = restaurant.restaurant_id";
$result_foods = $koneksi->query($sql_foods);
$foods = [];
if ($result_foods->num_rows > 0) {
    while ($row = $result_foods->fetch_assoc()) {
        $foods[] = $row;
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
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span>
                                <img alt="image" class="img-circle" src="../assets/images/profile/default_profile.png" />
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs">
                                        <strong class="font-bold"><?php echo htmlspecialchars($username); ?></strong>
                                    </span>
                                    <span class="text-muted text-xs block"><?php echo htmlspecialchars($role); ?> <b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="../templates/profile.php">Profile</a></li>
                                <li><a href="./dashboard.php">Dashboard</a></li>
                                <li class="divider"></li>
                                <li><a href="../templates/logout.php">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>

                    <!-- Dashboard - Home -->
                    <li>
                        <a href="./dashboard.php"><i class="fa-solid fa-house"></i> <span class="nav-label">Home</span> </a>
                    </li>
                    <!-- Restaurants -->
                    <li>
                        <a href="./restaurants.php"><i class="fa-solid fa-store"></i> <span class="nav-label">Restaurants</span></a>
                    </li>
                    <!-- All Menu -->
                    <li>
                        <a href="./categories.php"><i class="fa-solid fa-table-list"></i> <span class="nav-label">All Menu</span></a>
                    </li>
                    <!-- Foods -->
                    <li>
                        <a href="./foods.php"><i class="fa-solid fa-burger"></i> <span class="nav-label">Foods</span></a>
                    </li>
                    <!-- Drinks -->
                    <li>
                        <a href="./drinks.php"><i class="fa-solid fa-mug-hot"></i> <span class="nav-label">Drinks </span></a>
                    </li>
                    <!-- Appetizers -->
                    <li>
                        <a href="#"><i class="fa-solid fa-shrimp"></i> <span class="nav-label">Appetizers</span> </a>
                    </li>
                    <!-- Desserts -->
                    <li>
                        <a href="#"><i class="fa-solid fa-ice-cream"></i> <span class="nav-label">Desserts</span></a>
                    </li>
                    <!-- Gallery -->
                    <li>
                        <a href="./empty_page.php"><i class="fa fa-desktop"></i> <span class="nav-label">Gallery</span> <span class="pull-right label label-primary">SPECIAL</span></a>
                    </li>
                    <!-- Vouchers -->
                    <li>
                        <a href="./vouchers.php"><i class="fa-solid fa-ticket"></i> <span class="nav-label">Vouchers</span></a>
                    </li>
                    <!-- Orders -->
                    <li class="active">
                        <a href="./orders.php"><i class="fa-solid fa-cart-flatbed-suitcase"></i> <span class="nav-label">Orders</span></a>
                    </li>
                    <!-- Payments -->
                    <li>
                        <a href="./payments.php"><i class="fa-solid fa-money-bill"></i> <span class="nav-label">Payments</span></a>
                    </li>
                    <!-- Ratings -->
                    <li>
                        <a href="#"><i class="fa-solid fa-star"></i> <span class="nav-label">Ratings</span><span class="label label-info pull-right">NEW</span></a>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashboard-1">
            <!-- Navbar Header -->
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Search for food/drink" class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome to Dine Food Special</span>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="mailbox.html">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="profile.html">
                                        <div>
                                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                            <span class="pull-right text-muted small">12 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="grid_options.html">
                                        <div>
                                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="notifications.html">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="../templates/logout.php">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Header Dashboard -->
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Orders</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="./orders.php">Orders</a>
                        </li>
                        <!-- <li class="active">
                            <strong>Profile</strong>
                        </li> -->
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>

            <?php if ($level == 'admin') { ?>
                <div class="row wrapper-content">
                    <div class="col-lg-12 ">
                        <div class="ibox-title bg-primary">
                            <h2><strong>Dine In Hub | Manage Orders Page</strong></h2>
                        </div>
                        <div class="ibox-title text-center">
                            <h2><strong>Manage Orders Data</strong></h2>
                        </div>
                        <!-- Manage Order Data -->
                        <div class="ibox-content">
                            <?php
                            // Query untuk mengambil data order sesuai dengan customer_id yang sedang login
                            $sql_orders = "SELECT orders.order_id, orders.voucher_id, orders.customer_id, orders.restaurant_id, orders.order_date, orders.status, voucher.nama_voucher, user.username, restaurant.restaurant_name FROM orders
                            JOIN voucher ON orders.voucher_id = voucher.voucher_id
                            JOIN customer ON orders.customer_id = customer.customer_id
                            JOIN user ON customer.user_id = user.user_id
                            JOIN restaurant ON orders.restaurant_id = restaurant.restaurant_id";
                            $result_order = $koneksi->query($sql_orders);

                            if ($result_order->num_rows > 0) { ?>
                                <table class='table table-striped table-bordered text-center'>
                                    <thead class='thead-dark'>
                                        <tr>
                                            <th class="text-center">Order ID</th>
                                            <th class="text-center">Voucher ID</th>
                                            <th class="text-center">Customer ID</th>
                                            <th class="text-center">Username</th>
                                            <th class="text-center">Restaurant ID</th>
                                            <th class="text-center">Order Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result_order->fetch_assoc()) {
                                            $status = htmlspecialchars($row['status']);
                                            $status_class = '';
                                            switch ($status) {
                                                case 'pending':
                                                    $status_class = 'label-success';
                                                    break;
                                                case 'success':
                                                    $status_class = 'label-primary';
                                                    break;
                                                case 'failed':
                                                    $status_class = 'label-danger';
                                                    break;
                                            }
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nama_voucher']); ?></td>
                                                <td><?php echo htmlspecialchars($row['customer_id']); ?></td>
                                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                <td><?php echo htmlspecialchars($row['restaurant_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                                                <td><span class="label <?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span></td>
                                                <td>
                                                    <a href='./order_details.php?order_id=<?php echo htmlspecialchars($row['order_id']); ?>' class='btn btn-success btn-sm'>Add Item</a>
                                                    <a href='./order_detail_view.php?order_id=<?php echo htmlspecialchars($row['order_id']); ?>' class='btn btn-primary btn-sm'>View Details</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div class='alert alert-warning'>No orders found.</div>
                            <?php }
                            $koneksi->close() ?>
                        </div>

                        <!-- Title Order Details -->
                        <div class="ibox-title text-center">
                            <h2><strong>Manage Order Details Data</strong></h2>
                        </div>
                        <!-- Manage Order Details Info -->
                        <div class="ibox-content">
                            <?php
                            include "../includes/db_connect.php";

                            // Query untuk mengambil data order sesuai dengan customer_id yang sedang login
                            $sql_order_detail = "SELECT order_detail.order_detail_id, order_detail.order_id, order_detail.food_id, order_detail.quantity, order_detail.total_price, food.food_name, food.price, orders.restaurant_id FROM order_detail
                            JOIN food ON order_detail.food_id = food.food_id
                            JOIN orders ON order_detail.order_id = orders.order_id";
                            $result_order_detail = $koneksi->query($sql_order_detail);

                            // Query untuk mendapatkan data food
                            $sql_food = "SELECT food_id, food_name, price, restaurant_id FROM food";
                            $result_food = $koneksi->query($sql_food);
                            $foods = [];
                            while ($row_food = $result_food->fetch_assoc()) {
                                $foods[] = $row_food;
                            }

                            // Query untuk mendapatkan data order
                            $sql_order = "SELECT order_id, restaurant_id FROM orders";
                            $result_order = $koneksi->query($sql_order);
                            $orders = [];
                            while ($row_order = $result_order->fetch_assoc()) {
                                $orders[] = $row_order;
                            }

                            if ($result_order_detail->num_rows > 0) { ?>
                                <form id="order-details-form">
                                    <table class='table table-striped table-bordered text-center'>
                                        <thead class='thead-dark'>
                                            <tr>
                                                <th class="text-center">Select</th>
                                                <th class="text-center">Order Detail ID</th>
                                                <th class="text-center">Order ID</th>
                                                <th class="text-center">Food ID</th>
                                                <th class="text-center">Food Name</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = $result_order_detail->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><input type="checkbox" class="select-row" disabled></td>
                                                    <td><?php echo htmlspecialchars($row['order_detail_id']); ?></td>
                                                    <td>
                                                        <select class="form-control order-id" name="order_id" disabled>
                                                            <?php foreach ($orders as $order) { ?>
                                                                <option value="<?php echo htmlspecialchars($order['order_id']); ?>" <?php echo $row['order_id'] == $order['order_id'] ? 'selected' : ''; ?>>
                                                                    <?php echo htmlspecialchars($order['order_id']); ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" class="form-control food-id" name="food_id" value="<?php echo htmlspecialchars($row['food_id']); ?>" readonly></td>
                                                    <td>
                                                        <select class="form-control food-name" name="food_name" disabled>
                                                            <?php foreach ($foods as $food) {
                                                                if ($food['restaurant_id'] == $row['restaurant_id']) { ?>
                                                                    <option value="<?php echo htmlspecialchars($food['food_id']); ?>" <?php echo $row['food_id'] == $food['food_id'] ? 'selected' : ''; ?> data-price="<?php echo htmlspecialchars($food['price']); ?>">
                                                                        <?php echo htmlspecialchars($food['food_name']); ?>
                                                                    </option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="number" class="form-control quantity" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" min="1" disabled></td>
                                                    <td><input type="text" class="form-control total-price" name="total_price" value="<?php echo htmlspecialchars($row['total_price']); ?>" readonly></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary edit-btn">Edit</button>
                                        <button type="button" class="btn btn-success save-btn" disabled>Save</button>
                                        <button type="button" class="btn btn-danger delete-btn" disabled>Delete</button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <div class='alert alert-warning'>No order details found.</div>
                            <?php } ?>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const editButton = document.querySelector('.edit-btn');
                                const saveButton = document.querySelector('.save-btn');
                                const deleteButton = document.querySelector('.delete-btn');

                                editButton.addEventListener('click', function() {
                                    document.querySelectorAll('.select-row').forEach(el => el.disabled = false);
                                    document.querySelectorAll('.order-id').forEach(el => el.disabled = false);
                                    document.querySelectorAll('.food-name').forEach(el => el.disabled = false);
                                    document.querySelectorAll('.quantity').forEach(el => el.disabled = false);
                                    saveButton.disabled = false;
                                    deleteButton.disabled = false;
                                });

                                document.querySelectorAll('.food-name').forEach(function(select) {
                                    select.addEventListener('change', function() {
                                        var foodId = this.value;
                                        var price = this.options[this.selectedIndex].getAttribute('data-price');
                                        var row = this.closest('tr');
                                        row.querySelector('.food-id').value = foodId;
                                        updateTotalPrice(row, price);
                                    });
                                });

                                document.querySelectorAll('.quantity').forEach(function(input) {
                                    input.addEventListener('input', function() {
                                        var row = this.closest('tr');
                                        var price = row.querySelector('.food-name').options[row.querySelector('.food-name').selectedIndex].getAttribute('data-price');
                                        updateTotalPrice(row, price);
                                    });
                                });

                                saveButton.addEventListener('click', function() {
                                    const checkedRows = document.querySelectorAll('.select-row:checked');
                                    checkedRows.forEach(function(checkbox) {
                                        var row = checkbox.closest('tr');
                                        var orderDetailId = row.cells[1].innerText;
                                        var orderId = row.querySelector('.order-id').value;
                                        var foodId = row.querySelector('.food-id').value;
                                        var quantity = row.querySelector('.quantity').value;
                                        var totalPrice = row.querySelector('.total-price').value;

                                        // Send Ajax request to update the data
                                        var xhr = new XMLHttpRequest();
                                        xhr.open("POST", "../actions/update_order_detail.php", true);
                                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr.onload = function() {
                                            if (xhr.status === 200) {
                                                alert("Data updated successfully");
                                                location.reload(); // Refresh the page
                                            } else {
                                                alert("Error updating data");
                                            }
                                        };
                                        xhr.send("order_detail_id=" + orderDetailId + "&order_id=" + orderId + "&food_id=" + foodId + "&quantity=" + quantity + "&total_price=" + totalPrice);
                                    });

                                    // Disable the fields again
                                    document.querySelectorAll('.select-row').forEach(el => el.disabled = true);
                                    document.querySelectorAll('.order-id').forEach(el => el.disabled = true);
                                    document.querySelectorAll('.food-name').forEach(el => el.disabled = true);
                                    document.querySelectorAll('.quantity').forEach(el => el.disabled = true);
                                    saveButton.disabled = true;
                                    deleteButton.disabled = true;
                                });

                                deleteButton.addEventListener('click', function() {
                                    const checkedRows = document.querySelectorAll('.select-row:checked');
                                    checkedRows.forEach(function(checkbox) {
                                        var row = checkbox.closest('tr');
                                        var orderDetailId = row.cells[1].innerText;

                                        // Send Ajax request to delete the data
                                        var xhr = new XMLHttpRequest();
                                        xhr.open("POST", "../actions/delete_order_detail.php", true);
                                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr.onload = function() {
                                            if (xhr.status === 200) {
                                                alert("Data deleted successfully");
                                                location.reload(); // Refresh the page
                                            } else {
                                                alert("Error deleting data");
                                            }
                                        };
                                        xhr.send("order_detail_id=" + orderDetailId);
                                    });

                                    // Disable the fields again
                                    document.querySelectorAll('.select-row').forEach(el => el.disabled = true);
                                    document.querySelectorAll('.order-id').forEach(el => el.disabled = true);
                                    document.querySelectorAll('.food-name').forEach(el => el.disabled = true);
                                    document.querySelectorAll('.quantity').forEach(el => el.disabled = true);
                                    saveButton.disabled = true;
                                    deleteButton.disabled = true;
                                });

                                function updateTotalPrice(row, price) {
                                    var quantity = row.querySelector('.quantity').value;
                                    var totalPrice = price * quantity;
                                    row.querySelector('.total-price').value = totalPrice.toFixed(2);
                                }
                            });
                        </script>

                    </div>
                </div>

            <?php } elseif ($level == 'customer') { ?>
                <div class="wrapper wrapper-content animated fadeInLeft">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title bg-success">
                                    <h2><strong>Dine In Hub | Orders Page</strong></h2>
                                </div>
                                <div class="ibox-content ">
                                    <h2>Place Order</h2>
                                    <form id="orderForm" action="../actions/order_place.php" method="post">
                                        <div class="form-group">
                                            <label for="voucherId">Voucher ID</label>
                                            <select class="form-control" id="voucherId" name="voucher_id">
                                                <option value="">Select Voucher</option>
                                                <?php foreach ($vouchers as $voucher) : ?>
                                                    <option value="<?php echo $voucher['voucher_id']; ?>"><?php echo $voucher['nama_voucher']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="customerId">Customer ID</label>
                                            <select class="form-control" id="customerId" name="customer_id" required>
                                                <option value="">Select Customer</option>
                                                <?php foreach ($customers as $customer) : ?>
                                                    <option value="<?php echo $customer['customer_id']; ?>"><?php echo $username; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="restaurantId">Restaurant ID</label>
                                            <select class="form-control" id="restaurantId" name="restaurant_id" required>
                                                <option value="">Select Restaurant</option>
                                                <?php foreach ($restaurants as $restaurant) : ?>
                                                    <option value="<?php echo $restaurant['restaurant_id']; ?>"><?php echo $restaurant['restaurant_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">Place Order</button>
                                        <!-- <a href="./order_details.php"><button class="btn btn-info" type="button">Order Detail</button></a> -->
                                    </form>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $sql_customers = "SELECT 
                                    customer.customer_id,
                                    customer.user_id
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
                                    // Query untuk mengambil data order sesuai dengan customer_id yang sedang login
                                    $sql_orders = "SELECT * FROM orders WHERE customer_id = $customer_id";
                                    $result_order = $koneksi->query($sql_orders);

                                    if ($result_order->num_rows > 0) { ?>
                                        <table class='table table-striped table-bordered'>
                                            <thead class='thead-dark'>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Order Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $result_order->fetch_assoc()) {
                                                    $status = htmlspecialchars($row['status']);
                                                    $status_class = '';
                                                    switch ($status) {
                                                        case 'pending':
                                                            $status_class = 'label-success';
                                                            break;
                                                        case 'success':
                                                            $status_class = 'label-primary';
                                                            break;
                                                        case 'failed':
                                                            $status_class = 'label-danger';
                                                            break;
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                                                        <td><span class="label <?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span></td>
                                                        <td>
                                                            <a href='./order_details.php?order_id=<?php echo htmlspecialchars($row['order_id']); ?>' class='btn btn-success btn-sm'>Add Item</a>
                                                            <a href='./order_detail_view.php?order_id=<?php echo htmlspecialchars($row['order_id']); ?>' class='btn btn-primary btn-sm'>View Details</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class='alert alert-warning'>No orders found.</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } else { ?>
            <?php } ?>


        </div>


    </div>
    </div>

    <!-- Mainly scripts -->
    <script src="../assets/inspinia/js/jquery-3.1.1.min.js"></script>
    <script src="../assets/inspinia/js/bootstrap.min.js"></script>
    <script src="../assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="../assets/inspinia/js/plugins/flot/jquery.flot.js"></script>
    <script src="../assets/inspinia/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="../assets/inspinia/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="../assets/inspinia/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="../assets/inspinia/js/plugins/flot/jquery.flot.pie.js"></script>

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

    <!-- Sparkline -->
    <script src="../assets/inspinia/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="../assets/inspinia/js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="../assets/inspinia/js/plugins/chartJs/Chart.min.js"></script>

    <!-- Toastr -->
    <script src="../assets/inspinia/js/plugins/toastr/toastr.min.js"></script>


    <script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('Orders Page!', 'Dine In HUB');

            }, 1300);
        });
    </script>
</body>

</html>