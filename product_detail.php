<?php require_once 'config/database.php'; require_once 'includes/functions.php';
$id=(int)($_GET['id']??0);
if(isset($_POST['like'])){ if(!isset($_SESSION['liked'][$id])){ mysqli_query($conn,"INSERT INTO product_likes(product_id,user_id) VALUES($id,".(isset($_SESSION['user_id'])?(int)$_SESSION['user_id']:'NULL').")"); $_SESSION['liked'][$id]=true; } header('Location: product_detail.php?id='.$id); exit; }
if(isset($_POST['review'])){ $name=mysqli_real_escape_string($conn,$_POST['reviewer_name']); $rating=(int)$_POST['rating']; $comment=mysqli_real_escape_string($conn,$_POST['comment']); mysqli_query($conn,"INSERT INTO reviews(product_id,reviewer_name,rating,comment) VALUES($id,'$name',$rating,'$comment')"); header('Location: product_detail.php?id='.$id); exit; }
include 'includes/header.php';
$p=mysqli_fetch_assoc(mysqli_query($conn,"SELECT p.*, (SELECT COUNT(*) FROM product_likes WHERE product_id=p.id) likes FROM products p WHERE p.id=$id")); if(!$p){ echo '<div class="empty">Produk tidak ditemukan.</div>'; include 'includes/footer.php'; exit; }
?>
<section class="detail">
  <img src="<?= product_image($p['image']); ?>" alt="<?= e($p['name']); ?>">
  <div class="card">
    <h1><?= e($p['name']); ?></h1><div class="price"><?= rupiah($p['price']); ?></div><p><?= nl2br(e($p['description'])); ?></p><p class="love">♥ <?= (int)$p['likes']; ?> suka produk ini</p>
    <div class="hero-actions"><a class="btn" href="add_to_cart.php?id=<?= $p['id']; ?>">Tambah ke Keranjang</a><form method="post" class="inline"><button class="btn secondary" name="like" value="1">Like Produk</button></form></div>
    <h2>Review produk</h2>
    <?php $reviews=mysqli_query($conn,"SELECT * FROM reviews WHERE product_id=$id ORDER BY id DESC"); if(mysqli_num_rows($reviews)==0) echo '<p class="muted">Belum ada review. Jadilah yang pertama.</p>'; while($r=mysqli_fetch_assoc($reviews)): ?>
      <div class="review-box"><b><?= e($r['reviewer_name']); ?></b> — <?= str_repeat('★',(int)$r['rating']); ?><p><?= e($r['comment']); ?></p></div>
    <?php endwhile; ?>
    <h3>Tulis review</h3>
    <form method="post"><input type="hidden" name="review" value="1"><label>Nama</label><input name="reviewer_name" required><label>Rating</label><select name="rating"><option value="5">5 - Sangat suka</option><option value="4">4 - Bagus</option><option value="3">3 - Cukup</option></select><label>Komentar</label><textarea name="comment" required></textarea><button class="btn soft" type="submit">Kirim Review</button></form>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
