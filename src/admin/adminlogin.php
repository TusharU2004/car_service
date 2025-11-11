<?php
session_start();
$login_error = "";
$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Database connection
    $servername = getenv('DB_HOST') ?: 'localhost';
    $dbuser = getenv('DB_USER') ?: 'root';
    $dbpass = getenv('DB_PASS') ?: '';
    $dbname = getenv('DB_NAME') ?: 'car_rental_db';

    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prevent SQL injection
    $input_username = mysqli_real_escape_string($conn, $input_username);
    $input_password = mysqli_real_escape_string($conn, $input_password);

    // Check admin table
    $query = "SELECT * FROM admin WHERE UserName='$input_username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        // Assuming passwords stored as MD5
        if (md5($input_password) === $user['Password']) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admindashboard.php");
            exit();
        } else {
            $login_error = "Invalid username or password.";
        }
    } else {
        $login_error = "Invalid username or password.";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Login Page</title>
    <link rel="stylesheet" href="adminlogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="login-form">
            <h1>Admin Log in</h1>
            <form action="" method="post">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username"
                            value="<?php echo htmlspecialchars($input_username ?? ''); ?>" placeholder="Enter Username" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <button type="submit">Login</button>
                <?php if ($login_error): ?>
                    <span class="error-message"><?php echo $login_error; ?></span>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
