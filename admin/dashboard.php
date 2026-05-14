<?php
include '_header.php';

$month = date('m');
$year = date('Y');

$income = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COALESCE(SUM(total),0) total 
         FROM orders 
         WHERE MONTH(created_at)='$month' 
         AND YEAR(created_at)='$year' 
         AND status!='Dibatalkan'"
    )
)['total'];

$orders = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) total FROM orders")
)['total'];

$members = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) total FROM users WHERE role='member'")
)['total'];

$products = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) total FROM products")
)['total'];

$recent = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC LIMIT 6");
?>

<div class="section-title">
    <h2>Dashboard admin</h2>
</div>

<section class="stats">
    <div class="stat">
        Pendapatan bulan ini
        <b><?= rupiah($income); ?></b>
    </div>

    <div class="stat">
        Total pesanan
        <b><?= $orders; ?></b>
    </div>

    <div class="stat">
        Pesanan Dikirim
        <b><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM orders WHERE status='Dikirim'"))['total']; ?></b>
    </div>

    <div class="stat">
        Produk katalog
        <b><?= $products; ?></b>
    </div>
</section>

<div class="section-title">
    <h2>pesanan terbaru</h2>
    <a class="btn soft" href="orders.php">Kelola Semua</a>
</div>

<div class="horizontal-scroll">
    <table>
        <tr>
            <th>Kode</th>
            <th>Nama pembeli</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>

        <?php while ($o = mysqli_fetch_assoc($recent)): ?>
            <tr>
                <td>#<?= $o['id']; ?></td>
                <td>
                    <?= e($o['buyer_name']); ?><br>
                    <span class="muted"><?= e($o['phone']); ?></span>
                </td>
                <td><?= rupiah($o['total']); ?></td>
                <td><?= order_status_badge($o['status']); ?></td>
                <td><?= date('d M Y H:i', strtotime($o['created_at'])); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include '_footer.php'; ?>