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

// Mendapatkan ID makanan dari URL
$food_id = $_GET['id'] ?? null;

if ($food_id === null) {
    die("Food ID is missing.");
}

// Mengambil data makanan berdasarkan ID
$sql_food = "SELECT food.food_id, food.food_name, food.price, food.description, food.image, restaurant.restaurant_name 
        FROM food 
        JOIN restaurant ON food.restaurant_id = restaurant.restaurant_id 
        WHERE food.food_id = ?";
$stmt = $koneksi->prepare($sql_food);
$stmt->bind_param('i', $food_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Food not found.");
}

$food = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Dine In Hub | <?php echo htmlspecialchars($food['food_name']); ?></title>

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
                                <li><a href="./profile.php">Profile</a></li>
                                <li><a href="./dashboard.php">Dashboard</a></li>
                                <li class="divider"></li>
                                <li><a href="./logout.php">Logout</a></li>
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
                        <li class="active">
                            <strong><?php echo htmlspecialchars($food['food_name']); ?></strong>
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
                                    <h2 class="m-b-sm">Update Data Makanan: <strong id="food-name-display"><?php echo htmlspecialchars($food['food_name']); ?></strong></h2>
                                    <div class="ibox-tools">
                                        <button id="save-data-btn" class="btn btn-danger" type="button" style="display: none;"><i class="fa fa-check"></i>&nbsp;Save</button>
                                        <button id="edit-data-btn" class="btn btn-warning" type="button"><i class="fa fa-paste"></i> Edit</button>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div id="alert-data-success" class="alert alert-success alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        Data Makanan <a class="alert-link" href="#" id="alert-data-success-link"><?php echo htmlspecialchars($food['food_name']); ?></a> berhasil diperbarui.
                                    </div>
                                    <div id="alert-data-danger" class="alert alert-danger alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        Data Makanan <a class="alert-link" href="#" id="alert-data-danger-link"><?php echo htmlspecialchars($food['food_name']); ?></a> gagal diperbarui.
                                    </div>

                                    <form id="food-data-form" action="update_food_data.php" method="post">
                                        <div class="form-group">
                                            <label for="food_name">Nama Makanan:</label>
                                            <input type="text" class="form-control" id="food_name" name="food_name" value="<?php echo htmlspecialchars($food['food_name']); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="restaurant_id">Nama Restoran:</label>
                                            <select id="restaurant_id" name="restaurant_id" class="form-control" <?php echo $role === 'Admin' ? '' : 'disabled'; ?>>
                                                <?php
                                                // Query untuk mengambil semua nama restoran
                                                $sql_restaurants = "SELECT restaurant_id, restaurant_name FROM restaurant";
                                                $result_restaurants = $koneksi->query($sql_restaurants);
                                                if ($result_restaurants->num_rows > 0) {
                                                    while ($row_restaurant = $result_restaurants->fetch_assoc()) {
                                                        // Ubah opsi pada dropbox untuk mencakup semua nama restoran
                                                        echo '<option value="' . $row_restaurant['restaurant_id'] . '"';
                                                        if ($food['restaurant_name'] === $row_restaurant['restaurant_name']) {
                                                            echo ' selected';
                                                        }
                                                        echo '>' . htmlspecialchars($row_restaurant['restaurant_name']) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Harga:</label>
                                            <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($food['price']); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Deskripsi:</label>
                                            <textarea class="form-control" id="description" name="description" readonly><?php echo htmlspecialchars($food['description']); ?></textarea>
                                        </div>

                                        <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                                    </form>
                                </div>
                            </div>

                            <div class="ibox btn-block float-e-margins">
                                <div class="ibox-title bg-primary" style="display: flex; align-items: center; justify-content: space-between;">
                                    <h2 class="m-b-sm">Update Gambar: <strong id="food-image-display"><?php echo htmlspecialchars($food['food_name']); ?></strong></h2>
                                    <div class="ibox-tools">
                                        <button id="save-image-btn" class="btn btn-danger" type="button" style="display: none;"><i class="fa fa-check"></i>&nbsp;Save</button>
                                        <button id="edit-image-btn" class="btn btn-warning" type="button"><i class="fa fa-paste"></i> Edit</button>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <!-- Notification UI Alert -->
                                    <div id="alert-image-success" class="alert alert-success alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        Gambar <strong id="alert-image-success-link">Makanan</strong> berhasil diperbarui.
                                    </div>
                                    <div id="alert-image-danger" class="alert alert-danger alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        Terjadi kesalahan saat memperbarui gambar <strong id="alert-image-danger-link">Makanan</strong>.
                                    </div>
                                    <!-- Edit Image Food Form -->
                                    <form id="food-image-form" action="../actions/update_food_image.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="image">Gambar:</label>
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
                                        <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
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
                            <div class="ibox btn-block float-e-margins">
                                <div class="ibox-title bg-primary" style="display: flex; align-items: center; justify-content: space-between;">
                                    <h2 class="m-b-sm"><strong id="food-name-display"><?php echo htmlspecialchars($food['food_name']); ?></strong></h2>
                                </div>
                                <div class="ibox-content">
                                    <br>
                                    <img alt="image" class="img-fluid b-r-xl" style="max-width: 50vh; max-height: 50vh; object-fit: cover; display: block; margin: 0 auto;" src="../<?php echo htmlspecialchars($food['image'] ?? ''); ?>"><br>
                                    <form id="food-data-form" action="update_food_data.php" method="post">
                                        <div class="form-group">
                                            <label for="food_name">Nama Makanan :</label>
                                            <input type="text" class="form-control" id="food_name" name="food_name" value="<?php echo htmlspecialchars($food['food_name']); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="restaurant_id">Nama Restoran :</label>
                                            <select id="restaurant_id" name="restaurant_id" class="form-control" disabled>
                                                <!-- Ambil data restoran dari database dan tampilkan sebagai opsi -->
                                                <?php
                                                // Pastikan file koneksi di-include
                                                $sql_restaurant = "SELECT restaurant_id, restaurant_name FROM restaurant WHERE restaurant_id = 2";
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
                                            <label for="price">Harga :</label>
                                            <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($food['price']); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Deskripsi :</label>
                                            <textarea class="form-control" id="description" name="description" readonly><?php echo htmlspecialchars($food['description']); ?></textarea>
                                        </div>

                                        <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                                    </form>
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

    <!-- JavaScript for Edit and Save Food Data Only -->
    <script>
        document.getElementById('edit-data-btn').addEventListener('click', function() {
            document.querySelectorAll('#food-data-form input, #food-data-form textarea').forEach(function(element) {
                element.removeAttribute('readonly');
            });
            document.getElementById('save-data-btn').style.display = 'inline-block';
            document.getElementById('edit-data-btn').style.display = 'none';

            // Menghapus atribut disabled pada dropdown restaurant saat tombol edit diklik
            document.getElementById('restaurant_id').removeAttribute('disabled');
        });

        // Menjadikan dropdown readonly saat halaman dimuat
        window.onload = function() {
            document.getElementById('restaurant_id').setAttribute('disabled', 'disabled');
        };

        document.getElementById('save-data-btn').addEventListener('click', function() {
            var formData = new FormData(document.getElementById('food-data-form'));

            fetch('../actions/update_food_data.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    document.getElementById('alert-data-success').style.display = 'block';
                    document.getElementById('alert-data-success-link').innerText = data.food_name;
                    setTimeout(function() {
                        location.reload(); // Refresh halaman setelah 2 detik
                    }, 1000);
                } else {
                    document.getElementById('alert-data-danger').style.display = 'block';
                    document.getElementById('alert-data-danger-link').innerText = data.food_name;
                }
            }).catch(error => {
                document.getElementById('alert-data-danger').style.display = 'block';
                document.getElementById('alert-data-danger-link').innerText = 'an error occurred';
            });

            document.getElementById('save-data-btn').style.display = 'none';
            document.getElementById('edit-data-btn').style.display = 'inline-block';
        });
    </script>

    <!-- JavaScript for Edit and Save Food Image -->
    <script>
        document.getElementById('edit-image-btn').addEventListener('click', function() {
            document.getElementById('file').removeAttribute('disabled');
            document.getElementById('save-image-btn').style.display = 'inline-block';
            document.getElementById('edit-image-btn').style.display = 'none';
        });

        document.getElementById('save-image-btn').addEventListener('click', function() {
            var formData = new FormData(document.getElementById('food-image-form'));

            fetch('../actions/update_food_image.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    document.getElementById('alert-image-success').style.display = 'block';
                    document.getElementById('alert-image-success-link').innerText = data.food_name || 'Makanan';
                    setTimeout(function() {
                        location.reload(); // Refresh halaman setelah 2 detik
                    }, 1000);
                } else {
                    document.getElementById('alert-image-danger').style.display = 'block';
                    document.getElementById('alert-image-danger-link').innerText = data.food_name || 'an error occurred';
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