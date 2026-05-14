<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

require_login();

include 'includes/header.php';

$uid = (int) $_SESSION['user_id'];

$orders = mysqli_query(
    $conn,
    "SELECT * FROM orders WHERE user_id=$uid ORDER BY id DESC"
);
?>

<div class="section-title">
    <h2>Riwayat transaksi</h2>
</div>

<?php if (mysqli_num_rows($orders) == 0): ?>
    <div class="empty">
        Belum ada transaksi.
    </div>
<?php else: ?>
    <div class="horizontal-scroll">
        <table>
            <tr>
                <th>Kode</th>
                <th>Pembeli</th>
                <th>Detail</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>

            <?php while ($o = mysqli_fetch_assoc($orders)): ?>
                <tr>
                    <td>#<?= $o['id']; ?></td>

                    <td>
                        <b><?= e($o['buyer_name']); ?></b><br>
                        <?= e($o['phone']); ?><br>
                        <?= e($o['city']); ?> <?= e($o['postal_code']); ?>
                    </td>

                    <td>
                        <?= e($o['custom_type']); ?><br>
                        <span class="muted"><?= e($o['note']); ?></span>
                    </td>

                    <td><?= rupiah($o['total']); ?></td>

                    <td><?= order_status_badge($o['status']); ?></td>

                    <td>
                        <?= date('d M Y H:i', strtotime($o['created_at'])); ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>