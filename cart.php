<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $qty = max(0, (int) $qty);

        if ($qty == 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['qty'] = $qty;
        }
    }

    header('Location: cart.php');
    exit;
}

include 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<div class="section-title">
    <h2>Keranjang</h2>
</div>

<?php if (!$cart): ?>
    <div class="empty">
        Keranjang masih kosong.
        <a href="catalog.php">Belanja dulu yuk.</a>
    </div>
<?php else: ?>
    <form method="post">
        <div class="horizontal-scroll">
            <table>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>

                <?php foreach ($cart as $id => $item): ?>
                    <?php
                    $sub = $item['price'] * $item['qty'];
                    $total += $sub;
                    ?>

                    <tr>
                        <td>
                            <img
                                class="small-img"
                                src="<?= product_image($item['image']); ?>"
                            >
                            <b><?= e($item['name']); ?></b>
                        </td>

                        <td><?= rupiah($item['price']); ?></td>

                        <td>
                            <input
                                class="qty"
                                type="number"
                                name="qty[<?= $id; ?>]"
                                value="<?= $item['qty']; ?>"
                                min="0"
                            >
                        </td>

                        <td><?= rupiah($sub); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="total-box">
            <b>Total: <?= rupiah($total); ?></b>

            <div>
                <button class="btn soft" type="submit">
                    Update
                </button>

                <a class="btn" href="checkout.php">
                    Checkout
                </a>
            </div>
        </div>
    </form>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>