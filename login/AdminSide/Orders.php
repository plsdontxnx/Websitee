<?php
session_start();
$servername = "localhost"; // Your server name (e.g., localhost, or IP address)
$username = "u143688490_lou"; // Your database username
$password = "Fujiwara000!"; // Your database password
$dbname = "u143688490_websiteee"; // Your database name


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request to update order status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']); // Get order ID from the form
    $status = $conn->real_escape_string($_POST['status']); // Get new status from the form

    // Update the status in the orders table
    $updateQuery = "UPDATE orders SET status = '$status' WHERE id = $order_id";

    if ($conn->query($updateQuery)) {
        echo "<script>alert('Status updated successfully!'); window.location.href='';</script>";
    } else {
        echo "<script>alert('Error updating status: " . $conn->error . "');</script>";
    }
}

// Fetch customer data with total price and status
$query = "SELECT o.id AS order_id, u.id AS user_id, u.fName, u.lName, o.created_at, o.total_price, o.status
          FROM users u
          JOIN orders o ON u.id = o.user_id
          ORDER BY o.created_at DESC";

$result = $conn->query($query);

// Fetch total price from orders for each customer
$totalPriceQuery = "SELECT u.id AS user_id, SUM(o.total_price) AS total_price
                    FROM users u
                    JOIN orders o ON u.id = o.user_id
                    GROUP BY u.id";
$totalPriceResult = $conn->query($totalPriceQuery);

$totalPrices = [];
while ($row = $totalPriceResult->fetch_assoc()) {
    $totalPrices[$row['user_id']] = $row['total_price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="db.css">
    <style>
        .done-button {
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>

<aside>
    <div class="logo">Goffee</div>
    <ul>
        <li><a href="Dashboard.php">Dashboard</a></li>
        <li><a href="Product.php">Products</a></li>
        <li><a href="Orders.php">Orders</a></li>
        <li><a href="Customer.php" class="active">Users</a></li>
        <li><a href="#">Log out</a></li>
        <li><a href="../index.php">Go to Main Store</a></li>
    </ul>
</aside>

<!-- Main Content -->
<div class="main-content">
    <div class="card">
        <div class="card-header">Orders Overview</div>
        <div class="card-body">
            <h3>Orders Details</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['fName'] . ' ' . $row['lName']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>$<?php echo number_format($totalPrices[$row['user_id']], 2); ?></td>
                            <td>
                                <!-- Form for updating the status -->
                                <form method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                    <select name="status" class="form-control" onchange="this.form.submit();">
                                        <option value="Pending" <?php echo $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Done" <?php echo $row['status'] == 'Done' ? 'selected' : ''; ?>>Done</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <!-- Mark as Done Button -->
                                <form method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                    <input type="hidden" name="status" value="Done">
                                    <button type="submit" class="btn btn-primary btn-sm done-button" 
                                        <?php echo $row['status'] == 'Done' ? 'disabled' : ''; ?>>
                                        <?php echo $row['status'] == 'Done' ? 'Done' : 'Mark as Done'; ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
