<?php
include('../includes/db_connect.php');
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dine In Hub | Forgot password</title>

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

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">

                <center><img src="../assets/images/dine_in_hub_logo.png" alt="Logo Dine In Hub" height="75px"><br><br></center>
                <div class="ibox-content">

                    <h2 class="font-bold" style="text-align: center;">Forgot password</h2>

                    <p>
                        Enter your email address and your password will be reset and emailed to you.
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <?php
                            if (isset($_GET['status'])) {
                                if ($_GET['status'] == 'success') {
                                    echo "<div class='alert alert-success'>A new password has been sent to your email address.</div>";
                                } elseif ($_GET['status'] == 'fail') {
                                    echo "<div class='alert alert-danger'>Failed to send email.</div>";
                                } elseif ($_GET['status'] == 'notfound') {
                                    echo "<div class='alert alert-danger'>Email address not found.</div>";
                                } elseif ($_GET['status'] == 'dbfail') {
                                    echo "<div class='alert alert-danger'>Failed to update password in the database.</div>";
                                }
                            }
                            ?>
                            <form class="m-t" role="form" action="../actions/forget_password_action.php" method="POST">
                            <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email address" required="">
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Send new password</button>
                                <a href="./login.php" style="text-align: center;"><h4>Back to Login Page</h4></a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Copyright Dine In Hub
            </div>
            <div class="col-md-6 text-right">
                <small>© 2024</small>
            </div>
        </div>
    </div>

</body>

</html>