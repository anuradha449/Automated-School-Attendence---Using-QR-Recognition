<?php
session_start();
include 'db.php';
if(!isset($_SESSION['teacher'])){ header('Location: login.php'); exit; }

// Set month and year (can be dynamic later)
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Fetch monthly attendance for each student
$q = $conn->query("
SELECT 
    s.roll_no, s.name,
    COUNT(CASE WHEN a.status='Present' THEN 1 END) AS days_present,
    COUNT(DISTINCT a.date) AS total_days_recorded,
    ROUND(
        (COUNT(CASE WHEN a.status='Present' THEN 1 END) / COUNT(DISTINCT a.date) * 100), 2
    ) AS percentage
FROM students s
LEFT JOIN attendance a 
    ON s.id = a.student_id AND MONTH(a.date) = $month AND YEAR(a.date) = $year
GROUP BY s.id, s.roll_no, s.name
ORDER BY s.roll_no
");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Monthly Attendance Report</title>
<link rel="stylesheet" href="css/style.css">
<style>
body {
    background-image: url('https://images.all-free-download.com/images/graphiclarge/learning_stationery_vector_293908.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
table {
    background-color: rgba(255,255,255,0.9);
    border-collapse: collapse;
    width: 90%;
    margin: 20px auto;
}
table, th, td {
    border: 1px solid #000000ff;
}
th, td {
    padding: 8px;
    text-align: center;
}
</style>
</head>
<body>
<header>
    <h1>Monthly Attendance Report</h1>
    <div class="top-right">
        <a href="home.php">Home</a> | 
        <a href="scanner.php">Scanner</a> | 
        <a href="report.php">Daily Report</a> | 
        <a href="logout.php">Logout</a>
    </div>
</header>
<main>
    <section>
        <h2><span style="color: white ;">Report for <?php echo date('F, Y', strtotime("$year-$month-01")); ?></span></h2>
        <table>
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th>Days Present</th>
                <th>Total Days</th>
                <th>Percentage</th>
            </tr>
            <?php while($row = $q->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['days_present']; ?></td>
                <td><?php echo $row['total_days_recorded']; ?></td>
                <td><?php echo $row['percentage']; ?>%</td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>
</main>
</body>
</html>
