<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dine In Hub | Login</title>

    <link href="../assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../assets/inspinia/css/animate.css" rel="stylesheet">
    <link href="../assets/inspinia/css/style.css" rel="stylesheet">
    <style>
        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 30px;
            /* Room for the icon */
        }

        .password-container .fa-eye,
        .password-container .fa-eye-slash {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div class="head-logo">
                <!-- <h1 class="logo-name">IN+</h1> -->
            </div>
            <h2><b>Welcome to</b></h2>
            <img src="../assets/images/dine_in_hub_logo.png" alt="Logo Dine In Hub" height="75px"><br><br>
            <!-- <p>"Dine Smart, Dine In"</p> -->
            <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            <p>Login to Order Food</p>
            <form class="m-t" role="form" action="../actions/login_action.php?op=in" method="POST">
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="dinein@mail.com" required="">
                </div>
                <div class="form-group password-container">
                    <label for="Password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="your password" required="" ><i class="fa fa-eye" id="toggle-password"></i>
                    
                </div>
                <?php
                session_start();
                if (isset($_SESSION['error'])) {
                    echo '<div style="color: red;">' . $_SESSION['error'] . '</div><br>';
                    unset($_SESSION['error']);
                }
                ?>
                <button type="submit" name="login" value="Login" class="btn btn-primary block full-width m-b">Login</button>

                <a href="./forget_password.php"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="../templates/register.php">Register</a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="../assets/inspinia/js/jquery-3.1.1.min.js"></script>
    <script src="../assets/inspinia/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#toggle-password');
            const passwordInput = document.querySelector('input[name="password"]');

            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the eye slash icon
                if (type === 'password') {
                    togglePassword.classList.add('fa-eye');
                    togglePassword.classList.remove('fa-eye-slash');
                } else {
                    togglePassword.classList.remove('fa-eye');
                    togglePassword.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
</body>

</html>