<?php
include '../includes/db_connect.php'; // Pastikan koneksi ke database disertakan

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $stmt = $koneksi->prepare("SELECT user_id, username, email, access_code, level FROM user WHERE user_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die('User not found');
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $level = $_POST['level'];

    $stmt = $koneksi->prepare("UPDATE user SET email = ?, level = ? WHERE user_id = ?");
    $stmt->bind_param('ssi', $email, $level, $user_id);
    
    if ($stmt->execute()) {
        // Redirect to the same page with a success parameter
        header("Location: update_user.php?user_id=$user_id&update=success");
        exit();
    } else {
        echo 'Failed to update user';
    }

    $stmt->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            if (params.get('update') === 'success') {
                const alertBox = document.createElement('div');
                alertBox.className = 'alert alert-success alert-dismissible fade show';
                alertBox.role = 'alert';
                alertBox.innerHTML = `
                    User updated successfully
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                `;
                document.body.prepend(alertBox);
                params.delete('update');
                history.replaceState(null, '', `${location.pathname}?${params}`);
            }
        });
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Update User</h2>
        <form method="POST" action="update_user.php">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Access Code:</label>
                <input type="text" class="form-control" name="access_code" value="<?php echo htmlspecialchars($user['access_code']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Level:</label>
                <select class="form-control" name="level" required>
                    <option value="admin" <?php if ($user['level'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="customer" <?php if ($user['level'] == 'customer') echo 'selected'; ?>>Customer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
