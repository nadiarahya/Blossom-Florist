<?php
include 'includes/header.php';

$products = mysqli_query(
    $conn,
    "SELECT p.*, 
            (SELECT COUNT(*) FROM product_likes WHERE product_id=p.id) likes 
     FROM products p 
     ORDER BY p.id DESC"
);
?>

<div class="section-title">
    <h2>Katalog bunga</h2>
</div>

<section class="product-grid">
    <?php while ($p = mysqli_fetch_assoc($products)): ?>
        <article class="product-card">
            <img
                src="<?= product_image($p['image']); ?>"
                alt="<?= e($p['name']); ?>"
            >

            <div class="product-body">
                <h3><?= e($p['name']); ?></h3>

                <div class="price">
                    <?= rupiah($p['price']); ?>
                </div>

                <p class="muted">
                    <?= e(substr($p['description'], 0, 90)); ?>...
                </p>

                <div class="love">
                    ♥ <?= (int) $p['likes']; ?> suka
                </div>

                <a
                    class="btn soft"
                    href="product_detail.php?id=<?= $p['id']; ?>"
                >
                    Lihat detail
                </a>

                <a
                    class="btn"
                    href="add_to_cart.php?id=<?= $p['id']; ?>"
                >
                    Tambah ke Keranjang
                </a>
            </div>
        </article>
    <?php endwhile; ?>
</section>

<?php include 'includes/footer.php'; ?>