<?php require_once __DIR__ . '/../config/database.php'; require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blossom Florist</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <a class="brand" href="index.php"><span>✿</span> blossom florist</a>
  <nav class="main-nav">
    <a href="index.php">Home</a>
    <a href="catalog.php">Katalog</a>
    <a href="cart.php">Keranjang <em><?= cart_count(); ?></em></a>
    <a href="history.php">Riwayat Transaksi</a>
    <?php if(is_login()): ?>
      <?php if(is_admin()): ?><a href="admin/dashboard.php">Dashboard Admin</a><?php endif; ?>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
    <?php endif; ?>
  </nav>
</header>
<main>
