<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $cek = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

        if (mysqli_num_rows($cek) > 0) {
            $error = 'Email sudah terdaftar.';
        } else {
            mysqli_query(
                $conn,
                "INSERT INTO users(name,email,phone,password,role) 
                 VALUES('$name','$email','$phone','$password','member')"
            );

            $success = 'Registrasi berhasil. Silakan login sebagai pelanggan.';
        }
    }

    if ($action === 'login') {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $q = mysqli_query(
            $conn,
            "SELECT * FROM users WHERE email='$email' LIMIT 1"
        );

        $u = mysqli_fetch_assoc($q);

        if ($u && password_verify($password, $u['password'])) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['name'] = $u['name'];
            $_SESSION['role'] = $u['role'];

            if ($u['role'] === 'admin') {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: index.php');
            }

            exit;
        } else {
            $error = 'Email atau password salah.';
        }
    }
}

include 'includes/header.php';
?>

<div class="section-title">
    <h2>Login</h2>
    <p>
        Satu halaman untuk pelanggan baru, pelanggan lama,
        dan admin Blossom Florist.
    </p>
</div>

<?php if ($success): ?>
    <div class="alert">
        <?= e($success); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert error">
        <?= e($error); ?>
    </div>
<?php endif; ?>

<section class="forms">
    <div class="form-card">
        <h2>Login pelanggan / admin</h2>

        <p class="muted">
            Admin memakai akun khusus dan otomatis masuk ke dashboard admin.
        </p>

        <form method="post">
            <input type="hidden" name="action" value="login">

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button class="btn" type="submit">
                Masuk
            </button>
        </form>
    </div>

    <div class="form-card">
        <h2>Register pelanggan baru</h2>

        <form method="post">
            <input type="hidden" name="action" value="register">

            <label>Nama lengkap</label>
            <input name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Nomor telepon</label>
            <input name="phone" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button class="btn" type="submit">
                Daftar Member
            </button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>