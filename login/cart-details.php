<?php
session_start();
include("connect.php");
// Function to calculate the total price of items in the cart
function calculateTotal() {
    $total = 0;
    foreach ($_SESSION["cart"] as $item) {
        $total += $item["item_quantity"] * $item["product_price"];
    }
    return $total;
}

// Handle removing an item from the cart
if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
    $product_id = $_GET["id"];
    foreach ($_SESSION["cart"] as $key => $item) {
        if ($item["product_id"] == $product_id) {
            unset($_SESSION["cart"][$key]); // Remove the item from the cart
            echo '<script>alert("Item removed from cart!")</script>';
            echo '<script>window.location="cart-details.php"</script>'; // Redirect to the same page to update the cart
            break;
        }
    }
}
include("header.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Angkor&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;        
            background-color: rgb(245, 234, 223);
        }
table, th, td {
    text-align: center;
    border-collapse: collapse;
    width: 100%;
}

table {
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

.title2, h2 {
    text-align: center;
    color: #66afe9;
    background-color: #efefef;
    padding: 20px;
    border-radius: 8px;
    font-size: 24px;
}

table th {
    background-color: #efefef;
    padding: 15px;
    font-weight: bold;
    border: 1px solid #ccc;
    color: #333;
    font-size: 16px;
}

table td {
    padding: 12px;
    border: 1px solid #ddd;
    color: #333;
    font-size: 14px;
}

table tr:hover {
    background-color: #f9f9f9;
}

.btn-success {
    margin-top: 5px;
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn-success:hover {
    background-color: #218838;
}

    </style>
</head>
<body>

<div class="container" style="width: 65%">
    <h2>Shopping Cart</h2>
    <div class="table-responsive">
        <?php if (!empty($_SESSION["cart"])): ?>
        <table class="table table-bordered">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>
            <?php
            $total = calculateTotal(); // Calculate the total price here
            foreach ($_SESSION["cart"] as $item) {
                $product_total = $item["item_quantity"] * $item["product_price"];
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item["item_name"]); ?></td>
                <td><?php echo htmlspecialchars($item["item_quantity"]); ?></td>
                <td>$<?php echo number_format($item["product_price"], 2); ?></td>
                <td>$<?php echo number_format($product_total, 2); ?></td>
                <td><a href="cart-details.php?action=delete&id=<?php echo $item["product_id"]; ?>" class="text-danger">Remove</a></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="3" text-align="right">Total</td>
                <td colspan="2">$<?php echo number_format($total, 2); ?></td>
            </tr>
        </table>
        <form method="post" action="order-checkout.php">
            <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
        </form>
        <?php else: ?>
        <div class="alert alert-info text-center">
            <strong>Your cart is empty!</strong> Browse products and add them to your cart.
        </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
