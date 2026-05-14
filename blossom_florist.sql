CREATE DATABASE IF NOT EXISTS blossom_florist
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE blossom_florist;

DROP TABLE IF EXISTS attendance;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS product_likes;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS news;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(30),
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'member') DEFAULT 'member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(12, 2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE product_likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    reviewer_name VARCHAR(120) NOT NULL,
    rating INT DEFAULT 5,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    buyer_name VARCHAR(120) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    custom_type VARCHAR(100),
    note TEXT,
    total DECIMAL(12, 2) NOT NULL,
    payment_method VARCHAR(40) DEFAULT 'QRIS',
    payment_proof VARCHAR(255),
    status ENUM(
        'Menunggu Pembayaran',
        'Diproses',
        'Dikirim',
        'Selesai',
        'Dibatalkan'
    ) DEFAULT 'Menunggu Pembayaran',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(150),
    qty INT NOT NULL,
    price DECIMAL(12, 2) NOT NULL
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users(name, email, phone, password, role)
VALUES
    (
        'Admin Blossom',
        'admin@blossom.test',
        '081234567890',
        '$2y$12$AjYZL1Hdj8bTOIhTuI7In.od45lBNjBJWU1ZRjzTYAoAqK.FhMUxy',
        'admin'
    ),
    (
        'Member Demo',
        'member@blossom.test',
        '081298765432',
        '$2y$12$AjYZL1Hdj8bTOIhTuI7In.od45lBNjBJWU1ZRjzTYAoAqK.FhMUxy',
        'member'
    );

INSERT INTO products(name, description, price, stock, image)
VALUES
    (
        'Rose Pastel Bouquet',
        'Bouquet rose lembut untuk anniversary, ulang tahun, atau hadiah romantis. Warna wrapping bisa request pastel.',
        150000,
        20,
        'assets/img/product-1.svg'
    ),
    (
        'Sunflower Joy',
        'Bunga matahari cerah untuk ucapan selamat, wisuda, dan dukungan semangat.',
        125000,
        15,
        'assets/img/product-2.svg'
    ),
    (
        'Lavender Calm',
        'Rangkaian lavender bernuansa calming untuk dekorasi meja dan hadiah yang menenangkan.',
        135000,
        12,
        'assets/img/product-3.svg'
    ),
    (
        'Tulip Sweet Mix',
        'Tulip manis dengan warna soft, cocok untuk sahabat atau pasangan.',
        175000,
        10,
        'assets/img/product-4.svg'
    ),
    (
        'Lily Pure White',
        'Lily putih elegan untuk ucapan tulus, sympathy, atau dekorasi simple.',
        160000,
        13,
        'assets/img/product-5.svg'
    ),
    (
        'Peony Soft Bloom',
        'Peony fluffy bernuansa cute dan premium untuk hadiah spesial.',
        220000,
        8,
        'assets/img/product-6.svg'
    ),
    (
        'Green Basket Arrangement',
        'Rangkaian bunga dan daun dalam basket untuk dekorasi rumah atau hampers.',
        190000,
        9,
        'assets/img/product-7.svg'
    ),
    (
        'Orchid Grace',
        'Anggrek elegan yang tahan lama untuk hadiah formal atau dekorasi.',
        210000,
        7,
        'assets/img/product-8.svg'
    );

INSERT INTO reviews(product_id, reviewer_name, rating, comment)
VALUES
    (1, 'Alya', 5, 'Bouquet-nya wangi dan wrapping-nya super cute.'),
    (1, 'Nadya', 5, 'Cocok banget buat anniversary.'),
    (2, 'Raka', 5, 'Bunganya fresh, bikin hadiah wisuda makin cerah.'),
    (4, 'Mira', 4, 'Warna tulipnya lembut dan cantik.'),
    (6, 'Salsa', 5, 'Peony-nya kelihatan premium dan imut.');

INSERT INTO product_likes(product_id, user_id)
VALUES
    (1, 2),
    (1, NULL),
    (2, 2),
    (4, NULL),
    (6, 2),
    (6, NULL);

INSERT INTO news(title, body)
VALUES
    (
        'Promo bouquet wisuda',
        'Minggu ini tersedia diskon kecil untuk bouquet wisuda dengan kartu ucapan gratis.'
    ),
    (
        'Stok tulip pastel datang',
        'Tulip warna soft pink dan cream sudah ready untuk dirangkai.'
    ),
    (
        'Custom wrapping baru',
        'Sekarang kamu bisa request wrapping hijau pastel, biru soft, atau putih minimalis.'
    );

INSERT INTO orders(
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
    status,
    created_at
)
VALUES
    (
        2,
        'Member Demo',
        '081298765432',
        'Jl. Mawar No. 7',
        'Tangerang',
        '15111',
        'Dirangkai menjadi bouquet',
        'Wrapping hijau pastel',
        275000,
        'QRIS',
        'Selesai',
        DATE_SUB(NOW(), INTERVAL 10 DAY)
    );

INSERT INTO order_items(order_id, product_id, product_name, qty, price)
VALUES
    (1, 1, 'Rose Pastel Bouquet', 1, 150000),
    (1, 2, 'Sunflower Joy', 1, 125000);