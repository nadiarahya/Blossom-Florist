<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

require_login();

$cart = $_SESSION['cart'] ?? [];

if (!$cart) {
    header('Location: cart.php');
    exit;
}

$total = 0;
$product_names = [];

foreach ($cart as $i) {
    $total += $i['price'] * $i['qty'];
    $product_names[] = $i['name'] . ' x' . $i['qty'];
}

$product_list = implode(', ', $product_names);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['buyer_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $postal = mysqli_real_escape_string($conn, $_POST['postal_code']);
    $custom = mysqli_real_escape_string($conn, $_POST['custom_type']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $user_id = (int) $_SESSION['user_id'];
    $proof = '';

    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];

        if (in_array($ext, $allowed)) {
            $proof = 'bukti_' . time() . '_' . rand(100, 999) . '.' . $ext;

            move_uploaded_file(
                $_FILES['payment_proof']['tmp_name'],
                'uploads/payments/' . $proof
            );
        }
    }

    mysqli_query(
        $conn,
        "INSERT INTO orders(
            user_id,
            buyer_name,
            phone,
            address,
            city,
            postal_code,
            custom_type,
            note,
            total,
            payment_method,
            payment_proof,
            status
        ) VALUES(
            $user_id,
            '$name',
            '$phone',
            '$address',
            '$city',
            '$postal',
            '$custom',
            '$note',
            $total,
            'QRIS',
            '$proof',
            'Menunggu Pembayaran'
        )"
    );

    $order_id = mysqli_insert_id($conn);

    foreach ($cart as $item) {
        $pid = (int) $item['id'];
        $qty = (int) $item['qty'];
        $price = (float) $item['price'];
        $product_name = mysqli_real_escape_string($conn, $item['name']);

        mysqli_query(
            $conn,
            "INSERT INTO order_items(
                order_id,
                product_id,
                product_name,
                qty,
                price
            ) VALUES(
                $order_id,
                $pid,
                '$product_name',
                $qty,
                $price
            )"
        );
    }

    unset($_SESSION['cart']);

    $msg = urlencode(
        "Halo Blossom Florist, saya sudah checkout pesanan #$order_id dengan total "
        . rupiah($total)
        . ". Mohon dikonfirmasi ya."
    );

    header("Location: https://wa.me/628993332333?text=$msg");
    exit;
}

include 'includes/header.php';
?>

<div class="section-title">
    <h2>Checkout pemesanan</h2>
</div>

<section class="checkout">
    <form class="form-card" method="post" enctype="multipart/form-data">
        <label>Nama produk</label>
        <input
            type="text"
            value="<?= e($product_list); ?>"
            readonly
        >

        <label>Nama pembeli</label>
        <input
            name="buyer_name"
            required
        >

        <label>Nomor telepon</label>
        <input name="phone" required>

        <label>Alamat lengkap</label>
        <textarea name="address" required></textarea>

        <label>Kota</label>
        <input name="city" required>

        <label>Kode pos</label>
        <input name="postal_code" required>

        <label>Detail custom</label>
        <select name="custom_type">
            <option>Dirangkai menjadi bouquet</option>
            <option>Satuan / per tangkai</option>
            <option>Bouquet + kartu ucapan</option>
            <option>Custom sesuai catatan</option>
        </select>

        <label>Catatan</label>
        <textarea name="note"></textarea>

        <label>Upload bukti pembayaran</label>
        <input
            type="file"
            name="payment_proof"
            accept="image/*,.pdf"
        >

        <button class="btn" type="submit">
            Kirim Pesanan
        </button>
    </form>

    <aside class="qris">
        <h2>Total</h2>

        <div class="price">
            <?= rupiah($total); ?>
        </div>

        <img src="assets/img/qris.jpg" alt="QRIS Blossom Florist">

        <p class="qris-name">
            Atas nama: <b>Blossom Florist</b>
        </p>

        <p class="muted">
            Scan QRIS ini untuk melakukan pembayaran.
            Setelah membayar, upload bukti pembayaran pada form checkout.
        </p>
    </aside>
</section>

<?php include 'includes/footer.php'; ?>