<?php
session_start();
include('../includes/db_connect.php'); // Ganti dengan file koneksi database Anda
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (!isset($_SESSION['username'])) {
    die("Anda belum login");
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
} elseif ($level == 'admin') {
    $role = 'Admin';
} else {
    $role = 'Unknown';
}

$sql_customer = "SELECT
                    customer.customer_id,
                    customer.user_id,
                    customer.phone,
                    customer.address,
                    user.username
                FROM
                    customer
                JOIN
                    user ON customer.user_id = user.user_id";

$result = $koneksi->query($sql_customer);

$customer = $result->fetch_assoc();

if (!$customer) {
    die("Data tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Profile</title>

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
                                <li><a href="../templates/login.php">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    <li class="active">
                        <a href="./dashboard.php"><i class="fa-solid fa-house"></i> <span class="nav-label"></span> Home</a>
                    </li>
                    <!-- Restaurants -->
                    <li class="#">
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
                        <a href="./drinks.php"><i class="fa-solid fa-mug-hot"></i> <span class="nav-label">Drinks </span><span class="label label-success pull-right">16/24</span></a>
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

        <div id="page-wrapper" class="gray-bg">

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
                                <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="#" class="pull-left">
                                            <img alt="image" class="img-circle" src="../assets/inspinia/img/a7.jpg">
                                        </a>
                                        <div class="media-body">
                                            <small class="pull-right">46h ago</small>
                                            <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                            <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="../assets/inspinia/img/a4.jpg">
                                        </a>
                                        <div class="media-body ">
                                            <small class="pull-right text-navy">5h ago</small>
                                            <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                            <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="../assets/inspinia/img/profile.jpg">
                                        </a>
                                        <div class="media-body ">
                                            <small class="pull-right">23h ago</small>
                                            <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                            <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="mailbox.html">
                                            <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                        </a>
                                    </div>
                                </li>
                            </ul>
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
                            <a href="../templates/login.php">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                        <li>
                            <a class="right-sidebar-toggle">
                                <i class="fa fa-tasks"></i>
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Profile</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li class="active">
                            <strong>Profile <?php echo $username ?></strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <?php if ($level === 'admin') { ?>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Profile Detail</h5>
                                </div>
                                <div class="ibox-content no-padding border-left-right">
                                    <img alt="image" class="img-responsive" src="../assets/images/dine_in_hub_logo.png">
                                </div>
                                <div class="ibox-content profile-content">
                                    <!-- Notification Alert UI for Multi Insert Voucher  -->
                                    <?php if (isset($_GET['status'])) : ?>
                                        <?php if ($_GET['status'] == 'success') : ?>
                                            <div id="alert-data-success" class="alert alert-success alert-dismissable">
                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                <span id="success-message">Data berhasil diperbarui.</span>
                                            </div>
                                        <?php elseif ($_GET['status'] == 'error') : ?>
                                            <div id="alert-data-danger" class="alert alert-danger alert-dismissable">
                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                <span id="error-message">Data gagal diperbarui.</span>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <form id="profileForm" action="../actions/update_profile_action.php" method="post">
                                        <?php
                                        $sql_customer = "SELECT
                                            customer.customer_id,
                                            customer.user_id,
                                            customer.phone,
                                            customer.address,
                                            user.username
                                        FROM
                                            customer
                                        JOIN
                                            user ON customer.user_id = user.user_id
                                        WHERE
                                            user.username = '$username'"; // Memodifikasi query untuk hanya mengambil data customer yang sesuai dengan username yang sedang login
                                        $result = $koneksi->query($sql_customer);
                                        $customer = $result->fetch_assoc();
                                        $phone = htmlspecialchars($customer['phone'] ?? '');
                                        $address = htmlspecialchars($customer['address'] ?? '');
                                        $edit_disabled = ($phone === '' && $address === '') ? 'disabled' : ''; // Tombol edit dinonaktifkan jika phone dan address kosong
                                        ?>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" id="address" name="address" disabled><?php echo $address; ?></textarea>
                                        </div>
                                        <div class="user-button">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="button" id="editButton" class="btn btn-primary btn-sm btn-block" <?php echo $edit_disabled; ?>>Edit</button>
                                                    <button type="submit" id="saveButton" class="btn btn-primary btn-sm btn-block" style="display: none;">Save</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="./add_new_profile.php">
                                                        <button type="button" class="btn btn-success btn-sm btn-block"><i class="fa fa-user"></i> Add Profile</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const editButton = document.getElementById('editButton');
                                    const saveButton = document.getElementById('saveButton');
                                    const phoneField = document.getElementById('phone');
                                    const addressField = document.getElementById('address');

                                    editButton.addEventListener('click', function() {
                                        editButton.style.display = 'none'; // Sembunyikan tombol Edit
                                        saveButton.style.display = 'block'; // Tampilkan tombol Save
                                        phoneField.disabled = false; // Mengaktifkan field phone
                                        addressField.disabled = false; // Mengaktifkan field address
                                    });

                                    // Menampilkan notifikasi berdasarkan status
                                    const urlParams = new URLSearchParams(window.location.search);
                                    const status = urlParams.get('status');
                                    if (status === 'success') {
                                        document.getElementById('alert-data-success').style.display = 'block';
                                    } else if (status === 'error') {
                                        document.getElementById('alert-data-danger').style.display = 'block';
                                    }

                                    // Menyembunyikan notifikasi setelah beberapa detik
                                    setTimeout(function() {
                                        const successAlert = document.getElementById('alert-data-success');
                                        const errorAlert = document.getElementById('alert-data-danger');
                                        if (successAlert) successAlert.style.display = 'none';
                                        if (errorAlert) errorAlert.style.display = 'none';
                                    }, 3000);
                                });
                            </script>



                        </div>
                        <div class="col-md-8">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Activites</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div>
                                        <div class="feed-activity-list">
                                            <!-- User Activities Here -->
                                            <center>
                                                <h2>No activities Here</h2>
                                            </center>
                                        </div>

                                        <button class="btn btn-primary btn-block m"><i class="fa fa-arrow-down"></i> Show More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } elseif ($level == 'customer') { ?>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Profile Detail</h5>
                                </div>
                                <div class="ibox-content no-padding border-left-right">
                                    <img alt="image" class="img-responsive" src="../assets/inspinia/img/profile_big.jpg">
                                </div>
                                <div class="ibox-content profile-content">
                                    <!-- Notification Alert UI for Multi Insert Voucher  -->
                                    <div id="alert-data-success" class="alert alert-success alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <span id="success-message">Data berhasil diperbarui.</span>
                                    </div>
                                    <div id="alert-data-danger" class="alert alert-danger alert-dismissable" style="display: none;">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <span id="error-message">Data gagal diperbarui.</span>
                                    </div>
                                    <form id="profileForm" action="../actions/update_profile_action.php" method="post">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($customer['username']); ?>" disabled>
                                        </div>
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($customer['user_id']); ?>">

                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" id="address" name="address" disabled><?php echo htmlspecialchars($customer['address']); ?></textarea>
                                        </div>
                                        <div class="user-button">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="button" id="editButton" class="btn btn-primary btn-sm btn-block"><i class="fa fa-pencil"></i> Edit Profile</button>
                                                    <button type="submit" id="saveButton" class="btn btn-primary btn-sm btn-block" style="display: none;"><i class="fa fa-save"></i> Save</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-default btn-sm btn-block"><i class="fa fa-coffee"></i> Buy a coffee</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Activites</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-wrench"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-user">
                                            <li><a href="#">Config option 1</a>
                                            </li>
                                            <li><a href="#">Config option 2</a>
                                            </li>
                                        </ul>
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div>
                                        <div class="feed-activity-list">
                                            <!-- User Activities Here -->
                                            <center>
                                                <h2>No activities Here</h2>
                                            </center>
                                        </div>
                                        <button class="btn btn-primary btn-block m"><i class="fa fa-arrow-down"></i> Show More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
            <?php } ?>
            <div class="footer">
                <div class="pull-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Example Company &copy; 2014-2017
                </div>
            </div>

        </div>
    </div>
    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            // Enable all form fields except username
            document.getElementById('phone').disabled = false;
            document.getElementById('address').disabled = false;

            // Show the Save button and hide the Edit button
            document.getElementById('editButton').style.display = 'none';
            document.getElementById('saveButton').style.display = 'block';
        });

        document.getElementById('profileForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    document.getElementById('alert-data-success').style.display = 'block';
                    setTimeout(function() {
                        location.reload(); // Refresh halaman setelah 1 detik
                    }, 1000);
                } else {
                    document.getElementById('alert-data-danger').style.display = 'block';
                    setTimeout(function() {
                        location.reload(); // Refresh halaman setelah 1 detik
                    }, 1000);
                }
            }).catch(error => {
                console.error('Error:', error);
                document.getElementById('alert-data-danger').style.display = 'block';
                setTimeout(function() {
                    location.reload(); // Refresh halaman setelah 1 detik
                }, 1000);
            });

            document.getElementById('phone').disabled = true;
            document.getElementById('address').disabled = true;
            document.getElementById('editButton').style.display = 'block';
            document.getElementById('saveButton').style.display = 'none';
        });
    </script>

    <!-- Mainly scripts -->
    <script src="../assets/inspinia/js/jquery-3.1.1.min.js"></script>
    <script src="../assets/inspinia/js/bootstrap.js"></script>
    <script src="../assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../assets/inspinia/js/inspinia.js"></script>
    <script src="../assets/inspinia/js/plugins/pace/pace.min.js"></script>

    <!-- Peity -->
    <script src="../assets/inspinia/js/plugins/peity/jquery.peity.min.js"></script>

    <!-- Peity -->
    <script src="../assets/inspinia/js/demo/peity-demo.js"></script>

</body>

</html>