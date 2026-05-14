<?php
function rupiah($angka)
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}

function e($str)
{
    return htmlspecialchars((string) $str, ENT_QUOTES, 'UTF-8');
}

function is_login()
{
    return isset($_SESSION['user_id']);
}

function is_admin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function require_login()
{
    if (!is_login()) {
        header('Location: login.php');
        exit;
    }
}

function require_admin()
{
    if (!is_admin()) {
        header('Location: ../login.php?admin=1');
        exit;
    }
}

function cart_count()
{
    return isset($_SESSION['cart'])
        ? array_sum(array_column($_SESSION['cart'], 'qty'))
        : 0;
}

function product_image($file)
{
    if (!$file) {
        return 'assets/img/product-default.svg';
    }

    if (strpos($file, '/') !== false) {
        return $file;
    }

    return 'uploads/products/' . $file;
}

function order_code($id)
{
    return 'BF-' . str_pad((int) $id, 4, '0', STR_PAD_LEFT);
}

function order_status_badge($status)
{
    $map = [
        'Menunggu Pembayaran' => 'warning',
        'Diproses' => 'info',
        'Dikirim' => 'info',
        'Selesai' => 'success',
        'Dibatalkan' => 'danger',
    ];

    $class = $map[$status] ?? 'warning';

    return '<span class="badge ' . $class . '">' . e($status) . '</span>';
}
?>