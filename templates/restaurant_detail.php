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

// Mendapatkan ID restoran dari URL
$restaurant_id = $_GET['id'] ?? null;

if ($restaurant_id === null) {
    die("Restaurant ID is missing.");
}

// Mengambil data restoran berdasarkan ID
$sql = "SELECT restaurant_name, address, phone, description, image FROM restaurant WHERE restaurant_id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param('i', $restaurant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Restaurant not found.");
}

$restaurant = $result->fetch_assoc();

// Mengambil data makanan berdasarkan restaurant_id
$sql_foods = "SELECT * FROM food WHERE restaurant_id = ?";
$stmt_foods = $koneksi->prepare($sql_foods);
$stmt_foods->bind_param('i', $restaurant_id);
$stmt_foods->execute();
$result_foods = $stmt_foods->get_result();

$foods = [];
while ($food = $result_foods->fetch_assoc()) {
    $foods[] = $food;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Dine In Hub | <?php echo htmlspecialchars($restaurant['restaurant_name']); ?></title>

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

    <!-- File input CSS -->
    <link href="path/to/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet">

    <!-- File input JS -->
    <script src="path/to/bootstrap-fileinput/js/fileinput.min.js"></script>


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
                        <li class="active">
                            <strong><?php echo htmlspecialchars($restaurant['restaurant_name']); ?></strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>

            <?php if ($level == 'admin') { ?>

                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox btn-block float-e-margins">
                                <div class="ibox-title bg-primary" style="display: flex; align-items: center; justify-content: space-between;">
                                    <h2 class="m-b-sm">Update Restaurant Data : <strong id="restaurant-name-display"><?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?></strong></h2>
                                    <div class="ibox-tools">
                                        <button id="save-data-btn" class="btn btn-danger" type="button" style="display: none;"><i class="fa fa-check"></i>&nbsp;Save</button>
                                        <button id="edit-data-btn" class="btn btn-warning" type="button"><i class="fa fa-paste"></i> Edit</button>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div id="alert-data-success" class="alert alert-success alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        Data Restoran <a class="alert-link" href="#" id="alert-data-success-link"><?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?></a> berhasil diperbarui.
                                    </div>
                                    <div id="alert-data-danger" class="alert alert-danger alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        Data Restoran <a class="alert-link" href="#" id="alert-data-danger-link"><?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?></a> gagal diperbarui.
                                    </div>
                                    <form id="restaurant-data-form" action="update_restaurant_data.php" method="post">
                                        <div class="form-group">
                                            <label for="restaurant_name">Name:</label>
                                            <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" value="<?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address:</label>
                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($restaurant['address'] ?? ''); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone Number:</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($restaurant['phone'] ?? ''); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea class="form-control" id="description" name="description" readonly><?php echo htmlspecialchars($restaurant['description'] ?? ''); ?></textarea>
                                        </div>
                                        <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">
                                    </form>
                                </div>
                            </div>
                            <div class="ibox btn-block float-e-margins">
                                <div class="ibox-title bg-primary" style="display: flex; align-items: center; justify-content: space-between;">
                                    <h2 class="m-b-sm">Update Image : <strong id="restaurant-image-display"><?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?></strong></h2>
                                    <div class="ibox-tools">
                                        <button id="save-image-btn" class="btn btn-danger" type="button" style="display: none;"><i class="fa fa-check"></i>&nbsp;Save</button>
                                        <button id="edit-image-btn" class="btn btn-warning" type="button"><i class="fa fa-paste"></i> Edit</button>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div id="alert-image-success" class="alert alert-success alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        Gambar Restoran <a class="alert-link" href="#" id="alert-image-success-link"><?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?></a> berhasil diperbarui.
                                    </div>
                                    <div id="alert-image-danger" class="alert alert-danger alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        Gambar Restoran <a class="alert-link" href="#" id="alert-image-danger-link"><?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?></a> gagal diperbarui.
                                    </div>
                                    <form id="restaurant-image-form" action="../actions/update_restaurant_image.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="image">Image:</label>
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="form-control" data-trigger="fileinput">
                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                                <span class="input-group-addon btn btn-default btn-file">
                                                    <span class="fileinput-new">Select file</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" id="file" name="image" disabled>
                                                </span>
                                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                        <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } elseif ($level == 'customer') { ?>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title bg-info">
                                    <h2 class="m-b-xs m-b-sm"><strong><?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?></strong></h2>
                                </div>
                                <div class="ibox-content">
                                    <form id="restaurant-data-form">
                                        <br>
                                        <img alt="image" class="img-fluid b-r-xl" style="max-width: 50vh; max-height: 50vh; object-fit: cover; display: block; margin: 0 auto;" src="../<?php echo htmlspecialchars($restaurant['image'] ?? ''); ?>">
                                        <div class="form-group m-t-lg">
                                            <label for="restaurant_name">Name:</label>
                                            <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" value="<?php echo htmlspecialchars($restaurant['restaurant_name'] ?? ''); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address:</label>
                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($restaurant['address'] ?? ''); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone Number:</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($restaurant['phone'] ?? ''); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea class="form-control" id="description" name="description" readonly><?php echo htmlspecialchars($restaurant['description'] ?? ''); ?></textarea>
                                        </div>
                                    </form>
                                </div>

                                <div class="ibox float-e-margins">
                                    <!-- Foods Restaurant Content based on Each Resto ID -->
                                    <div class="ibox-title bg-warning">
                                        <h2 class="m-b-xs m-b-sm"><strong>Menu</strong></h2>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <?php if (!empty($foods)) : ?>
                                                <?php foreach ($foods as $food) : ?>
                                                    <div class="col-lg-3">
                                                        <div class="contact-box center-version">
                                                            <a href="./food_detail.php?id=<?php echo $food['food_id']; ?>">
                                                                <img alt="image" style="max-width: 100%; max-height: 100%; object-fit: cover; display: block; margin: 0 auto;" class="img-fluid img-circle" src="../<?php echo htmlspecialchars($food['image'] ?? ''); ?>">
                                                                <h3 class="m-b-xs"><strong><?php echo htmlspecialchars($food['food_name'] ?? ''); ?></strong></h3>
                                                                <div class="font-bold"><?php echo htmlspecialchars($food['price'] ?? ''); ?></div>
                                                                <address class="m-t-md">
                                                                    <p><?php echo htmlspecialchars($food['description'] ?? ''); ?></p>
                                                                </address>
                                                            </a>
                                                            <div class="contact-box-footer">
                                                                <div class="m-t-xs btn-group">
                                                                    <a href="./food_detail.php?id=<?php echo $food['food_id']; ?>" class="btn btn-xs btn-white bg-info"><i class="fa-solid fa fa-eye"></i> View Food</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <p class="m-l-sm m-t-sm">No foods found for this restaurant.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } else { ?>
                <!-- Code if user isn't customer and admin role -->
            <?php } ?>
        </div>
    </div>

    <!-- JS for Edit and Save Restaurant Data Only-->
    <script>
        document.getElementById('edit-data-btn').addEventListener('click', function() {
            document.querySelectorAll('#restaurant-data-form input, #restaurant-data-form textarea').forEach(function(element) {
                element.removeAttribute('readonly');
            });
            document.getElementById('save-data-btn').style.display = 'inline-block';
            document.getElementById('edit-data-btn').style.display = 'none';
        });

        document.getElementById('save-data-btn').addEventListener('click', function() {
            var formData = new FormData(document.getElementById('restaurant-data-form'));

            fetch('../actions/update_restaurant_data.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    document.getElementById('alert-data-success').style.display = 'block';
                    document.getElementById('alert-data-success-link').innerText = data.restaurant_name;
                    setTimeout(function() {
                        location.reload(); // Refresh halaman setelah 2 detik
                    }, 500);
                } else {
                    document.getElementById('alert-data-danger').style.display = 'block';
                    document.getElementById('alert-data-danger-link').innerText = data.restaurant_name;
                }
            }).catch(error => {
                document.getElementById('alert-data-danger').style.display = 'block';
                document.getElementById('alert-data-danger-link').innerText = 'an error occurred';
            });

            document.getElementById('save-data-btn').style.display = 'none';
            document.getElementById('edit-data-btn').style.display = 'inline-block';
        });
    </script>

    <!-- JS for Edit and Save Restaurant Photo Only-->
    <script>
        document.getElementById('edit-image-btn').addEventListener('click', function() {
            document.getElementById('file').removeAttribute('disabled');
            document.getElementById('save-image-btn').style.display = 'inline-block';
            document.getElementById('edit-image-btn').style.display = 'none';
        });

        document.getElementById('save-image-btn').addEventListener('click', function() {
            var formData = new FormData(document.getElementById('restaurant-image-form'));

            fetch('../actions/update_restaurant_image.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    document.getElementById('alert-image-success').style.display = 'block';
                    document.getElementById('alert-image-success-link').innerText = data.restaurant_name || 'Restaurant';
                    setTimeout(function() {
                        location.reload(); // Refresh halaman setelah 2 detik
                    }, 1000);
                } else {
                    document.getElementById('alert-image-danger').style.display = 'block';
                    document.getElementById('alert-image-danger-link').innerText = data.restaurant_name || 'an error occurred';
                }
            }).catch(error => {
                document.getElementById('alert-image-danger').style.display = 'block';
                document.getElementById('alert-image-danger-link').innerText = 'an error occurred';
            });

            document.getElementById('file').setAttribute('disabled', 'true');
            document.getElementById('save-image-btn').style.display = 'none';
            document.getElementById('edit-image-btn').style.display = 'inline-block';
        });
    </script>

    <!-- JS for Toastr -->
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('<?php echo htmlspecialchars($restaurant['restaurant_name']); ?>', 'Dine In Hub');

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