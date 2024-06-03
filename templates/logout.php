<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>

    <link href="../assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <center><h1>Anda berhasil logout</h1></center>
</body>
</html>

<?php
    session_start();
    session_destroy();
?>
    <script language="javascript">
        alert("Anda yakin akan logout?");
        document.location="../templates/login.php";
    </script>