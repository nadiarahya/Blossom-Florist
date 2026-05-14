<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$id = (int) ($_GET['id'] ?? 0);

$p = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM products WHERE id=$id")
);

if ($p) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty']++;
    } else {
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'name' => $p['name'],
            'price' => $p['price'],
            'qty' => 1,
            'image' => $p['image'],
        ];
    }
}

header('Location: cart.php');