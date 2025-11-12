<?php
session_start();

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    require('db_connection.php');

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR phone=?");
    $stmt->bind_param("ss", $input_username, $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($input_password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['email'];
            $_SESSION['loggedin'] = true;

            header("Location: index.php");
            exit();
        } else {
            $login_error = "Invalid username or password.";
        }
    } else {
        $login_error = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Login Page</title>
    <!-- CSS file link -->
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome link for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <div class="container">
        <div class="login-form">
            <h1>Sign in</h1>
            <form action="" method="post">
                <div class="input-group">
                    <label for="username">Username (Email):</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Enter Email" required>
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
                <a href="register.php">For Register click here</a>
                <a href="forgotpassword.php">Forget Password</a>
            </form>
        </div>
    </div>

</body>

</html>