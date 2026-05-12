<?php include '_header.php'; $uid=(int)$_SESSION['user_id'];
if(isset($_POST['present'])){ $note=mysqli_real_escape_string($conn,$_POST['note']); mysqli_query($conn,"INSERT INTO attendance(user_id,note) VALUES($uid,'$note')"); header('Location: attendance.php'); exit; }
$logs=mysqli_query($conn,"SELECT a.*,u.name FROM attendance a JOIN users u ON a.user_id=u.id ORDER BY a.id DESC LIMIT 30"); ?>
<div class="section-title"><h2>Presensi admin</h2><p>Presensi untuk admin yang sedang login.</p></div>
<section class="forms"><form class="form-card" method="post"><h2>Presensi hari ini</h2><label>Catatan</label><textarea name="note" placeholder="Contoh: Masuk shift pagi, cek pesanan, update katalog."></textarea><button class="btn" name="present" value="1">Presensi Sekarang</button></form><div class="card"><h2>Admin login</h2><p><?= e($_SESSION['name']); ?></p></div></section>
<div class="section-title"><h2>Log presensi</h2></div><table><tr><th>Admin</th><th>Catatan</th><th>Waktu</th></tr><?php while($l=mysqli_fetch_assoc($logs)): ?><tr><td><?= e($l['name']); ?></td><td><?= e($l['note']); ?></td><td><?= date('d M Y H:i',strtotime($l['created_at'])); ?></td></tr><?php endwhile; ?></table>
<?php include '_footer.php'; ?>
