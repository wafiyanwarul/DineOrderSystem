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

// Ambil data restoran
$sql_restaurant = "SELECT restaurant_id, restaurant_name FROM restaurant";
$result_restaurant = $koneksi->query($sql_restaurant);

if (!$result_restaurant) {
    die("Error executing restaurant query: " . $koneksi->error);
}

$restaurants = [];
if ($result_restaurant->num_rows > 0) {
    while ($row = $result_restaurant->fetch_assoc()) {
        $restaurants[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Dine In Hub | Foods</title>

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
    <link href="../assets/inspinia/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="../assets/inspinia/css/plugins/codemirror/codemirror.css" rel="stylesheet">

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
                                <li><a href="contacts.html">Dashboard</a></li>
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
                    <li class="active">
                        <a href="layouts.html"><i class="fa-solid fa-burger"></i> <span class="nav-label">Foods</span></a>
                    </li>
                    <!-- Drinks -->
                    <li>
                        <a href="mailbox.html"><i class="fa-solid fa-mug-hot"></i> <span class="nav-label">Drinks </span><span class="label label-warning pull-right">16/24</span></a>
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
                        <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">Gallery</span> <span class="pull-right label label-primary">SPECIAL</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="contacts.html">Contacts</a></li>
                        </ul>
                    </li>
                    <!-- Vouchers -->
                    <li>
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
                        <ul class="nav nav-second-level collapse">
                            <li><a href="toastr_notifications.html">Notification</a></li>
                        </ul>
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
                    <h2>Foods</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="./foods.php">Foods</a>
                        </li>
                        <li class="active">
                            <strong>Add Food</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>

            <?php if ($level == 'admin') { ?>
                <div class="wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-8 b-r">
                            <?php if (isset($_SESSION['notification'])) : ?>
                                <?php if ($_SESSION['notification']['type'] == 'success') : ?>
                                    <div id="alert-image-success" class="alert alert-success alert-dismissable">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <?= $_SESSION['notification']['message'] ?>
                                    </div>
                                <?php else : ?>
                                    <div id="alert-image-danger" class="alert alert-danger alert-dismissable">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <?= $_SESSION['notification']['message'] ?>
                                    </div>
                                <?php endif; ?>
                                <?php unset($_SESSION['notification']); ?>
                            <?php endif; ?>
                            <div class="ibox">
                                <div class="ibox-title bg-success">
                                    <h1 class="m-t-none m-b">Tambah Makanan</h1>
                                    <p>Makanan yang ditambahkan akan dapat dilihat di menu customer</p>
                                </div>
                                <div class="ibox-content">
                                    <form action="../actions/add_food_action.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="restaurant_id">Pilih Restoran:</label>
                                            <select id="restaurant_id" name="restaurant_id" class="form-control" required>
                                                <!-- Ambil data restoran dari database dan tampilkan sebagai opsi -->
                                                <?php
                                                include 'koneksi.php'; // Pastikan file koneksi di-include
                                                $sql_restaurant = "SELECT restaurant_id, restaurant_name FROM restaurant";
                                                $result_restaurant = $koneksi->query($sql_restaurant);
                                                if ($result_restaurant->num_rows > 0) {
                                                    while ($row = $result_restaurant->fetch_assoc()) {
                                                        echo "<option value='" . $row['restaurant_id'] . "'>" . $row['restaurant_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="food_name">Nama Makanan:</label>
                                            <input type="text" id="food_name" name="food_name" class="form-control" placeholder="Enter food name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Harga:</label>
                                            <input type="text" id="price" name="price" class="form-control" placeholder="Enter price" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Deskripsi:</label>
                                            <textarea id="description" name="description" class="form-control" placeholder="Enter description" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Gambar:</label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" id="file" name="image"></span>
                                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">Tambah Makanan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    <?php } elseif ($level == 'customer') { ?>

    <? } else { ?>
        <!-- Code if user isn't customer and admin role -->
    <?php } ?>

    </div>

    <!-- Script for Dropzone File Upload -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.7/js/fileinput.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../assets/inspinia/js/inspinia.js"></script>
    <script src="../assets/inspinia/js/plugins/pace/pace.min.js"></script>

    <!-- Jasny -->
    <script src="../assets/inspinia/js/plugins/jasny/jasny-bootstrap.min.js"></script>

    <!-- CodeMirror -->
    <script src="../assets/inspinia/js/plugins/codemirror/codemirror.js"></script>
    <script src="../assets/inspinia/js/plugins/codemirror/mode/xml/xml.js"></script>

    <!-- Mainly scripts -->
    <script src="../assets/inspinia/js/jquery-3.1.1.min.js"></script>
    <script src="../assets/inspinia/js/bootstrap.min.js"></script>
    <script src="../assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

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