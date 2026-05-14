<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

require_login();

$id = (int) ($_GET['id'] ?? 0);
$uid = (int) $_SESSION['user_id'];

$where = is_admin()
    ? "id=$id"
    : "id=$id AND user_id=$uid";

$o = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM orders WHERE $where")
);

include 'includes/header.php';

if (!$o) {
    echo '<div class="empty">Invoice tidak ditemukan.</div>';
    include 'includes/footer.php';
    exit;
}

$items = mysqli_query(
    $conn,
    "SELECT * FROM order_items WHERE order_id=" . (int) $o['id']
);
?>

<section class="invoice-card" id="invoice">
    <div class="invoice-head">
        <div>
            <p class="eyebrow">Invoice Pesanan</p>
            <h1><?= order_code($o['id']); ?></h1>
            <p class="muted">
                Tanggal: <?= date('d M Y H:i', strtotime($o['created_at'])); ?>
            </p>
        </div>

        <div>
            <?= order_status_badge($o['status']); ?>
        </div>
    </div>

    <div class="invoice-grid">
        <div>
            <h3>Data Pembeli</h3>
            <p>
                <b><?= e($o['buyer_name']); ?></b><br>
                <?= e($o['phone']); ?><br>
                <?= e($o['address']); ?><br>
                <?= e($o['city']); ?>, <?= e($o['postal_code']); ?>
            </p>
        </div>

        <div>
            <h3>Pembayaran</h3>
            <p>
                Metode: <?= e($o['payment_method']); ?><br>
                Total: <b><?= rupiah($o['total']); ?></b>
            </p>

            <?php if ($o['payment_proof']): ?>
                <a
                    class="btn soft"
                    target="_blank"
                    href="uploads/payments/<?= e($o['payment_proof']); ?>"
                >
                    Lihat Bukti Bayar
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="horizontal-scroll">
        <table>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>

            <?php while ($it = mysqli_fetch_assoc($items)): ?>
                <tr>
                    <td><?= e($it['product_name']); ?></td>
                    <td><?= (int) $it['qty']; ?></td>
                    <td><?= rupiah($it['price']); ?></td>
                    <td><?= rupiah($it['price'] * $it['qty']); ?></td>
                </tr>
            <?php endwhile; ?>

            <tr>
                <th colspan="3">Total</th>
                <th><?= rupiah($o['total']); ?></th>
            </tr>
        </table>
    </div>

    <p>
        <b>Custom:</b> <?= e($o['custom_type']); ?><br>
        <b>Catatan:</b> <?= e($o['note']); ?>
    </p>

    <div class="hero-actions no-print">
        <button class="btn" onclick="window.print()">
            Cetak Invoice
        </button>

        <?php if (isset($_GET['wa'])): ?>
            <a class="btn soft" href="<?= e($_GET['wa']); ?>">
                Chat WhatsApp Toko
            </a>
        <?php endif; ?>

        <a class="btn secondary" href="history.php">
            Kembali ke Riwayat
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>