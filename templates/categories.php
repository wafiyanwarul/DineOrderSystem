<!--
*
*  INSPINIA - Responsive Admin Theme
*  version 2.7
*
-->
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

    <title>Dine In Hub | Dashboard</title>

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

    <!-- Sweet Alert -->
    <link href="../assets/inspinia/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->

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
                    <li class="active">
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
                        <a href="./vouchers.php"><i class="fa-solid fa-ticket"></i> <span class="nav-label">Vouchers</span></a>
                    </li>
                    <!-- Orders -->
                    <li>
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
                    <h2>All Menu</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="./categories.php">All Menu</a>
                        </li>
                        <!-- <li class="active">
                            <strong>Profile</strong>
                        </li> -->
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <!-- View for User Admin Role -->
            <?php if ($level == 'admin') { ?>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title bg-primary">
                                    <h2 class="text-white"><strong>Insert Data Categories</strong></h2>
                                </div>
                                <div class="ibox-content m-b-lg">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Data seluruh kategori menu</p>
                                            <form action="../actions/add_category_action.php" method="post">
                                                <div class="form-group">
                                                    <label for="categoryName">Nama Kategori</label>
                                                    <input type="text" class="form-control" id="categoryName" name="category_name" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                                            </form>
                                            <hr>
                                            <h3>Kategori yang Ada</h3>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>ID Kategori</th>
                                                        <th>Nama Kategori</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Include database connection file
                                                    include "../includes/db_connect.php";

                                                    // Query to fetch category data
                                                    $sql_category = "SELECT category_id, category_name FROM category";
                                                    $result_categories = $koneksi->query($sql_category);

                                                    if ($result_categories->num_rows > 0) {
                                                        $no = 1;
                                                        // Output data of each row
                                                        while ($category = $result_categories->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $no++ . "</td>";
                                                            echo "<td>" . $category["category_id"] . "</td>";
                                                            echo "<td>" . $category["category_name"] . "</td>";
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='3'>No categories found.</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tambahkan JavaScript Bootstrap untuk interaktivitas -->
                            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

                            <!-- Update Categories -->
                            <div class="ibox">
                                <div class="ibox-title bg-primary">
                                    <h2><strong>Dine In Hub | Manage All Menu</strong></h2>
                                </div>
                                <div class="ibox-content m-b-lg">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Kelola kategori menu restoran Anda </p>
                                            <!-- Read category data from category table -->
                                            <form id="editForm" action="../actions/update_category_action.php" method="post">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Nama Kategori</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        // Include database connection file
                                                        include "../includes/db_connect.php";

                                                        // Query to fetch category data
                                                        $sql_category = "SELECT category_id, category_name FROM category";
                                                        $result_categories = $koneksi->query($sql_category);

                                                        if ($result_categories->num_rows > 0) {
                                                            // Output data of each row
                                                            while ($category = $result_categories->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $category["category_id"] . "</td>";
                                                                echo "<td><input type='text' class='form-control edit-input' name='nama_kategori[" . $category["category_id"] . "]' value='" . $category["category_name"] . "' disabled></td>";
                                                                echo "<td><input type='checkbox' name='category_ids[]' value='" . $category["category_id"] . "' disabled></td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='3'>No categories found.</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <button type="button" class="btn btn-danger btn-block" id="deleteBtn" disabled>Delete</button>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" class="btn btn-primary btn-block border-right" id="editBtn">Edit</button>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="submit" class="btn btn-success btn-block" id="saveBtn" disabled>Save</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- Script for Button and response update data category -->
                                            <script>
                                                // Mendapatkan referensi tombol-tombol dan input fields
                                                const deleteBtn = document.getElementById('deleteBtn');
                                                const editBtn = document.getElementById('editBtn');
                                                const saveBtn = document.getElementById('saveBtn');
                                                const editInputs = document.querySelectorAll('.edit-input');
                                                const checkboxes = document.querySelectorAll('input[type="checkbox"]');

                                                // Menambahkan event listener untuk tombol edit
                                                editBtn.addEventListener('click', function() {
                                                    // Mengubah status tombol-tombol dan input fields
                                                    editInputs.forEach(input => input.disabled = false);
                                                    checkboxes.forEach(checkbox => checkbox.disabled = false);
                                                    saveBtn.disabled = false;
                                                    deleteBtn.disabled = false;
                                                });

                                                // Menambahkan event listener untuk tombol save
                                                saveBtn.addEventListener('click', function(event) {
                                                    event.preventDefault(); // Mencegah form submission default
                                                    // Mendapatkan data yang akan diupdate
                                                    const formData = new FormData(document.getElementById('editForm'));

                                                    // Melakukan request AJAX untuk mengupdate data di tabel category
                                                    fetch('../actions/update_category_action.php', {
                                                            method: 'POST',
                                                            body: formData
                                                        })
                                                        .then(response => response.json()) // Mengambil respons dalam format JSON
                                                        .then(data => {
                                                            if (data.success) {
                                                                // Jika update berhasil, refresh halaman untuk memperbarui tampilan data
                                                                window.location.reload();
                                                            } else {
                                                                // Jika terjadi kesalahan, tampilkan pesan error
                                                                alert(data.error ? data.error : 'Failed to update categories.');
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Error updating categories:', error);
                                                            alert('An error occurred while updating categories.');
                                                        });
                                                });

                                                // Menambahkan event listener untuk tombol delete
                                                deleteBtn.addEventListener('click', function() {
                                                    // Mendapatkan data yang akan dihapus
                                                    const formData = new FormData(document.getElementById('editForm'));

                                                    // Melakukan request AJAX untuk menghapus data di tabel category
                                                    fetch('../actions/delete_category_action.php', {
                                                            method: 'POST',
                                                            body: formData
                                                        })
                                                        .then(response => response.json()) // Mengambil respons dalam format JSON
                                                        .then(data => {
                                                            if (data.success) {
                                                                // Jika delete berhasil, refresh halaman untuk memperbarui tampilan data
                                                                window.location.reload();
                                                            } else {
                                                                // Jika terjadi kesalahan, tampilkan pesan error
                                                                alert(data.error ? data.error : 'Failed to delete categories.');
                                                            }
                                                        })
                                                        .catch(error => {
                                                            console.error('Error deleting categories:', error);
                                                            alert('An error occurred while deleting categories.');
                                                        });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Categories -->
                            <div class="ibox">
                                <div class="ibox-title bg-primary">
                                    <h2><strong>All Data Categories</strong></h2>
                                </div>
                                <div class="ibox-content m-b-lg">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Data seluruh kategori menu</p>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>ID Kategori</th>
                                                        <th>Nama Kategori</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Include database connection file
                                                    include "../includes/db_connect.php";

                                                    // Query to fetch voucher data
                                                    $sql_category = "SELECT category_id, category_name FROM category";
                                                    $result_categories = $koneksi->query($sql_category);

                                                    if ($result->num_rows > 0) {
                                                        $no = 1;
                                                        // Output data of each row
                                                        while ($category = $result_categories->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $no++ . "</td>";
                                                            echo "<td>" . $category["category_id"] . "</td>";
                                                            echo "<td>" . $category["category_name"] . "</td>";

                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='5'>No category found.</td></tr>";
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
                </div>
            <?php } elseif ($level == 'customer') { ?>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title bg-success">
                                    <h2><strong>Dine In Hub | All Menu</strong></h2>
                                </div>
                                <div class="ibox-content m-b-lg">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Berikut seluruh data kategori yang tersedia </p>
                                            <!-- All Data Category -->
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama Kategori</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Include database connection file
                                                    include "../includes/db_connect.php";

                                                    // Query to fetch voucher data
                                                    $sql_category = "SELECT category_id, category_name FROM category";
                                                    $result_categories = $koneksi->query($sql_category);

                                                    if ($result->num_rows > 0) {
                                                        $no = 1;
                                                        // Output data of each row
                                                        while ($category = $result_categories->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $no++ . "</td>";
                                                            echo "<td>" . $category["category_name"] . "</td>";

                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='5'>No category found.</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Title Foods -->
                                <div class="ibox-title bg-info">
                                    <h2><strong>Foods Menu</strong>
                                    </h2>
                                </div>
                                <!-- Show All Foods Data -->
                                <div class="row m-t-lg">
                                    <?php
                                    // to select all foods
                                    $sql_food = "SELECT 
                                                    food.food_id, 
                                                    food.restaurant_id, 
                                                    food.food_name, 
                                                    food.price, 
                                                    food.description AS food_description, 
                                                    food.image AS food_image, 
                                                    restaurant.restaurant_name,
                                                    category.category_id,
                                                    category.category_name
                                                FROM 
                                                    food 
                                                JOIN 
                                                    restaurant ON food.restaurant_id = restaurant.restaurant_id
                                                JOIN 
                                                    category ON food.category_id = category.category_id
                                                WHERE 
                                                    food.category_id = 1";

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
                                                            <p><strong><?= htmlspecialchars($food['category_name']) ?></strong></p>


                                                        </address>
                                                    </a>
                                                    <div class="contact-box-footer">
                                                        <div class="m-t-xs btn-group">
                                                            <a href="./food_detail.php?id=<?php echo $food['food_id']; ?>" class="btn btn-xs btn-white bg-info"><i class="fa-solid fa-cart-shopping"></i> View Food </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                        $koneksi->close(); ?>
                                    <?php else : ?>
                                        <div class="col-lg-12 badge-white">
                                            <p class="m-t-sm"><strong>
                                                    No foods available
                                                </strong></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- Title Drinks -->
                                <div class="ibox-title bg-info m-t-sm">
                                    <h2><strong>Drinks Menu</strong>
                                    </h2>
                                </div>
                                <!-- All Data Drinks -->
                                <?php
                                // Connect to database again
                                include "../includes/db_connect.php";
                                $sql_food = "SELECT 
                                                food.food_id, 
                                                food.restaurant_id, 
                                                food.food_name, 
                                                food.price, 
                                                food.description AS food_description, 
                                                food.image AS food_image, 
                                                restaurant.restaurant_name,
                                                category.category_id,
                                                category.category_name
                                            FROM 
                                                food 
                                            JOIN 
                                                restaurant ON food.restaurant_id = restaurant.restaurant_id
                                            JOIN 
                                                category ON food.category_id = category.category_id
                                            WHERE 
                                                food.category_id = 2";
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
                                <div class="row m-t-lg">
                                    <?php if (!empty($foods)) : ?>
                                        <?php foreach ($foods as $food) : ?>
                                            <div class="col-lg-3">
                                                <div class="contact-box center-version">
                                                    <input type="checkbox" name="food_ids[]" value="<?= $food['food_id'] ?>" class="delete-checkbox" style="display: none;">
                                                    <a href="./drink_detail.php?id=<?php echo $food['food_id']; ?>">
                                                        <h3 class="m-b-xs"><strong><?= htmlspecialchars($food['food_name']) ?></strong></h3><br>
                                                        <img alt="image" class="img-fluid img-circle" style="max-width: 100%; max-height: 100%; object-fit: cover; display: block; margin: 0 auto;" src="<?= htmlspecialchars($food['food_image']) ?>"><br>
                                                        <div class="font-bold">Rp. <?= htmlspecialchars($food['price']) ?></div>
                                                        <address class="m-t-md">
                                                            <strong><?= htmlspecialchars($food['restaurant_name']) ?></strong><br>
                                                            <p><?= htmlspecialchars($food['food_description']) ?></p>
                                                            <p><strong><?= htmlspecialchars($food['category_name']) ?></strong></p>
                                                        </address>
                                                    </a>
                                                    <div class="contact-box-footer">
                                                        <div class="m-t-xs btn-group">
                                                            <a href="./food_detail.php?id=<?php echo $food['food_id']; ?>" class="btn btn-xs btn-white bg-info"><i class="fa-solid fa-cart-shopping"></i> View Drink </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="col-lg-12 badge-white">
                                            <p class="m-t-sm"><strong>
                                                    No drinks available
                                                </strong></p>
                                        </div>
                                    <?php endif; ?>
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
    </div>

    <!-- Sweet alert -->
    <script src="../assets/inspinia/js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Sweet Alert -->
    <script>
        $(document).ready(function() {
            $('.demo2').click(function() {
                swal({
                    title: "Good job!",
                    text: "You clicked the button!",
                    type: "success"
                });
            });
        });
    </script>

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


    <script>
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('All Menu Page', 'Dine In HUB');

            }, 1300);
        });
    </script>
</body>

</html>