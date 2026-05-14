<?php
include '_header.php';

$uid = (int) $_SESSION['user_id'];

if (isset($_POST['present'])) {
    $admin_name = mysqli_real_escape_string($conn, $_POST['admin_name']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    mysqli_query(
        $conn,
        "INSERT INTO attendance(user_id, admin_name, note) 
         VALUES($uid, '$admin_name', '$note')"
    );

    header('Location: attendance.php');
    exit;
}

$logs = mysqli_query(
    $conn,
    "SELECT * 
     FROM attendance 
     ORDER BY id DESC 
     LIMIT 30"
);
?>

<div class="section-title">
    <h2>Presensi admin</h2>
</div>

<section class="attendance-section">
    <form class="form-card attendance-card" method="post">
        <h2>Presensi hari ini</h2>

        <label>Nama Admin</label>
        <input
            type="text"
            name="admin_name"
            required
        >

        <label>Catatan</label>
        <textarea
            name="note"
            placeholder="masuk (shift pagi/malam), sakit(demam)"
            required
        ></textarea>

        <button class="btn" name="present" value="1">
            absen
        </button>
    </form>
</section>

<div class="section-title">
    <h2>riwayat presensi</h2>
</div>

<div class="attendance-history">
    <table>
        <tr>
            <th>Admin</th>
            <th>Catatan</th>
            <th>Waktu</th>
        </tr>

        <?php while ($l = mysqli_fetch_assoc($logs)): ?>
            <tr>
                <td><?= e($l['admin_name']); ?></td>
                <td><?= e($l['note']); ?></td>
                <td><?= date('d M Y H:i', strtotime($l['created_at'])); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include '_footer.php'; ?>