<?php 
session_start(); 
include 'db.php'; 
if(!isset($_SESSION['teacher'])){
    header('Location: login.php'); 
    exit; 
} 
$today = date('Y-m-d'); 
$total = $conn->query('SELECT COUNT(*) as t FROM students')->fetch_assoc()['t']; 
$present = $conn->query("SELECT COUNT(DISTINCT student_id) as p FROM attendance WHERE date='$today'")->fetch_assoc()['p']; 
$abs = $total - $present; 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Report</title>
<link rel="stylesheet" href="css/style.css">
<style>
body {
  background-image: url('https://pngmagic.com/webp_images/electric-purple-solid-color-background.webp');
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
}
</style>
</head>
<body>
<header>
  <h1>Attendance Report</h1>
  <div class="top-right">
    <a href="home.php">Home</a> | 
    <a href="scanner.php">Scanner</a> | 
    <a href="generator.php">QR Generator</a> |
    <a href="monthlyreport.php">Monthly Report</a> |
    <a href="logout.php">Logout</a>  
  </div>
</header>
<main>
  <section>
    <h2>Summary for <?php echo $today; ?></h2>
    <p>Total students: <strong><?php echo $total; ?></strong></p>
    <p>Present: <strong><?php echo $present; ?></strong></p>
    <p>Absent: <strong><?php echo $abs; ?></strong></p>
  </section>
  <section>
    <h3>Details</h3>
    <table>
      <tr><th>Roll</th><th>Name</th><th>Status</th><th>Time</th></tr>
      <?php 
      $q=$conn->query("SELECT s.roll_no,s.name, 
      (SELECT status FROM attendance a WHERE a.student_id=s.id AND a.date='$today' ORDER BY a.id DESC LIMIT 1) status, 
      (SELECT time FROM attendance a WHERE a.student_id=s.id AND a.date='$today' ORDER BY a.id DESC LIMIT 1) tm 
      FROM students s ORDER BY s.roll_no"); 
      while($r=$q->fetch_assoc()){ 
          $st = $r['status'] ? $r['status'] : 'Absent'; 
          $t = $r['tm'] ? $r['tm'] : '-'; 
          echo '<tr><td>'.htmlspecialchars($r['roll_no']).'</td><td>'.htmlspecialchars($r['name']).'</td><td>'.htmlspecialchars($st).'</td><td>'.htmlspecialchars($t).'</td></tr>'; 
      } 
      ?>
    </table>
  </section>
</main>
</body>
</html>
