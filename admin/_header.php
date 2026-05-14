<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

require_admin();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <a class="brand" href="dashboard.php">✿ admin</a>

            <p>
                jangan lupa save password setelah login
            </p>

            <a href="dashboard.php">Dashboard</a>
            <a href="products.php">Kelola Produk</a>
            <a href="orders.php">Pesanan</a>
            <a href="attendance.php">Presensi Admin</a>
            <a href="../index.php">Back Home</a>
        </aside>

        <main class="admin-main">