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
                    <li>
                        <a href="./orders.php"><i class="fa-solid fa-cart-flatbed-suitcase"></i> <span class="nav-label">Orders</span></a>
                    </li>
                    <!-- Payments -->
                    <li class="active">
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
                    <h2>Payments</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="./payments.php">Payments</a>
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
                <div class="wrapper wrapper-content animated fadeInLeft">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="ibox">
                                <div class="ibox-title bg-primary">
                                    <h2><strong>Dine In Hub | Manage Payments Page</strong></h2>
                                </div>
                                <div class="ibox-title text-center">
                                    <h2><strong>Payments Data</strong></h2>
                                </div>
                                <?php
                                $sql_payment_methods = "SELECT pmethod_id, pmethod_name FROM payment_methods";
                                $result_payment_methods = $koneksi->query($sql_payment_methods);

                                $paymentMethods = [];
                                if ($result_payment_methods->num_rows > 0) {
                                    while ($row = $result_payment_methods->fetch_assoc()) {
                                        $paymentMethods[] = $row;
                                    }
                                }
                                ?>
                                <div class="ibox-content">
                                    <?php
                                    $sql_payment = "SELECT payment.payment_id, payment.order_id, payment.pmethod_id, payment.payment_date, payment.amount, payment.status, payment_methods.pmethod_name 
                        FROM payment 
                        INNER JOIN payment_methods ON payment.pmethod_id = payment_methods.pmethod_id";
                                    $result_payment = $koneksi->query($sql_payment);
                                    if ($result_payment->num_rows > 0) { ?>
                                        <table id="payment-table" class='table table-striped table-bordered'>
                                            <thead class='thead-dark'>
                                                <tr>
                                                    <th class="text-center"><input type="checkbox" id="select-all" class="form-control"></th>
                                                    <th class="text-center">Payment ID</th>
                                                    <th class="text-center">Order ID</th>
                                                    <th class="text-center">Payment Method ID</th>
                                                    <th class="text-center">Payment Method Name</th>
                                                    <th class="text-center">Payment Date</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center" width="120">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <?php while ($row = $result_payment->fetch_assoc()) { ?>
                                                    <?php
                                                    $status = htmlspecialchars($row['status']);
                                                    $status_class = '';
                                                    switch ($status) {
                                                        case 'pending':
                                                            $status_class = 'label-warning';
                                                            break;
                                                        case 'success':
                                                            $status_class = 'label-success';
                                                            break;
                                                        case 'failed':
                                                            $status_class = 'label-danger';
                                                            break;
                                                    } ?>
                                                    <tr>
                                                        <td><input type="checkbox" class="row-checkbox form-control" disabled></td>
                                                        <td><?php echo htmlspecialchars($row['payment_id']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                                                        <td><input type="text" class="form-control payment-method-id" value="<?php echo htmlspecialchars($row['pmethod_id']); ?>" readonly></td>
                                                        <td>
                                                            <select class="form-control payment-method-name" disabled>
                                                                <?php foreach ($paymentMethods as $method) { ?>
                                                                    <option value="<?php echo $method['pmethod_id']; ?>" <?php if ($method['pmethod_name'] === $row['pmethod_name']) echo 'selected'; ?>>
                                                                        <?php echo $method['pmethod_name']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($row['payment_date']); ?></td>
                                                        <td>Rp. <?php echo htmlspecialchars($row['amount']); ?></td>
                                                        <td>
                                                            <select class="form-control status" disabled>
                                                                <option value="pending" <?php if ($row['status'] === 'pending') echo 'selected'; ?>>Pending</option>
                                                                <option value="success" <?php if ($row['status'] === 'success') echo 'selected'; ?>>Success</option>
                                                                <option value="failed" <?php if ($row['status'] === 'failed') echo 'selected'; ?>>Failed</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                    <button id="edit-btn" class="btn btn-primary">Edit</button>
                                    <button type="submit" id="save-btn" class="btn btn-success" disabled>Save</button>
                                    <button id="delete-btn" class="btn btn-danger" disabled>Delete</button>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const editBtn = document.getElementById('edit-btn');
                                        const saveBtn = document.getElementById('save-btn');
                                        const deleteBtn = document.getElementById('delete-btn');
                                        const selectAllCheckbox = document.getElementById('select-all');

                                        // Ambil data payment methods dari PHP
                                        const paymentMethods = <?php echo json_encode($paymentMethods); ?>;

                                        editBtn.addEventListener('click', function() {
                                            document.querySelectorAll('.row-checkbox').forEach(el => el.disabled = false);
                                            document.querySelectorAll('.payment-method-id').forEach(el => el.readOnly = false);
                                            document.querySelectorAll('.payment-method-name').forEach(el => el.disabled = false);
                                            document.querySelectorAll('.status').forEach(el => el.disabled = false);

                                            saveBtn.disabled = false;
                                            deleteBtn.disabled = false;
                                        });

                                        saveBtn.addEventListener('click', function() {
                                            let paymentIds = [];
                                            let pmethodIds = [];
                                            let statuses = [];

                                            document.querySelectorAll('tbody tr').forEach(row => {
                                                if (row.querySelector('.row-checkbox').checked) {
                                                    paymentIds.push(row.cells[1].textContent);
                                                    pmethodIds.push(row.cells[4].querySelector('select').value);
                                                    statuses.push(row.cells[7].querySelector('select').value);
                                                }
                                            });

                                            if (paymentIds.length > 0) {
                                                fetch('../actions/update_payment.php', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/x-www-form-urlencoded'
                                                        },
                                                        body: new URLSearchParams({
                                                            'payment_ids[]': paymentIds,
                                                            'pmethod_ids[]': pmethodIds,
                                                            'statuses[]': statuses
                                                        })
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.status === 'success') {
                                                            alert('Data updated successfully.');
                                                            location.reload();
                                                        } else {
                                                            alert('Error: ' + data.message);
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error('Error:', error);
                                                    });
                                            } else {
                                                alert('No rows selected for update.');
                                            }
                                        });

                                        deleteBtn.addEventListener('click', function() {
                                            let paymentIds = [];

                                            document.querySelectorAll('tbody tr').forEach(row => {
                                                if (row.querySelector('.row-checkbox').checked) {
                                                    paymentIds.push(row.cells[1].textContent);
                                                }
                                            });

                                            if (paymentIds.length > 0) {
                                                if (confirm('Are you sure you want to delete the selected records?')) {
                                                    fetch('../actions/delete_payment.php', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/x-www-form-urlencoded'
                                                            },
                                                            body: new URLSearchParams({
                                                                'payment_ids[]': paymentIds
                                                            })
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            if (data.status === 'success') {
                                                                alert('Data deleted successfully.');
                                                                location.reload();
                                                            } else {
                                                                alert('Error: ' + data.message);
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Error:', error);
                                                        });
                                                }
                                            } else {
                                                alert('No rows selected for deletion.');
                                            }
                                        });

                                        selectAllCheckbox.addEventListener('change', function() {
                                            let checked = this.checked;
                                            document.querySelectorAll('.row-checkbox').forEach(el => el.checked = checked);
                                        });

                                        document.querySelectorAll('.payment-method-name').forEach(select => {
                                            select.addEventListener('change', function() {
                                                let selectedOption = this.options[this.selectedIndex];
                                                let pmethodId = selectedOption.value;
                                                let paymentMethodIdInput = this.closest('tr').querySelector('.payment-method-id');
                                                paymentMethodIdInput.value = pmethodId;
                                            });
                                        });
                                    });
                                </script>
                            </div>

                            <div class="ibox">
                                <div class="ibox-title text-center">
                                    <h2><strong>Manage Payment Methods</strong></h2>
                                </div>
                                <!-- Manage Payment Methods -->
                                <div class="ibox-content">
                                    <?php
                                    // Koneksi ke database
                                    include '../includes/db_connect.php';

                                    // Query untuk mengambil data dari tabel payment_methods
                                    $sql_payment_methods = "SELECT pmethod_id, pmethod_name FROM payment_methods";
                                    $result_payment_methods = $koneksi->query($sql_payment_methods);

                                    if ($result_payment_methods->num_rows > 0) { ?>
                                        <form id="paymentMethodsForm">
                                            <table class='table table-striped table-bordered text-center'>
                                                <thead class='thead-dark'>
                                                    <tr>
                                                        <th class='text-center' width="80">Payment Method ID</th>
                                                        <th class='text-center'>Payment Method Name</th>
                                                        <th class='text-center' width="100">Delete</th>
                                                        <th class='text-center' width="80">Edit</th>
                                                        <th class='text-center' width="80">Save</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row = $result_payment_methods->fetch_assoc()) { ?>
                                                        <tr>
                                                            <td class='text-center'><input type="text" class="form-control" value="<?php echo htmlspecialchars($row['pmethod_id']); ?>" disabled></td>
                                                            <td class='text-center'><input type="text" class="form-control pmethod_name" value="<?php echo htmlspecialchars($row['pmethod_name']); ?>" disabled></td>
                                                            <td class="text-center"><button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button></td>
                                                            <td class="text-center"><button type="button" class="btn btn-warning btn-sm edit-btn m-b-sm">Edit</button></td>
                                                            <td class='text-center'><button type="button" class="btn btn-success btn-sm save-btn m-b-sm" disabled>Save</button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    <?php } else { ?>
                                        <div class='alert alert-warning'>No payment methods found.</div>
                                    <?php } ?>
                                </div>

                                <!-- Script for payment methods data -->
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const editButtons = document.querySelectorAll('.edit-btn');
                                        const saveButtons = document.querySelectorAll('.save-btn');
                                        const deleteButtons = document.querySelectorAll('.delete-btn');

                                        editButtons.forEach((editButton, index) => {
                                            editButton.addEventListener('click', () => {
                                                const row = editButton.closest('tr');
                                                const pmethodNameField = row.querySelector('.pmethod_name');
                                                const saveButton = row.querySelector('.save-btn');

                                                pmethodNameField.disabled = false;
                                                saveButton.disabled = false;
                                                editButton.disabled = true;
                                            });
                                        });

                                        saveButtons.forEach((saveButton, index) => {
                                            saveButton.addEventListener('click', () => {
                                                const row = saveButton.closest('tr');
                                                const pmethodId = row.querySelector('input').value;
                                                const pmethodNameField = row.querySelector('.pmethod_name');
                                                const editButton = row.querySelector('.edit-btn');

                                                const formData = new FormData();
                                                formData.append('pmethod_id', pmethodId);
                                                formData.append('pmethod_name', pmethodNameField.value);

                                                fetch('../actions/update_payment_method.php', {
                                                        method: 'POST',
                                                        body: formData
                                                    })
                                                    .then(response => response.text())
                                                    .then(result => {
                                                        if (result === 'success') {
                                                            alert('Payment method updated successfully.');
                                                            pmethodNameField.disabled = true;
                                                            saveButton.disabled = true;
                                                            editButton.disabled = false;
                                                        } else {
                                                            alert('Failed to update payment method.');
                                                        }
                                                    })
                                                    .catch(error => console.error('Error:', error));
                                            });
                                        });

                                        deleteButtons.forEach((deleteButton, index) => {
                                            deleteButton.addEventListener('click', () => {
                                                const row = deleteButton.closest('tr');
                                                const pmethodId = row.querySelector('input').value;

                                                if (confirm('Are you sure you want to delete this payment method?')) {
                                                    fetch('../actions/delete_payment_method.php', {
                                                            method: 'POST',
                                                            body: JSON.stringify({
                                                                pmethod_id: pmethodId
                                                            })
                                                        })
                                                        .then(response => response.text())
                                                        .then(result => {
                                                            if (result === 'success') {
                                                                alert('Payment method deleted successfully.');
                                                                row.remove();
                                                            } else {
                                                                alert('Failed to delete payment method.');
                                                            }
                                                        })
                                                        .catch(error => console.error('Error:', error));
                                                }
                                            });
                                        });
                                    });
                                </script>

                                <!-- Add Payment Method -->
                                <div class="ibox-title text-center">
                                    <h2><strong>Add Payment Method</strong></h2>
                                </div>

                                <div class="ibox-content">
                                    <form id="addPaymentMethodForm" action="../actions/add_payment_method.php" method="POST">
                                        <div class="form-group">
                                            <label for="pmethod_name">Payment Method Name:</label>
                                            <input type="text" class="form-control" id="pmethod_name" name="pmethod_name">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Payment Method</button>
                                    </form>
                                </div>
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
                            ?>
                            <div class="ibox">
                                <div class="ibox-title bg-success">
                                    <h2><strong>Dine In Hub | Payments Page</strong></h2>
                                </div>
                                <!-- Order Data Table -->
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
                                    $sql_orders = "SELECT * FROM orders WHERE customer_id = $customer_id AND status IN ('pending', 'success')";
                                    $result_order = $koneksi->query($sql_orders);

                                    if ($result_order->num_rows > 0) { ?>
                                        <table class='table table-striped table-bordered text-center'>
                                            <thead class='thead-dark'>
                                                <tr>
                                                    <th class='text-center' width="80">Order ID</th>
                                                    <th class='text-center'>Order Date</th>
                                                    <th class='text-center' width="100">Status</th>
                                                    <th class='text-center' width="150">Action</th>
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
                                                        <td class='text-center'><?php echo htmlspecialchars($row['order_id']); ?></td>
                                                        <td class='text-center'><?php echo htmlspecialchars($row['order_date']); ?></td>
                                                        <td class='text-center'><span class="label <?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span></td>
                                                        <td class='text-center'><a href='./payment_details.php?order_id=<?php echo htmlspecialchars($row['order_id']); ?>' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#orderModal'>PAY NOW</a></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class='alert alert-warning'>No orders found.</div>
                                    <?php } ?>
                                </div>

                                <!-- Payment Data Title -->
                                <div class="ibox-title text-center bg-info">
                                    <h2><strong>Payment Data Status</strong></h2>
                                </div>

                                <!-- Payment Table Data -->
                                <div class="ibox-content">
                                    <?php
                                    // Query untuk mengambil data pembayaran yang statusnya pending atau success
                                    $sql_payment = "SELECT p.payment_id, p.order_id, pm.pmethod_name, p.payment_date, p.amount, p.status, o.customer_id
                    FROM payment p
                    JOIN payment_methods pm ON p.pmethod_id = pm.pmethod_id
                    JOIN orders o ON p.order_id = o.order_id
                    WHERE p.status IN ('pending', 'success') AND o.customer_id = $customer_id";
                                    $result_payment = $koneksi->query($sql_payment);

                                    if ($result_payment->num_rows > 0) { ?>
                                        <table class='table table-striped table-bordered text-center'>
                                            <thead class='thead-dark'>
                                                <tr>
                                                    <th class='text-center' width="80">Payment ID</th>
                                                    <th class='text-center' width="80">Order ID</th>
                                                    <th class='text-center' width="150">Payment Method</th>
                                                    <th class='text-center'>Payment Date</th>
                                                    <th class='text-center' width="150">Amount</th>
                                                    <th class='text-center' width="100">Confirmation</th>
                                                    <th class='text-center' width="100">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $result_payment->fetch_assoc()) {
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
                                                        <td class='text-center'><?php echo htmlspecialchars($row['payment_id']); ?></td>
                                                        <td class='text-center'><?php echo htmlspecialchars($row['order_id']); ?></td>
                                                        <td class='text-center'><?php echo htmlspecialchars($row['pmethod_name']); ?></td>
                                                        <td class='text-center'><?php echo htmlspecialchars($row['payment_date']); ?></td>
                                                        <td class='text-center'>Rp. <?php echo htmlspecialchars($row['amount']); ?></td>
                                                        <td class='text-center'>
                                                            <?php if ($status == 'pending') { ?>
                                                                <a href="#" class="confirm-payment" data-id="<?php echo $row['payment_id']; ?>">Confirm Here</a>
                                                            <?php } else { ?>
                                                                <span class="text-muted">Confirmed</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td class='text-center'><span class="label <?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class='alert alert-warning'>No Payment Data found.</div>
                                    <?php } ?>
                                </div>

                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                    document.querySelectorAll('.confirm-payment').forEach(function(element) {
                                        element.addEventListener('click', function(event) {
                                            event.preventDefault();
                                            const paymentId = this.getAttribute('data-id');

                                            Swal.fire({
                                                title: 'Apakah Anda Sudah Membayar?',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Sudah',
                                                cancelButtonText: 'Batalkan'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Kirim permintaan AJAX untuk memperbarui status pembayaran
                                                    const xhr = new XMLHttpRequest();
                                                    xhr.open('POST', '../actions/update_payment_status.php', true);
                                                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                                    xhr.onload = function() {
                                                        if (xhr.status === 200 && xhr.responseText === 'success') {
                                                            Swal.fire({
                                                                title: 'Pembayaran Berhasil',
                                                                icon: 'success',
                                                                confirmButtonColor: '#3085d6',
                                                                confirmButtonText: 'OK'
                                                            }).then(() => {
                                                                location.reload(); // Reload halaman setelah sukses
                                                            });
                                                        } else {
                                                            Swal.fire({
                                                                title: 'Error',
                                                                text: 'Gagal memperbarui status pembayaran.',
                                                                icon: 'error',
                                                                confirmButtonColor: '#3085d6',
                                                                confirmButtonText: 'OK'
                                                            });
                                                        }
                                                    };
                                                    xhr.send('payment_id=' + paymentId);
                                                }
                                            });
                                        });
                                    });
                                </script>

                                <!-- Payment Method Variations -->
                                <div class="ibox-title bg-info text-center">
                                    <h2><strong>Payment Method Variations</strong></h2>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Data seluruh jenis metode pembayaran yang dapat digunakan</p>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="40">No.</th>
                                                        <th>Nama Metode Pembayaran</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    // Query to fetch payment methods data
                                                    $sql_pmethod = "SELECT pmethod_id, pmethod_name FROM payment_methods";
                                                    $result_pmethod = $koneksi->query($sql_pmethod);

                                                    if ($result->num_rows > 0) {
                                                        $no = 1;
                                                        // Output data of each row
                                                        while ($pmethod = $result_pmethod->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $no++ . "</td>";
                                                            echo "<td>" . $pmethod["pmethod_name"] . "</td>";

                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='5'>No payment method found.</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Detail Modal -->
                            <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Order details will be loaded here -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Script For Modal View -->
                            <script>
                                $(document).ready(function() {
                                    $('.view-order').click(function() {
                                        var orderId = $(this).data('order-id');

                                        $.ajax({
                                            url: './payment_details.php',
                                            type: 'GET',
                                            data: {
                                                order_id: orderId
                                            },
                                            success: function(response) {
                                                $('#orderModal .modal-body').html(response);
                                            },
                                            error: function() {
                                                $('#orderModal .modal-body').html('<div class="alert alert-danger">Failed to retrieve order details.</div>');
                                            }
                                        });
                                    });
                                });
                            </script>


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
                toastr.success('Payments Page!', 'Dine In HUB');

            }, 1300);
        });
    </script>
</body>

</html>