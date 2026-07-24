<?php
session_start();
include 'db.php';
if(!isset($_SESSION['teacher'])) { header('Location: login.php'); exit; }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home - School Attendance</title>
<link rel="stylesheet" href="css/style.css">
<style>
body {
  background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRTzvVF0VgxgMj7_r-pgrhiXdFYzHdu4gY04Q&s');
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
}
</style>
</head>
<body>
<header>
  <h1>Automated School Attendance-using QR</h1>
  <div class="top-right">Logged in as <?php echo htmlspecialchars($_SESSION['teacher']); ?> | <a href="generator.php">QR Generator</a> | <a href="scanner.php">Scanner</a> | <a href="report.php">Report</a> | <a href="monthlyreport.php">Monthly Report</a> | <a href="logout.php">Logout</a></div>
</header>
<main>
  <section>
    <h2>Students</h2>
    <table>
      <tr><th>Roll No</th><th>Name</th><th>class</th><th>Section</th><th>QR</th></tr>
      <?php $q=$conn->query('SELECT * FROM students ORDER BY roll_no'); while($r=$q->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($r['roll_no']); ?></td>
        <td><?php echo htmlspecialchars($r['name']); ?></td>
        <td><?php echo htmlspecialchars($r['Class']); ?></td>
        <td><?php echo htmlspecialchars($r['section']); ?></td>
        <td><?php if(file_exists(__DIR__.'/qr_images/'.$r['roll_no'].'.png')){ echo '<a href="qr_images/'.urlencode($r['roll_no']).'.png" target="_blank">View QR</a>'; } else { echo '—'; } ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </section>
</main>
</body>
</html>
