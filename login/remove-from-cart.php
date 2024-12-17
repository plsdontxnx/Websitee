<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    if (isset($_SESSION['cart_items'])) {
        foreach ($_SESSION['cart_items'] as $key => $item) {
            if ($item['id'] == $product_id) {
                unset($_SESSION['cart_items'][$key]); // Remove the item from the cart
                echo 'success';
                exit();
            }
        }
    }

    echo 'failed'; // If item not found or not removed
    exit();
}
