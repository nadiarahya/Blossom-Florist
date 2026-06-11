<?php include 'includes/header.php'; ?>

<section class="hero">
    <div>
        <div class="eyebrow">
            fresh flower • cutie flower • pretties flower
        </div>

        <h1>Rangkai momen bermakna di setiap helai bunga.</h1>

        <p>
            Blossom Florist hadir untuk merangkai bunga yang paling sesuai dengan 
            penuh makna, mulai dari hadiah manis, ungkapan
            sayang, hingga momen bahagia.
            Blossom pilihan terbaik untuk merayakan setiap detik berharga dengan memberikan kejutan kecil yang mampu 
            membuat hari terasa lebih indah dan berharga.
        </p>

        <div class="hero-actions">
            <a class="btn" href="catalog.php">Lihat Katalog</a>
        </div>
    </div>

    <img
        class="hero-img"
        src="assets/img/hero.jpg"
        alt="Blossom Florist"
    >
</section>

<div class="section-title">
    <h2>Blossom</h2>
</div>

<section class="grid">
    <div class="card">
        <h3>Fresh setiap hari</h3>
        <p>
            Bunga dipilih dari taman lokal supaya warna dan bentuk tetap
            cantik ketika sampai ke pelanggan.
        </p>
    </div>

    <div class="card">
        <h3>Custom</h3>
        <p>
            Ingin dirangkai menjadi bouquet, satuan, serta tambah kartu ucapan khusus untuk seseorang yang dicintai.
        </p>
    </div>

    <div class="card">
        <h3>Metode pembayaran</h3>
        <p>
            Checkout mudah dan simple, pembayaran hanya melalui QRIS toko 
            dengan upload bukti pembayaran, sehingga pesanan diproses.
        </p>
    </div>
</section>

<div id="meaning" class="section-title">
    <h2>Meaning of Flowers</h2>
    <p>
        Rnagkai momen dan makna terasa lebih personal, pilih bunga sesuai pesan yang ingin disampaikan.
    </p>
</div>

<section class="grid flower-meanings">
    <div class="card mini-card">
        <h3>Rose</h3>
        <p>Tidak ada yang bisa menandingi cara mawar bicara tentang perasaan, dengan makna cinta, apresiasi, dan rasa sayang yang hangat.</p>
    </div>

    <div class="card mini-card">
        <h3>Lavender</h3>
        <p>Memberikan ketenangan di tengah kesibukan melalui keindahan lavender yang meneduhkan.</p>
    </div>

    <div class="card mini-card">
        <h3>Lily</h3>
        <p>Rangkaian yang sempurna untuk menyampaikan makna elegant pesona rasa hormat dan kekaguman yang tulus.</p>
    </div>

    <div class="card mini-card">
        <h3>Tulip</h3>
        <p>Hadirkan kehangatan dan senyum di wajahnya dengan keanggunan tulip yang memikat.</p>
    </div>
</section>

<div class="section-title">
    <h2>Pusat Informasi</h2>
</div>

<section class="grid news">
    <?php
    $news = mysqli_query($conn, "SELECT * FROM news ORDER BY id DESC LIMIT 3");

    while ($n = mysqli_fetch_assoc($news)):
    ?>
        <article class="card">
            <span class="eyebrow">
                <?= date('d M Y', strtotime($n['created_at'])); ?>
            </span>

            <h3><?= e($n['title']); ?></h3>
            <p><?= e($n['body']); ?></p>
        </article>
    <?php endwhile; ?>
</section>

<div class="section-title">
    <h2>Contact</h2>
    <p>Butuh bantuan terhadap produk? Chat admin kami.</p>
</div>

<section class="contact-strip">
    <div>
        <h2>Pesan bunga hari ini, rangkai momen indah hari ini juga.</h2>
        <p>
            admin akan membantu konfirmasi stok, warna wrapping,
            dan jadwal pengiriman serta lainnya yang berkaitan dengan produk dan layanan kami.
        </p>
    </div>

    <a
        class="btn secondary"
        href="https://wa.me/628993332333"
        target="_blank"
    >
        Chat WhatsApp Toko
    </a>
</section>

<?php include 'includes/footer.php'; ?>