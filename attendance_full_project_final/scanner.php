<?php session_start(); include 'db.php'; if(!isset($_SESSION['teacher'])) { header('Location: login.php'); exit; } ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scanner</title>
<link rel="stylesheet" href="css/style.css">
<script src="https://unpkg.com/html5-qrcode"></script>
<style>
body {
  background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTj93AH_hHvStEiXTdnTwPUZdd--TrHslgxMg&s');
  background-size: cover;
  background-repeat: no-repeat;
  background-attachment: fixed;
}

/* Make scanner box stand out */
.scanner {
  background-color: rgba(255, 255, 255, 0.85); /* semi-transparent white */
  padding: 20px;
  border-radius: 12px;
  max-width: 400px;
  margin: 30px auto;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}
</style>
</head>
<body>
<header>
  <h1>QR Scanner</h1>
  <div class="top-right"><a href="home.php">Home</a> | <a href="report.php">Report</a>  | <a href="monthlyreport.php">Monthly Report</a> | <a href="logout.php">Logout</a></div>
</header>
<main>
  <div class="scanner">
    <h2>Scan QR to mark attendance</h2>
    <div id="reader" style="width:360px"></div>
    <p id="result"></p>
  </div>
</main>
<script src="js/scanner.js"></script>
</body>
</html>
