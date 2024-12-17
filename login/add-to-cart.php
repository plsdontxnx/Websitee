<?php
session_start();
require 'connect.php'; // Database connection

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['productId']) && isset($data['size']) && isset($data['price']) && isset($data['quantity'])) {
    $user_id = $_SESSION['user_id']; // Ensure the user is logged in
    $product_id = $data['productId'];
    $size = $data['size'];
    $price = $data['price'];
    $quantity = $data['quantity'];
    $total_price = $price * $quantity;

    // Insert into cart table
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, size, price, quantity, total_price, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisiii", $user_id, $product_id, $size, $price, $quantity, $total_price);

    if ($stmt->execute()) {
        $cartCount = $conn->query("SELECT COUNT(*) AS count FROM cart WHERE user_id = $user_id")->fetch_assoc()['count'];
        echo json_encode(['status' => 'success', 'message' => 'Item added to cart!', 'cartCount' => $cartCount]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add item to cart.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
$conn->close();
?>
