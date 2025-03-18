<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dine In Hub | Register</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon_io/apple-touch-icon.png">

    <link rel="manifest" href="../assets/favicon_io/site.webmanifest">
    
    <!-- Main Favicon -->
    <link rel="shortcut icon" href="../assets/favicon_io/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../assets/inspinia/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/inspinia/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/inspinia/css/plugins/iCheck/custom.css">
    <link rel="stylesheet" href="../assets/inspinia/css/animate.css">
    <link rel="stylesheet" href="../assets/inspinia/css/style.css">

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
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .alert {
            color: red;
            display: none;
        }

        .border-red {
            border-color: red;
        }

        .error-message {
            color: red;
            font-size: 0.875em;
            display: none;
        }

        .has-error {
            border-color: red;
        }
    </style>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <img src="../assets/images/dine_in_hub_logo.png" alt="Logo Dine In Hub" height="75px"><br><br>
                <!-- <h1 class="logo-name">IN+</h1> -->
            </div>
            <h3>Register to Dine Food Order</h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" action="../actions/register_action.php" method="POST" id="register-form">
                <!-- Field Nama -->
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nama Lengkap" name="username" required>
                </div>
                <!-- Field Email -->
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                </div>
                <!-- Field Password -->
                <div class="form-group password-container">
                    <input type="password" class="form-control" placeholder="Password" name="password" required id="password">
                    <i class="fa fa-eye" id="toggle-password"></i>
                </div>
                <!-- Field Confirm Password -->
                <div class="form-group password-container">
                    <input type="password" class="form-control" placeholder="Confirm Password" required id="confirm-password">
                    <i class="fa fa-eye" id="toggle-confirm-password"></i>
                </div>
                <div class="alert" id="password-alert">Passwords do not match!</div>
                <!-- Field Kode Akses -->
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Kode Akses" name="access_code" required>
                </div>
                <!-- Checkbox Area -->
                <div class="form-group">
                    <div class="checkbox i-checks">
                        <label>
                            <input type="checkbox" id="agree-checkbox">
                            <i></i> Agree the terms and policy
                        </label>
                    </div>
                </div>
                <!-- Register Button -->
                <button type="submit" class="btn btn-warning block full-width m-b" id="register-button" disabled>Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block bg-success" href="../templates/login.php">Login</a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="../assets/inspinia/js/jquery-3.1.1.min.js"></script>
    <script src="../assets/inspinia/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="../assets/inspinia/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize iCheck plugin
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Disable the register button initially
            $('#register-button').prop('disabled', true);
            $('#register-button').css('cursor', 'not-allowed');

            // Enable or disable the register button based on checkbox state
            $('#agree-checkbox').on('ifChanged', function(event) {
                if ($(this).is(':checked')) {
                    $('#register-button').prop('disabled', false);
                    $('#register-button').css('cursor', 'pointer');
                } else {
                    $('#register-button').prop('disabled', true);
                    $('#register-button').css('cursor', 'not-allowed');
                }
            });

            // Prevent form submission if the checkbox is not checked or passwords do not match
            $('#register-form').on('submit', function(e) {
                if (!$('#agree-checkbox').is(':checked')) {
                    e.preventDefault();
                    alert('You must agree to the terms and policy.');
                } else if ($('#password').val() !== $('#confirm-password').val()) {
                    e.preventDefault();
                    $('#password-alert').show();
                    $('#confirm-password').addClass('border-red');
                }
            });

            // Toggle password visibility
            $('#toggle-password').click(function() {
                const passwordField = $('#password');
                const passwordFieldType = passwordField.attr('type');
                const isPassword = passwordFieldType === 'password';
                passwordField.attr('type', isPassword ? 'text' : 'password');
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            // Toggle confirm password visibility
            $('#toggle-confirm-password').click(function() {
                const confirmPasswordField = $('#confirm-password');
                const confirmPasswordFieldType = confirmPasswordField.attr('type');
                const isPassword = confirmPasswordFieldType === 'password';
                confirmPasswordField.attr('type', isPassword ? 'text' : 'password');
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            // Hide the alert and remove the red border when user starts typing in the confirm password field
            $('#confirm-password').on('input', function() {
                if ($('#password').val() === $('#confirm-password').val()) {
                    $('#password-alert').hide();
                    $('#confirm-password').removeClass('border-red');
                }
            });
        });
    </script>
</body>

</html>