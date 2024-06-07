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
                        <a href="layouts.html"><i class="fa-solid fa-table-list"></i> <span class="nav-label">All Menu</span></a>
                    </li>
                    <!-- Foods -->
                    <li>
                        <a href="./foods.php"><i class="fa-solid fa-burger"></i> <span class="nav-label">Foods</span></a>
                    </li>
                    <!-- Drinks -->
                    <li>
                        <a href="mailbox.html"><i class="fa-solid fa-mug-hot"></i> <span class="nav-label">Drinks </span></a>
                    </li>
                    <!-- Appetizers -->
                    <li>
                        <a href="metrics.html"><i class="fa-solid fa-shrimp"></i> <span class="nav-label">Appetizers</span> </a>
                    </li>
                    <!-- Desserts -->
                    <li>
                        <a href="widgets.html"><i class="fa-solid fa-ice-cream"></i> <span class="nav-label">Desserts</span></a>
                    </li>
                    <!-- Gallery -->
                    <li>
                        <a href="./empty_page.php"><i class="fa fa-desktop"></i> <span class="nav-label">Gallery</span> <span class="pull-right label label-primary">SPECIAL</span></a>
                    </li>
                    <!-- Vouchers -->
                    <li class="active">
                        <a href="./vouchers.php"><i class="fa-solid fa-ticket"></i> <span class="nav-label">Vouchers</span></a>
                    </li>
                    <!-- Orders -->
                    <li>
                        <a href="./orders.php"><i class="fa-solid fa-cart-flatbed-suitcase"></i> <span class="nav-label">Orders</span></a>
                    </li>
                    <!-- History -->
                    <li>
                        <a href="layouts.html"><i class="fa-solid fa-file-waveform"></i> <span class="nav-label">History</span></a>
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
                    <h2>Vouchers</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="./vouchers.php">Vouchers</a>
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
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12 ">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h2>Hi <strong><?php echo htmlspecialchars($username) ?></strong></h2>
                                </div>
                                <div class="ibox-title bg-primary">
                                    <h2>Welcome to <strong>Dine In Hub | Vouchers Page</strong></h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <!-- Single Insert Form View -->
                            <div class="ibox">
                                <div class="ibox-title bg-success">
                                    <h2><strong>Single Insert Voucher</strong></h2>
                                </div>
                                <div class="ibox-content">
                                    <form action="../actions/add_voucher_single_action.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="nama_voucher">Nama Voucher:</label>
                                            <input type="text" id="nama_voucher" name="nama_voucher" class="form-control" placeholder="Enter voucher name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="code">Kode:</label>
                                            <input type="text" id="code" name="code" class="form-control" placeholder="Enter voucher code" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="discount">Diskon:</label>
                                            <input type="number" step="0.01" id="discount" name="discount" class="form-control" placeholder="Enter discount (e.g. 10.00)" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="expiry_date">Tanggal Kadaluarsa:</label>
                                            <input type="date" id="expiry_date" name="expiry_date" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-outline btn-primary btn-block">Tambah Voucher</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Notification Alert UI for Multi Insert Voucher  -->
                            <div id="alert-data-success" class="alert alert-success alert-dismissable" style="display: none;">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <span id="success-message">Data Voucher berhasil diperbarui.</span>
                            </div>
                            <div id="alert-data-danger" class="alert alert-danger alert-dismissable" style="display: none;">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <span id="error-message">Data Voucher gagal diperbarui.</span>
                            </div>

                            <!-- Form Multi Insert Voucher -->
                            <div class="ibox">
                                <div class="ibox-title bg-success">
                                    <h2><strong>Multi Insert Voucher</strong></h2>
                                </div>
                                <div class="ibox-content">
                                    <!-- Form Multi Insert 3 Baris dalam format tabel -->
                                    <form id="voucherForm" action="../actions/add_voucher_multi_action.php" method="post" enctype="multipart/form-data">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Voucher</th>
                                                    <th>Kode</th>
                                                    <th>Diskon</th>
                                                    <th>Tanggal Kadaluarsa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Voucher 1 -->
                                                <tr>
                                                    <td><input type="text" id="nama_voucher1" name="nama_voucher[]" class="form-control" placeholder="Enter voucher name" required></td>
                                                    <td><input type="text" id="code1" name="code[]" class="form-control" placeholder="Enter voucher code" required></td>
                                                    <td><input type="number" step="0.01" id="discount1" name="discount[]" class="form-control" placeholder="Enter discount (e.g. 10.00)" required></td>
                                                    <td><input type="date" id="expiry_date1" name="expiry_date[]" class="form-control" required></td>
                                                </tr>
                                                <!-- Voucher 2 -->
                                                <tr>
                                                    <td><input type="text" id="nama_voucher2" name="nama_voucher[]" class="form-control" placeholder="Enter voucher name" required></td>
                                                    <td><input type="text" id="code2" name="code[]" class="form-control" placeholder="Enter voucher code" required></td>
                                                    <td><input type="number" step="0.01" id="discount2" name="discount[]" class="form-control" placeholder="Enter discount (e.g. 10.00)" required></td>
                                                    <td><input type="date" id="expiry_date2" name="expiry_date[]" class="form-control" required></td>
                                                </tr>
                                                <!-- Voucher 3 -->
                                                <tr>
                                                    <td><input type="text" id="nama_voucher3" name="nama_voucher[]" class="form-control" placeholder="Enter voucher name" required></td>
                                                    <td><input type="text" id="code3" name="code[]" class="form-control" placeholder="Enter voucher code" required></td>
                                                    <td><input type="number" step="0.01" id="discount3" name="discount[]" class="form-control" placeholder="Enter discount (e.g. 10.00)" required></td>
                                                    <td><input type="date" id="expiry_date3" name="expiry_date[]" class="form-control" required></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-outline btn-primary btn-block">Tambah Voucher</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Notification Alert UI -->
                            <div id="alert-data-success" class="alert alert-success alert-dismissable" style="display: none;">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                Data Voucher berhasil diperbarui.
                            </div>
                            <div id="alert-data-danger" class="alert alert-danger alert-dismissable" style="display: none;">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                Data Voucher gagal diperbarui.
                            </div>

                            <!-- Multi Update, Delete Voucher Data-->
                            <div class="ibox">
                                <div class="ibox-title bg-success">
                                    <h2><strong>Edit Daftar Voucher</strong></h2>
                                </div>
                                <div class="ibox-content">
                                    <form id="voucherForm" action="../actions/update_voucher_action.php" method="post">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Nama Voucher</th>
                                                    <th>Kode</th>
                                                    <th>Diskon</th>
                                                    <th>Tanggal Kadaluarsa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // make sure to Include database connection file before
                                                // Query to fetch voucher data
                                                $query = "SELECT voucher_id, nama_voucher, code, discount, expiry_date FROM voucher";
                                                $result = $koneksi->query($query);

                                                if ($result->num_rows > 0) {
                                                    // Output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td><input type='checkbox' class='edit-check' value='" . $row["voucher_id"] . "'disabled></td>";
                                                        echo "<td>" . $row["voucher_id"] . "</td>";
                                                        echo "<td><input type='text' class='form-control edit-input' name='nama_voucher[" . $row["voucher_id"] . "]' value='" . $row["nama_voucher"] . "' disabled></td>";
                                                        echo "<td><input type='text' class='form-control edit-input' name='code[" . $row["voucher_id"] . "]' value='" . $row["code"] . "' disabled></td>";
                                                        echo "<td><input type='number' step='0.01' class='form-control edit-input' name='discount[" . $row["voucher_id"] . "]' value='" . number_format($row["discount"], 2) . "' disabled></td>";
                                                        echo "<td><input type='date' class='form-control edit-input' name='expiry_date[" . $row["voucher_id"] . "]' value='" . $row["expiry_date"] . "' disabled></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6'>No vouchers found.</td></tr>";
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- Button Edit & Save Update Data -->
                                        <button type="button" id="editButton" class="btn btn-outline btn-primary btn-block m-b-sm">Edit</button>
                                        <button type="submit" id="saveButton" class="btn btn-outline btn-success btn-block m-b-sm" style="display: none;">Save</button>
                                    </form>
                                    <button type="button" id="deleteButton" class="btn btn-outline btn-danger btn-block">Delete</button>
                                </div>
                            </div>

                            <!-- View Data Vouchers with ID and No.-->
                            <div class="ibox">
                                <div class="ibox-title bg-success">
                                    <h2><strong>Daftar Voucher Berdasarkan ID</strong></h2>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Voucher</th>
                                                <th>Nama Voucher</th>
                                                <th>Kode</th>
                                                <th>Diskon</th>
                                                <th>Tanggal Kadaluarsa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Include database connection file
                                            include "../includes/db_connect.php";

                                            // Query to fetch voucher data
                                            $query = "SELECT voucher_id, nama_voucher, code, discount, expiry_date FROM voucher";
                                            $result = $koneksi->query($query);

                                            if ($result->num_rows > 0) {
                                                $no = 1;
                                                // Output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $no++ . "</td>";
                                                    echo "<td>" . $row["voucher_id"] . "</td>";
                                                    echo "<td>" . $row["nama_voucher"] . "</td>";
                                                    echo "<td>" . $row["code"] . "</td>";
                                                    echo "<td>" . number_format($row["discount"], 2) . "</td>";
                                                    echo "<td>" . $row["expiry_date"] . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No vouchers found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- View for Customer Role -->
    <?php } elseif ($level == 'customer') { ?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-title dashboard-header">
                        <h2>Orders Page | <strong><?php echo htmlspecialchars($username); ?></strong></h2>
                    </div>
                    <div class="ibox-content ">

                    </div>

                    <!-- View Data Vouchers -->
                    <div class="ibox">
                        <div class="ibox-title bg-success">
                            <h2><strong>Daftar Voucher</strong></h2>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Voucher</th>
                                        <th>Kode</th>
                                        <th>Diskon</th>
                                        <th>Tanggal Kadaluarsa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // make sure Include database connection file
                                    // Query to fetch voucher data
                                    $query = "SELECT nama_voucher, code, discount, expiry_date FROM voucher";
                                    $result = $koneksi->query($query);

                                    if ($result->num_rows > 0) {
                                        $no = 1; // Initialize the counter variable
                                        // Output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>" . $row["nama_voucher"] . "</td>";
                                            echo "<td>" . $row["code"] . "</td>";
                                            echo "<td>" . number_format($row["discount"], 2) . "</td>";
                                            echo "<td>" . $row["expiry_date"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No vouchers found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
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
    <!-- Script to handle Multi Insert Vouchers -->
    <script>
        document.getElementById('voucherForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('success-message').textContent = data.message;
                        document.getElementById('alert-data-success').style.display = 'block';
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        document.getElementById('error-message').textContent = data.message;
                        document.getElementById('alert-data-danger').style.display = 'block';
                    }
                })
                .catch(error => {
                    document.getElementById('error-message').textContent = "An error occurred.";
                    document.getElementById('alert-data-danger').style.display = 'block';
                });
        });
    </script>

    <!-- Script to handle Multi Update And Delete Vouchers -->
    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            var editChecks = document.querySelectorAll('.edit-check');
            var editInputs = document.querySelectorAll('.edit-input');

            editChecks.forEach(function(check) {
                check.disabled = false;
            });
            editInputs.forEach(function(input) {
                input.disabled = false;
            });

            document.getElementById('editButton').style.display = 'none';
            document.getElementById('saveButton').style.display = 'block';
        });

        document.getElementById('voucherForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            fetch('../actions/update_voucher_action.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('alert-data-success').style.display = 'block';
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        document.getElementById('alert-data-danger').style.display = 'block';
                    }
                })
                .catch(error => {
                    document.getElementById('alert-data-danger').style.display = 'block';
                });
        });

        document.getElementById('deleteButton').addEventListener('click', function() {
            var editChecks = document.querySelectorAll('.edit-check:checked');
            if (editChecks.length > 0) {
                if (confirm('Are you sure you want to delete selected vouchers?')) {
                    var formData = new FormData();
                    editChecks.forEach(function(check) {
                        formData.append('voucher_id[]', check.value);
                    });
                    fetch('../actions/delete_voucher_action.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Failed to delete vouchers.');
                            }
                        })
                        .catch(error => {
                            alert('Failed to delete vouchers.');
                        });
                }
            } else {
                alert('Please select vouchers to delete.');
            }
        });
    </script>

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