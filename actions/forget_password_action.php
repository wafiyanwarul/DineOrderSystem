<?php
include('../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // Generate a random password
        function generateRandomPassword($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomPassword = '';
            for ($i = 0; $i < $length; $i++) {
                $randomPassword .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomPassword;
        }

        $newPassword = generateRandomPassword();
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the password in the database
        $updateQuery = "UPDATE user SET password='$hashedPassword' WHERE email='$email'";
        if (mysqli_query($koneksi, $updateQuery)) {
            // Send the new password to the user's email
            $to = $email;
            $subject = "Your new password - Dine In Hub";
            $message = "Your new password is: $newPassword";
            $headers = "From: no-reply@dineinhub.com";

            if (mail($to, $subject, $message, $headers)) {
                header('Location: ../templates/forget_password.php?status=success');
            } else {
                header('Location: ../templates/forget_password.php?status=fail');
            }
        } else {
            header('Location: ../templates/forget_password.php?status=dbfail');
        }
    } else {
        header('Location: ../templates/forget_password.php?status=notfound');
    }
} else {
    header('Location: ../templates/forget_password.php');
}
