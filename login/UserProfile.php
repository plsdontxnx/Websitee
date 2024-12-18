<?php
session_start(); // Start session
include("connect.php"); // Include database connection
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Angkor&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script>
        function toggleEdit() {
            var fields = document.getElementsByClassName('editable-field');
            var editButton = document.getElementById('editButton');
            var isEditing = editButton.textContent === "Edit";

            // Toggle editable fields
            for (var i = 0; i < fields.length; i++) {
                fields[i].disabled = !isEditing;
            }

            // Toggle button text
            if (isEditing) {
                editButton.textContent = "Save";
            } else {
                editButton.textContent = "Edit";

                // Enable fields temporarily for form submission
                for (var i = 0; i < fields.length; i++) {
                    fields[i].disabled = false;
                }

                // Submit the form
                document.getElementById('profileForm').submit();
            }
        }
    </script>
</head>
<body>  
    <?php

        // Default user data
        $user = ['fName' => '', 'lName' => '', 'email' => '', 'mobile' => '', 'password' => ''];

        $successMessage = ""; // Initialize success message

        // Process form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fname = $conn->real_escape_string($_POST['fname']);
            $lname = $conn->real_escape_string($_POST['lname']);
            $email = $conn->real_escape_string($_POST['email']);
            $mobile = $conn->real_escape_string($_POST['mobile']);
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

            $updateQuery = "UPDATE users SET fName='$fname', lName='$lname', email='$email', mobile='$mobile'";
            if ($password) {
                $updateQuery .= ", password='$password'";
            }
            $updateQuery .= " WHERE email='{$_SESSION['email']}'";

            if ($conn->query($updateQuery)) {
                $_SESSION['fName'] = $fname;
                $_SESSION['lName'] = $lname;
                $_SESSION['email'] = $email;
                $_SESSION['mobile'] = $mobile;
                $successMessage = "Profile updated successfully."; // Set success message
            } else {
                echo "<p style='color: red;'>Error updating profile: " . $conn->error . "</p>";
            }
        }

        if (isset($_SESSION['email'])) {
            $email = $conn->real_escape_string($_SESSION['email']);
            $userQuery = "SELECT * FROM users WHERE email='$email'"; // Corrected query
            $userResult = $conn->query($userQuery);
            if ($userResult && $userResult->num_rows > 0) {
                $user = $userResult->fetch_assoc();
            } else {
                echo "<p style='color: red;'>Error: User data not found.</p>";
            }
        } else {
            echo "<p style='color: red;'>Error: User is not logged in.</p>";
        }
    ?>
    
    <!-- Profile Edit Section -->
    <div class="container mt-5">
        <h2>Profile Information</h2>
        <form id="profileForm" method="POST" action="">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control editable-field" name="fname" id="fname" value="<?php echo htmlspecialchars($user['fName']); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control editable-field" name="lname" id="lname" value="<?php echo htmlspecialchars($user['lName']); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control editable-field" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control editable-field" name="mobile" id="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="form-control editable-field" name="password" id="password" placeholder="Leave blank to keep current password" disabled>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" id="editButton" class="btn btn-primary" onclick="toggleEdit()">Edit</button>
                <?php if (!empty($successMessage)): ?>
                    <span style="color: green; margin-left: 15px;"> <?php echo $successMessage; ?> </span>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>
</html>
