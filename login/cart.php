<?php
session_start();
require_once 'db_connect.php'; // Include the database connection

// Add to cart
if (isset($_POST["add"])) {
    if (isset($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $key => $value) {
            if ($value["product_id"] == $_GET["id"]) {
                $_SESSION["cart"][$key]["item_quantity"] += isset($_POST["quantity"]) ? $_POST["quantity"] : 1;
                header("Location: iced-coffee.php");
                exit;
            }
        }

        $item_array = array(
            'product_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"] ?? '',
            'product_price' => $_POST["hidden_price"] ?? '',
            'item_quantity' => $_POST["quantity"] ?? 1,
        );
        $_SESSION["cart"][] = $item_array;
    } else {
        $item_array = array(
            'product_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"] ?? '',
            'product_price' => $_POST["hidden_price"] ?? '',
            'item_quantity' => $_POST["quantity"] ?? 1,
        );
        $_SESSION["cart"][] = $item_array;
    }
    header("Location: iced-coffee.php");
}

// Remove from cart
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    foreach ($_SESSION["cart"] as $key => $value) {
        if ($value["product_id"] == $_GET["id"]) {
            unset($_SESSION["cart"][$key]);
            $_SESSION["cart"] = array_values($_SESSION["cart"]); // Reindex array
            header("Location: iced-coffee.php");
            exit;
        }
    }
}
?>
