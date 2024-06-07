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

$sql_food = "SELECT food.food_id, food.restaurant_id, food.food_name, food.price, food.description AS food_description, food.image AS food_image, restaurant.restaurant_name FROM food JOIN restaurant ON food.restaurant_id = restaurant.restaurant_id";
$result_food = $koneksi->query($sql_food);

if (!$result_food) {
    die("Error executing food query: " . $koneksi->error);
}

$foods = [];
if ($result_food->num_rows > 0) {
    while ($row = $result_food->fetch_assoc()) {
        $foods[] = $row;
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
                    <li>
                        <a href="./restaurants.php"><i class="fa-solid fa-store"></i> <span class="nav-label">Restaurants</span></a>
                    </li>
                    <!-- All Menu -->
                    <li>
                        <a href="layouts.html"><i class="fa-solid fa-table-list"></i> <span class="nav-label">All Menu</span></a>
                    </li>
                    <!-- Foods -->
                    <li class="active">
                        <a href="./foods.php"><i class="fa-solid fa-burger"></i> <span class="nav-label">Foods</span></a>
                        </liؤ>
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
                    <!-- Orders -->
                    <li>
                        <a href="layouts.html"><i class="fa-solid fa-cart-flatbed-suitcase"></i> <span class="nav-label">Orders</span></a>
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
                    <h2>Foods</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="./foods.php">Foods</a>
                        </li>
                        <!-- <li class="active">
                            <strong>Restaurants</strong>
                        </li> -->
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <?php if ($level == 'admin') { ?>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title bg-warning">
                                    <h2><strong>Dine In Hub | Manage Foods</strong></h2>
                                </div>
                                <div class="ibox-content m-b-lg">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Kelola makanan restoran Anda </p>
                                        </div>
                                        <div class="col-lg-6">
                                            <a href="javascript:void(0);" onclick="toggleDeleteMode()">
                                                <div class="btn btn-danger btn-block b-r-xl m-t-md">
                                                    <h1><i class="fa-solid fa-minus"></i></h1>
                                                    <h3 class="m-b-xs"><strong>HAPUS MAKANAN</strong></h3>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <a href="./add_food.php">
                                                <div class="btn btn-success btn-block b-r-xl m-t-md">
                                                    <h1><i class="fa-solid fa-plus"></i></h1>
                                                    <h3 class="m-b-xs"><strong>TAMBAH MAKANAN</strong></h3>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-12">
                                            <a href="javascript:void(0);" id="confirmDeleteButton" onclick="confirmDelete()" style="display: none;">
                                                <div class="btn btn-primary btn-block b-r-xl m-t-md">
                                                    <h1><i class="fa-solid fa-check"></i></h1>
                                                    <h3 class="m-b-xs"><strong>KONFIRMASI HAPUS</strong></h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <form id="deleteForm" action="../actions/delete_food_action.php" method="post">
                                    <div class="row">
                                        <?php if (!empty($foods)) : ?>
                                            <?php foreach ($foods as $food) : ?>
                                                <div class="col-lg-3">
                                                    <div class="contact-box center-version">
                                                        <input type="checkbox" name="food_ids[]" value="<?= $food['food_id'] ?>" class="delete-checkbox" style="display: none;">
                                                        <a href="./food_detail.php?id=<?php echo $food['food_id']; ?>">
                                                            <h3 class="m-b-xs"><strong><?= htmlspecialchars($food['food_name']) ?></strong></h3><br>
                                                            <img alt="image" class="img-fluid img-circle" style="max-width: 100%; max-height: 100%; object-fit: cover; display: block; margin: 0 auto;" src="<?= htmlspecialchars($food['food_image']) ?>"><br>
                                                            <div class="font-bold">Rp. <?= htmlspecialchars($food['price']) ?></div>
                                                            <address class="m-t-md">
                                                                <strong><?= htmlspecialchars($food['restaurant_name']) ?></strong><br>
                                                                <p><?= htmlspecialchars($food['food_description']) ?></p>
                                                            </address>
                                                        </a>
                                                        <div class="contact-box-footer">
                                                            <div class="m-t-xs btn-group">
                                                                <a href="#" class="btn btn-xs btn-white bg-info"><i class="fa-solid fa-cart-shopping"></i> Edit Food </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p>No foods available</p>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } elseif ($level == 'customer') { ?>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title bg-warning">
                                    <h2><strong>Dine In Hub | Foods</strong></h2>
                                </div>
                                <div class="ibox-content m-b-lg">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Selamat memilih makanan favorit Anda </p>
                                        </div>
                                    </div>
                                </div>
                                <form id="deleteForm" action="../actions/delete_food_action.php" method="post">
                                    <div class="row">
                                        <?php if (!empty($foods)) : ?>
                                            <?php foreach ($foods as $food) : ?>
                                                <div class="col-lg-3">
                                                    <div class="contact-box center-version">
                                                        <input type="checkbox" name="food_ids[]" value="<?= $food['food_id'] ?>" class="delete-checkbox" style="display: none;">
                                                        <a href="./food_detail.php?id=<?php echo $food['food_id']; ?>">
                                                            <h3 class="m-b-xs"><strong><?= htmlspecialchars($food['food_name']) ?></strong></h3><br>
                                                            <img alt="image" class="img-fluid img-circle" style="max-width: 100%; max-height: 100%; object-fit: cover; display: block; margin: 0 auto;" src="<?= htmlspecialchars($food['food_image']) ?>"><br>
                                                            <div class="font-bold">Rp. <?= htmlspecialchars($food['price']) ?></div>
                                                            <address class="m-t-md">
                                                                <strong><?= htmlspecialchars($food['restaurant_name']) ?></strong><br>
                                                                <p><?= htmlspecialchars($food['food_description']) ?></p>
                                                            </address>
                                                        </a>
                                                        <div class="contact-box-footer">
                                                            <div class="m-t-xs btn-group">
                                                                <a href="./food_detail.php?id=<?php echo $food['food_id']; ?>" class="btn btn-xs btn-white bg-info"><i class="fa-solid fa-cart-shopping"></i> View Food </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p>No foods available</p>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <? } else { ?>
                <!-- Code if user isn't customer and admin role -->
            <?php } ?>


        </div>


    </div>
    </div>

    <!-- Script to hidden confirm button -->
    <script>
        function toggleDeleteMode() {
            var checkboxes = document.getElementsByClassName('delete-checkbox');
            var confirmButton = document.getElementById('confirmDeleteButton');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].style.display = checkboxes[i].style.display === 'block' ? 'none' : 'block';
            }
            confirmButton.style.display = confirmButton.style.display === 'block' ? 'none' : 'block';
        }

        function confirmDelete() {
            var checkedBoxes = document.querySelectorAll('input.delete-checkbox:checked');
            var ids = Array.from(checkedBoxes).map(cb => cb.value);
            if (ids.length > 0) {
                if (confirm("Are you sure you want to delete the selected foods?")) {
                    document.getElementById('deleteForm').submit();
                }
            } else {
                alert("No foods selected for deletion.");
            }
        }
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