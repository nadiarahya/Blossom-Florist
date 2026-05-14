<?php include 'includes/header.php'; ?>

<section class="hero">
    <div>
        <div class="eyebrow">
            fresh flower • cutie flower • pretties flower
        </div>

        <h1>Rangkai momen bermakna di setiap helai bunga.</h1>

        <p>
            Blossom Florist hadir untuk merangkai bunga yang paling sesuai dengan 
            suasana hati dengan penuh makna, mulai dari hadiah manis, ungkapan
            sayang, hingga momen bahagia.
            Temukan pilihan terbaik untuk merayakan setiap detik berharga dengan memberikan kejutan kecil yang mampu 
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
    <h2>Filosofi Blossom</h2>
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
        <h3>Bisa custom</h3>
        <p>
            Ingin dirangkai menjadi bouquet, satuan, tambah kartu ucapan,
            atau catatan khusus untuk florist.
        </p>
    </div>

    <div class="card">
        <h3>Metode pembayaran</h3>
        <p>
            Checkout mudah dan simple, pemmbayaran hanya melalui QRIS toko 
            dengan upload bukti pembayaran, sehingga pesanan diproses.
        </p>
    </div>
</section>

<div id="meaning" class="section-title">
    <h2>Arti bunga</h2>
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
    <p>Butuh bantuan memilih produk? Chat admin kami.</p>
</div>

<section class="contact-strip">
    <div>
        <h2>Pesan bunga hari ini, rangkai momen indah hari ini juga.</h2>
        <p>
            admin akan membantu konfirmasi stok, warna wrapping,
            dan jadwal pengiriman.
        </p>
    </div>

    <a
        class="btn secondary"
        href="https://wa.me/6281234567890"
        target="_blank"
    >
        Chat WhatsApp Toko
    </a>
</section>

<?php include 'includes/footer.php'; ?>