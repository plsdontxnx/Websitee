<?php 
session_start(); 
include("connect.php"); 

if (isset($_POST['signIn'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Query to fetch the admin details
    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify password
        if ($password === $admin['password']) { // Replace with password_verify() if hashing is used
            $_SESSION['adminName'] = $admin['name'];
            $_SESSION['adminId'] = $admin['id'];
            $_SESSION['loginSuccess'] = "Welcome, " . $admin['name'] . "!";
            header("Location: AdminSide/Dashboard.php"); // Redirect to dashboard
            exit;
        } else {
            $_SESSION['errorMessage'] = "Incorrect password.";
        }
    } else {
        $_SESSION['errorMessage'] = "No admin found with this email.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" id="signIn">
        <h1 class="form-title">Admin Dashboard</h1>

        <!-- Display success or error messages -->
        <?php if (isset($_SESSION['loginSuccess'])): ?>
            <div style="color: green; margin-bottom: 10px;">
                <p><?= $_SESSION['loginSuccess']; ?></p>
            </div>
            <?php unset($_SESSION['loginSuccess']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div style="color: red; margin-bottom: 10px;">
                <p><?= $_SESSION['errorMessage']; ?></p>
            </div>
            <?php unset($_SESSION['errorMessage']); ?>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="emailSignIn" placeholder="Email" required>
                <label for="emailSignIn">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="passwordSignIn" placeholder="Password" required>
                <label for="passwordSignIn">Password</label>
            </div>
            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>

        <!-- Admin Dashboard Icon Button -->
        <button id="adminDashboardButton" 
            style="
                background-color: #007BFF; 
                color: white; 
                border: none; 
                cursor: pointer; 
                border-radius: 50%; 
                width: 40px; 
                height: 40px; 
                text-align: center; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" 
            onclick="window.location.href='login.php';">
            <i class="fas fa-user"></i>
        </button>
    </div>

    <script src="script.js"></script>
</body>
</html>