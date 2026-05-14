<?php
include '_header.php';

if (isset($_POST['status'])) {
    $id = (int) $_POST['order_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$id");

    header('Location: orders.php');
    exit;
}

$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
?>

<div class="section-title">
    <h2>Data pemesanan</h2>
</div>

<div class="horizontal-scroll">
    <table>
        <tr>
            <th>Kode</th>
            <th>Pembeli</th>
            <th>Produk dipesan</th>
            <th>Alamat</th>
            <th>Custom</th>
            <th>Total/Bukti</th>
            <th>Status</th>
        </tr>

        <?php while ($o = mysqli_fetch_assoc($orders)): ?>
            <?php
            $items = mysqli_query(
                $conn,
                "SELECT * FROM order_items WHERE order_id=" . (int) $o['id']
            );
            ?>

            <tr>
                <td>
                    #<?= $o['id']; ?><br>
                    <span class="muted">
                        <?= date('d M Y H:i', strtotime($o['created_at'])); ?>
                    </span>
                </td>

                <td>
                    <b><?= e($o['buyer_name']); ?></b><br>
                    <?= e($o['phone']); ?>
                </td>

                <td>
                    <?php while ($it = mysqli_fetch_assoc($items)): ?>
                        • <?= e($it['product_name']); ?> x<?= $it['qty']; ?><br>
                    <?php endwhile; ?>
                </td>

                <td>
                    <?= e($o['address']); ?><br>
                    <?= e($o['city']); ?>, <?= e($o['postal_code']); ?>
                </td>

                <td>
                    <?= e($o['custom_type']); ?><br>
                    <span class="muted"><?= e($o['note']); ?></span>
                </td>

                <td>
                    <?= rupiah($o['total']); ?><br>

                    <?php if ($o['payment_proof']): ?>
                        <a
                            class="btn soft"
                            target="_blank"
                            href="../uploads/payments/<?= e($o['payment_proof']); ?>"
                        >
                            Lihat bukti
                        </a>
                    <?php else: ?>
                        <span class="muted">Belum upload</span>
                    <?php endif; ?>
                </td>

                <td>
                    <form method="post">
                        <input
                            type="hidden"
                            name="order_id"
                            value="<?= $o['id']; ?>"
                        >

                        <select name="status">
                            <option <?= $o['status'] == 'Menunggu Pembayaran' ? 'selected' : ''; ?>>
                                Menunggu Pembayaran
                            </option>
                            <option <?= $o['status'] == 'Diproses' ? 'selected' : ''; ?>>
                                Diproses
                            </option>
                            <option <?= $o['status'] == 'Dikirim' ? 'selected' : ''; ?>>
                                Dikirim
                            </option>
                            <option <?= $o['status'] == 'Selesai' ? 'selected' : ''; ?>>
                                Selesai
                            </option>
                            <option <?= $o['status'] == 'Dibatalkan' ? 'selected' : ''; ?>>
                                Dibatalkan
                            </option>
                        </select>

                        <button class="btn soft" type="submit">
                            Ubah
                        </button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include '_footer.php'; ?>