<?php include 'includes/header.php'; ?>
<section class="hero">
  <div>
    <div class="eyebrow">fresh flower • cute bouquet • pastel mood</div>
    <h1>Hadiah bunga yang manis, lembut, dan penuh arti.</h1>
    <p>Blossom Florist membantu kamu memilih bunga sesuai suasana hati: romantis, ucapan selamat, permintaan maaf, dekorasi, sampai hadiah kecil yang bikin hari seseorang jadi lebih cantik.</p>
    <div class="hero-actions"><a class="btn" href="catalog.php">Lihat Katalog</a><a class="btn secondary" href="#meaning">Arti Bunga</a></div>
  </div>
  <img class="hero-img" src="assets/img/hero.svg" alt="Blossom Florist">
</section>
<div class="section-title"><h2>Tentang toko kita</h2><p>Kami merangkai bunga segar setiap hari dengan gaya aesthetic, clean, dan imut tanpa berlebihan. Cocok untuk bouquet wisuda, anniversary, hampers, ucapan cepat sembuh, dan dekorasi meja.</p></div>
<section class="grid">
  <div class="card"><h3>Fresh setiap hari</h3><p>Bunga dipilih dari supplier lokal supaya warna dan bentuk tetap cantik ketika sampai ke pelanggan.</p></div>
  <div class="card"><h3>Bisa custom</h3><p>Pilih ingin dirangkai menjadi bouquet, satuan, tambah kartu ucapan, atau catatan khusus untuk florist.</p></div>
  <div class="card"><h3>Pembayaran QRIS</h3><p>Checkout mudah, upload bukti pembayaran, lalu pesanan bisa dikonfirmasi lewat WhatsApp toko.</p></div>
</section>
<div id="meaning" class="section-title"><h2>Arti bunga</h2><p>Biar hadiahmu terasa lebih personal, pilih bunga sesuai pesan yang ingin kamu sampaikan.</p></div>
<section class="grid flower-meanings">
  <div class="card mini-card"><h3>Rose</h3><p>Melambangkan cinta, apresiasi, dan rasa sayang yang hangat.</p></div>
  <div class="card mini-card"><h3>Sunflower</h3><p>Cocok untuk dukungan, semangat, dan ucapan selamat.</p></div>
  <div class="card mini-card"><h3>Lily</h3><p>Memberi kesan elegan, tulus, dan menenangkan.</p></div>
  <div class="card mini-card"><h3>Tulip</h3><p>Manis untuk sahabat, pasangan, dan hadiah harian.</p></div>
</section>
<div class="section-title"><h2>Berita dari toko</h2><p>Update kecil dari Blossom Florist untuk pelanggan.</p></div>
<section class="grid news">
<?php $news = mysqli_query($conn, "SELECT * FROM news ORDER BY id DESC LIMIT 3"); while($n=mysqli_fetch_assoc($news)): ?>
  <article class="card"><span class="eyebrow"><?= date('d M Y', strtotime($n['created_at'])); ?></span><h3><?= e($n['title']); ?></h3><p><?= e($n['body']); ?></p></article>
<?php endwhile; ?>
</section>
<div class="section-title"><h2>Contact</h2><p>Butuh bantuan pilih bunga? Chat admin kami.</p></div>
<section class="contact-strip">
  <div><h2>Pesan bunga hari ini, kirim rasa sayang hari ini juga.</h2><p>Admin akan membantu konfirmasi stok, warna wrapping, dan jadwal pengiriman.</p></div>
  <a class="btn secondary" href="https://wa.me/6281234567890" target="_blank">Chat WhatsApp Toko</a>
</section>
<?php include 'includes/footer.php'; ?>
