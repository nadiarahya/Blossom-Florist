<?php
include '_header.php';

function upload_product_image($old = '')
{
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg'])) {
            $name = 'produk_' . time() . '_' . rand(100, 999) . '.' . $ext;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                '../uploads/products/' . $name
            );

            return $name;
        }
    }

    return $old;
}

if (isset($_POST['save'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float) $_POST['price'];
    $stock = (int) $_POST['stock'];
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $id = (int) ($_POST['id'] ?? 0);
    $old = $_POST['old_image'] ?? '';
    $image = upload_product_image($old);

    if ($id > 0) {
        mysqli_query(
            $conn,
            "UPDATE products 
             SET name='$name',
                 price=$price,
                 stock=$stock,
                 description='$desc',
                 image='$image' 
             WHERE id=$id"
        );
    } else {
        mysqli_query(
            $conn,
            "INSERT INTO products(name,price,stock,description,image) 
             VALUES('$name',$price,$stock,'$desc','$image')"
        );
    }

    header('Location: products.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    mysqli_query($conn, "DELETE FROM products WHERE id=$id");

    header('Location: products.php');
    exit;
}

$edit = null;

if (isset($_GET['edit'])) {
    $eid = (int) $_GET['edit'];

    $edit = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT * FROM products WHERE id=$eid")
    );
}

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<div class="section-title">
    <h2>Kelola produk</h2>
</div>

<section class="forms">
    <form class="form-card" method="post" enctype="multipart/form-data">
        <h2><?= $edit ? 'Edit produk' : 'Tambah produk'; ?></h2>

        <input type="hidden" name="id" value="<?= $edit['id'] ?? 0; ?>">
        <input type="hidden" name="old_image" value="<?= e($edit['image'] ?? ''); ?>">

        <label>Nama produk</label>
        <input
            name="name"
            value="<?= e($edit['name'] ?? ''); ?>"
            required
        >

        <label>Harga</label>
        <input
            type="number"
            name="price"
            value="<?= e($edit['price'] ?? ''); ?>"
            required
        >

        <label>Stok</label>
        <input
            type="number"
            name="stock"
            value="<?= e($edit['stock'] ?? 10); ?>"
            required
        >

        <label>Deskripsi</label>
        <textarea name="description" required><?= e($edit['description'] ?? ''); ?></textarea>

        <label>Foto produk</label>
        <input
            type="file"
            name="image"
            id="imageInput"
            accept="image/*"
        >

        <button class="btn" name="save" value="1">
            Simpan
        </button>
    </form>

    <div class="card preview-card">
        <h2>Preview foto produk</h2>
        <p class="muted">
        </p>

        <div class="preview-box">
            <?php if (!empty($edit['image'])): ?>
                <img
                    id="imagePreview"
                    src="../<?= product_image($edit['image']); ?>"
                    alt="Preview produk"
                >
            <?php else: ?>
                <img
                    id="imagePreview"
                    src=""
                    alt="Preview produk"
                    style="display: none;"
                >

                <div id="previewPlaceholder" class="preview-placeholder">
                    Belum ada gambar dipilih
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<div class="section-title">
    <h2>Daftar produk</h2>
</div>

<div class="horizontal-scroll">
    <table>
        <tr>
            <th>Foto</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php while ($p = mysqli_fetch_assoc($products)): ?>
            <tr>
                <td>
                    <img
                        class="small-img"
                        src="../<?= product_image($p['image']); ?>"
                    >
                </td>

                <td>
                    <b><?= e($p['name']); ?></b><br>
                    <span class="muted">
                        <?= e(substr($p['description'], 0, 80)); ?>
                    </span>
                </td>

                <td><?= rupiah($p['price']); ?></td>
                <td><?= $p['stock']; ?></td>

                <td class="admin-actions">
                    <a class="btn soft" href="products.php?edit=<?= $p['id']; ?>">
                        Edit
                    </a>

                    <a
                        class="btn danger"
                        onclick="return confirm('Hapus produk ini?')"
                        href="products.php?delete=<?= $p['id']; ?>"
                    >
                        Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewPlaceholder = document.getElementById('previewPlaceholder');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';

                if (previewPlaceholder) {
                    previewPlaceholder.style.display = 'none';
                }
            };

            reader.readAsDataURL(file);
        }
    });
</script>

<?php include '_footer.php'; ?>