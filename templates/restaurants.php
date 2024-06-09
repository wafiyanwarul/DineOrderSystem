<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    die("<h1><center>Anda belum login</h1></center>");
}

// Mendapatkan data user dari session atau database
$username = $_SESSION['username'];
$sql = "SELECT username, level FROM user WHERE username = '$username'";
$result = $koneksi->query($sql);

if (!$result) {
    die("Error executing query: " . $koneksi->error);
}

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

// Mengambil semua data dari tabel restaurant
$sql_restaurant = "SELECT restaurant_id, restaurant_name, address, phone, description, image FROM restaurant";
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

    <title>Dine In Hub | Restaurants</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon_io/apple-touch-icon.png">

    <link rel="manifest" href="../assets/favicon_io/site.webmanifest">

    <!-- Main Favicon -->
    <link rel="shortcut icon" href="../assets/favicon_io/favicon.ico" type="image/x-icon">

    <link href="../assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/inspinia/css/animate.css" rel="stylesheet">
    <link href="../assets/inspinia/css/style.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="../assets/inspinia/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="../assets/inspinia/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

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
                                <li><a href="./profile.php">Profile</a></li>
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
                    <li class="active">
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
                        <a href="./drinks.php"><i class="fa-solid fa-mug-hot"></i> <span class="nav-label">Drinks </span><span class="label label-warning pull-right">16/24</span></a>
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
                    <li>
                        <a href="./vouchers.php"><i class="fa-solid fa-ticket"></i> <span class="nav-label">Orders</span></a>
                    </li>
                    <!-- Orders -->
                    <li>
                        <a href="./orders.php"><i class="fa-solid fa-cart-flatbed-suitcase"></i> <span class="nav-label">Vouchers</span></a>
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
                    <h2>Restaurants</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="./restaurants.php">Restaurants</a>
                        </li>
                        <!-- <li class="active">
                            <strong>Restaurants</strong>
                        </li> -->
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>

            <!-- View for User Admin Role -->
            <?php if ($level == 'admin') { ?>
                <div class="wrapper wrapper-content animated-fadeInRight">
                    <div class="col-lg-12">
                        <div class="ibox-title bg-primary">
                            <h2><strong>Dine In Hub | Manage Restaurant </strong></h2>
                        </div>
                        <div class="ibox-content m-b-none">
                            <p>Kelola restoran Anda </p>
                            <a class="bg-success" href="./add_restaurant.php">
                                <div class="btn btn-success btn-block dim b-r-xl">
                                    <h1><i class="fa-solid fa-plus"></i></h1>
                                    <h3 class="m-b-xs"><strong>TAMBAH</strong></h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <?php if (!empty($restaurants)) : ?>
                            <?php foreach ($restaurants as $restaurant) : ?>
                                <div class="col-lg-3">
                                    <div class="contact-box center-version">
                                        <a href="./restaurant_detail.php?id=<?php echo $restaurant['restaurant_id']; ?>">
                                            <h3 class="m-b-xs"><strong><?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?></strong></h3><br>
                                            <img alt="image" class="img-fluid img-circle" style="max-width: 100%; max-height: 100%; object-fit: cover; display: block; margin: 0 auto;" src="../<?php echo htmlspecialchars($restaurant['image'] ?? ''); ?>"><br>
                                            <div class="font-bold"><?php echo htmlspecialchars($restaurant['address'] ?? ''); ?></div>
                                            <address class="m-t-md">
                                                <strong><?php echo htmlspecialchars($restaurant['phone'] ?? ''); ?></strong><br>
                                                <p><?php echo htmlspecialchars($restaurant['description'] ?? ''); ?></p>
                                            </address>
                                        </a>
                                        <div class="contact-box-footer">
                                            <div class="m-t-xs btn-group">
                                                <a href="./restaurant_detail.php?id=<?php echo $restaurant['restaurant_id']; ?>" class="btn btn-xs btn-white bg-info"><i class="fa-solid fa-cart-shopping"></i> Edit Restaurant </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
        </div>

        <!-- View for User Customer Role -->
    <?php } elseif ($level == 'customer') { ?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <?php if (!empty($restaurants)) : ?>
                    <?php foreach ($restaurants as $restaurant) : ?>
                        <div class="col-lg-3">
                            <div class="contact-box center-version">
                                <a href="./restaurant_detail.php?id=<?php echo $restaurant['restaurant_id']; ?>">
                                    <img alt="image" style="max-width: 100%; max-height: 100%; object-fit: cover; display: block; margin: 0 auto;" class="img-fluid img-circle" src="../<?php echo htmlspecialchars($restaurant['image'] ?? ''); ?>">
                                    <h3 class="m-b-xs"><strong><?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?></strong></h3>
                                    <div class="font-bold"><?php echo htmlspecialchars($restaurant['address'] ?? ''); ?></div>
                                    <address class="m-t-md">
                                        <strong><?php echo htmlspecialchars($restaurant['phone'] ?? ''); ?></strong><br>
                                        <p><?php echo htmlspecialchars($restaurant['description'] ?? ''); ?></p>
                                    </address>
                                </a>
                                <div class="contact-box-footer">
                                    <div class="m-t-xs btn-group">
                                        <a href="./restaurant_detail.php?id=<?php echo $restaurant['restaurant_id']; ?>" class="btn btn-xs btn-white bg-info"><i class="fa-solid fa fa-eye"></i> View Restaurant </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <? } else { ?>
        <!-- Code if user isn't customer and admin role -->
    <?php } ?>


    </div>


    </div>
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('Restaurants Page', 'Dine In Hub');

            }, 1300);
        });
    </script>
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