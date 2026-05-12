BLOSSOM FLORIST - WEBSITE E-COMMERCE TOKO BUNGA
================================================

Teknologi:
- HTML
- CSS
- PHP
- MySQL
- XAMPP

CARA MENJALANKAN DI XAMPP:
1. Extract file ZIP ini.
2. Copy folder blossom_florist_v2 ke:
   C:\xampp\htdocs\
3. Jalankan XAMPP, klik Start pada Apache dan MySQL.
4. Buka browser:
   http://localhost/phpmyadmin
5. Klik Import, pilih file:
   blossom_florist.sql
6. Setelah import berhasil, buka website:
   http://localhost/blossom_florist_v2/

AKUN DEMO:
Admin:
Email    : admin@blossom.test
Password : admin123

Member:
Email    : member@blossom.test
Password : admin123

CATATAN:
- Halaman login dan register pelanggan berada dalam satu file: login.php
- Admin login dari halaman yang sama. Kalau role admin, otomatis masuk dashboard admin.
- Dashboard admin punya fitur:
  * lihat pendapatan toko bulan ini
  * lihat total pesanan, member, produk
  * tambah/edit/delete katalog
  * upload foto produk
  * lihat siapa yang pesan dan produk apa yang dipesan
  * ubah status pemesanan
  * lihat bukti pembayaran
  * presensi admin yang sedang login
  * logout

FITUR PELANGGAN:
- Home berisi kata-kata toko, tentang Blossom Florist, arti bunga, berita toko, contact.
- Katalog berisi foto, harga, deskripsi, like, detail, review, tambah keranjang.
- Keranjang bisa update jumlah produk.
- Checkout berisi nama pembeli, nomor telepon, alamat, kota, kode pos, detail custom bouquet/satuan/kartu ucapan, catatan, QRIS, upload bukti pembayaran.
- Setelah checkout diarahkan ke WhatsApp toko.
- Riwayat transaksi menampilkan status pesanan.

MENGGANTI NOMOR WHATSAPP TOKO:
Cari angka ini di file checkout.php dan includes/footer.php:
6281234567890
Ganti dengan nomor toko kamu memakai format 62.

MENGGANTI QRIS:
Ganti file:
assets/img/qris.svg
atau ubah tag gambar di checkout.php jika ingin pakai qris.png.

MENGGANTI WARNA TEMA:
Buka:
assets/css/style.css
Bagian atas file ada :root, ubah warna berikut:
--dark, --deep, --mint, --aqua, --cream.

CATATAN UPLOAD FOTO:
Jika upload foto katalog gagal, pastikan folder ini ada dan bisa ditulis:
uploads/products
uploads/payments
