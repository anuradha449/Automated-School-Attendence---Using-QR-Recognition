<?php
session_start();
include 'db.php';

// Use phpqrcode library if available, else fallback to Google Chart API
$hasPhpQr = file_exists(__DIR__ . '/phpqrcode/qrlib.php');
if ($hasPhpQr) require_once __DIR__ . '/phpqrcode/qrlib.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll = trim($_POST['roll_no']);
    $name = trim($_POST['name']);

    if ($roll == '' || $name == '') {
        $msg = 'Please enter both fields.';
    } else {
        // Check if student exists
        $exists = $conn->query("SELECT * FROM students WHERE roll_no='$roll'");
        if ($exists->num_rows == 0) {
            $conn->query("INSERT INTO students (roll_no, name, class, section)
                          VALUES ('$roll', '$name', 'CSE', 'A')");
        }

        // Ensure QR directory exists
        $qrDir = __DIR__ . '/qr_images/';
        if (!is_dir($qrDir)) mkdir($qrDir, 0777, true);
        $filename = $qrDir . $roll . '.png';

        if ($hasPhpQr) {
            // Offline QR generation
            QRcode::png($roll, $filename, QR_ECLEVEL_L, 6, 3);
            $msg = "QR generated  for " . htmlspecialchars($name);
        } else {
            // Online fallback (Google API)
            $data = urlencode($roll);
            $url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={$data}&choe=UTF-8";
            $img = @file_get_contents($url);

            if ($img) {
                file_put_contents($filename, $img);
                $msg = "QR generated (Google API) for " . htmlspecialchars($name);
            } else {
                $msg = "Failed to generate QR: phpqrcode missing and Google API unreachable.";
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Generator</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial; padding: 20px; }
        .qr-list { display: flex; flex-wrap: wrap; gap: 15px; }
        .qr-item { text-align: center; border: 1px solid #ddd; padding: 10px; border-radius: 8px; }
        header { background: #0056b3; color: white; padding: 10px; }
        header h1 { display: inline; }
        .top-right { float: right; }
        .notice { background: #e0f3ff; padding: 8px; border: 1px solid #90caf9; border-radius: 5px; }
    </style>
</head>
<body>
<header>
    <h1>QR Generator</h1>
    <div class="top-right">
        <a href="home.php" style="color:white;">Home</a> |
        <a href="scanner.php" style="color:white;">Scanner</a> |
        <a href="report.php" style="color:white;">Report</a> |
        <a href="monthlyreport.php">Monthly Report</a> |
        <a href="logout.php" style="color:white;">Logout</a> 
    </div>
</header>

<main>
    <h2>Create student QR</h2>
    <?php if ($msg) echo '<p class="notice">' . htmlspecialchars($msg) . '</p>'; ?>
    <form method="post">
        <input name="roll_no" placeholder="Roll number (e.g. 101)" required>
        <input name="name" placeholder="Student name" required>
        <button type="submit">Generate QR & Save Student</button>
    </form>

    <h3>Existing QR images</h3>
    <div class="qr-list">
    <?php
    foreach (glob(__DIR__ . '/qr_images/*.png') as $f) {
        $fn = basename($f);
        echo '<div class="qr-item"><img src="qr_images/' . urlencode($fn) . '" width="120"><div>' . htmlspecialchars($fn) . '</div></div>';
    }
    ?>
    </div>
</main>
</body>
</html>
